<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TagihanSiswa;
use App\Models\Siswa;
use Illuminate\Support\Facades\Mail;
use App\Mail\TagihanSiswaEmail;
use Illuminate\Support\Facades\Log;

class EmailTagihan extends Command
{
    protected $signature = 'emails:send';

    protected $description = 'Send billing emails to active students with unpaid bills';

    public function handle()
    {
        try {
            // Ambil data tagihan yang jatuh tempo pada bulan dan tahun tertentu
            $data = TagihanSiswa::whereMonth('mulai_bayar', date('m'))
                                ->whereYear('mulai_bayar', date('Y'))
                                ->get();

            // Periksa apakah ada tagihan yang ditemukan
            if ($data->isEmpty()) {
                $this->info('Tidak ada tagihan untuk bulan ini.');
                return;
            }

            // Ambil semua siswa yang statusnya aktif beserta relasi kelas
            $siswa = Siswa::with('kelas')->where('status', 'AKTIF')->get();

            foreach ($siswa as $student) {
                // Ambil pembayaran siswa untuk tagihan tertentu
                $payments = $student->pembayaran->whereIn('tagihan_siswa_id', $data->pluck('id'));

                // Siapkan koleksi untuk menyimpan total pembayaran per tagihan
                $paidBills = collect();

                // Hitung total pembayaran per tagihan
                foreach ($payments as $payment) {
                    $tagihanId = $payment->tagihan_siswa_id;
                    $totalPaid = $payment->total;

                    // Tambahkan total pembayaran ke koleksi
                    if (!$paidBills->has($tagihanId)) {
                        $paidBills->put($tagihanId, $totalPaid);
                    } else {
                        $paidBills[$tagihanId] += $totalPaid;
                    }
                }

                // Ambil tagihan yang belum lunas atau masih ada sisa pembayaran
                $unpaidBills = $data->filter(function ($tagihan) use ($paidBills, $student) {
                    // Pastikan instansi_id dari tagihan cocok dengan siswa
                    if ($tagihan->instansi_id != $student->instansi_id) {
                        return false;
                    }
                    // Jika tingkat tagihan tidak sesuai dengan tingkat siswa, maka return false
                    if ($tagihan->tingkat != $student->kelas->tingkat) {
                        return false;
                    }

                    // Hitung sisa tagihan berdasarkan total pembayaran yang telah dilakukan
                    $tagihanId = $tagihan->id;
                    $nominalTagihan = $tagihan->nominal;
                    $totalPaid = $paidBills->get($tagihanId, 0);

                    return $totalPaid < $nominalTagihan;
                });

                // Cek apakah siswa memiliki tagihan yang belum lunas
                if ($unpaidBills->isNotEmpty()) {
                    // Siapkan data tagihan untuk email
                    $bills = $unpaidBills->map(function($tagihan) use ($student, $paidBills) {
                        $tagihanId = $tagihan->id;
                        $nominalTagihan = $tagihan->nominal;
                        $totalPaid = $paidBills->get($tagihanId, 0);
                        $remainingAmount = $nominalTagihan - $totalPaid;

                        return [
                            'type' => $tagihan->jenis_tagihan,
                            'amount' => $remainingAmount,
                            'due_date' => $tagihan->akhir_bayar
                        ];
                    })->toArray();

                    // Hitung total tagihan yang akan dikirimkan
                    $totalAmount = array_sum(array_column($bills, 'amount'));

                    // Pastikan email wali siswa ada sebelum mengirim email
                    if (!$student->email_wali_siswa) {
                        Log::warning('Siswa tidak memiliki email wali siswa:', ['student' => $student->nama]);
                        continue;
                    }

                    // Kirim email tagihan ke wali siswa
                    Mail::to($student->email_wali_siswa)->send(new TagihanSiswaEmail($student->nama, $bills, $totalAmount));
                    Log::info('Email tagihan dikirim ke:', ['email' => $student->email_wali_siswa]);
                }
            }

            $this->info('Billing emails sent successfully');
        } catch (\Exception $e) {
            Log::error('Error saat mengirim email tagihan:', ['error' => $e->getMessage()]);
            $this->error('Error occurred while sending billing emails');
        }
    }
}