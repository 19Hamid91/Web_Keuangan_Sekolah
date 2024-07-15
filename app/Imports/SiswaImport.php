<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SiswaImport implements ToModel, WithHeadingRow, SkipsOnError, WithMultipleSheets, WithValidation
{
    use \Maatwebsite\Excel\Concerns\SkipsErrors, \Maatwebsite\Excel\Concerns\SkipsFailures;

    protected $instansiId;

    public function __construct($instansiId)
    {
        $this->instansiId = $instansiId;
    }

    public function model(array $row)
    {
        if(!isset($row['nis'])) return redirect()->back()->with('fail', 'Format tidak sesuai');
        try {
            $student = Siswa::updateOrCreate(
                [
                    'nis' => $row['nis'],
                    'instansi_id' => $this->instansiId,
                ],
                [
                    'kelas_id' => $row['kelas_id'],
                    'nama_siswa' => $row['nama_siswa'],
                    'nohp_siswa' => $row['nohp_siswa'],
                    'alamat_siswa' => $row['alamat_siswa'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'tempat_lahir' => $row['tempat_lahir'],
                    'tanggal_lahir' => $row['tanggal_lahir'],
                    'nama_wali_siswa' => $row['nama_wali_siswa'],
                    'pekerjaan_wali_siswa' => $row['pekerjaan_wali_siswa'],
                    'nohp_wali_siswa' => $row['nohp_wali_siswa'],
                    'email_wali_siswa' => $row['email_wali_siswa'],
                    'status' => 'AKTIF',
                ]
            );

            return $student;
        } catch (\Throwable $e) {
            Log::error('Error importing row: ' . json_encode($row) . ' | Error message: ' . $e->getMessage());
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            '*.instansi_id' => 'required|exists:t_instansi,id',
            '*.kelas_id' => 'required|exists:t_kelas,id',
            '*.nama_siswa' => 'required|string',
            '*.nis' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('t_siswa', 'nis')->where('instansi_id', $this->instansiId),
            ],
            '*.alamat_siswa' => 'required|string',
            '*.jenis_kelamin' => 'required|in:laki-laki,perempuan',
            '*.tempat_lahir' => 'required|string',
            '*.tanggal_lahir' => 'required|date',
            '*.nama_wali_siswa' => 'required|string',
            '*.pekerjaan_wali_siswa' => 'required|string',
            '*.nohp_wali_siswa' => 'required|numeric|digits_between:11,13',
            '*.email_wali_siswa' => 'required|email',
        ];
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function onError(\Throwable $e)
    {
        Log::error('Error importing: ' . $e->getMessage());
        return redirect()->back()->with('fail', $e);
    }

    public function onFailure(\Throwable $e)
    {
        Log::error('Validation failure: ' . $e->getMessage());
        return redirect()->back()->with('fail', $e);
    }
}