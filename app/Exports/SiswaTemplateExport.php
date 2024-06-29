<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([
            [
                '1',              
                'John Doe',       
                '123456',         
                '081234567890',   
                'Jl. Merdeka No.1',
                'laki-laki',      
                'Bandung',        
                '2005-08-17',     
                'Jane Doe',       
                'Petani',         
                '081234567891',   
            ],
            [
                '2',              
                'Alice Smith',    
                '654321',         
                '081298765432',   
                'Jl. Kebangsaan No.2',
                'perempuan',      
                'Jakarta',        
                '2006-05-10',     
                'Bob Smith',      
                'Guru',           
                '081298765433',   
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'kelas_id',
            'nama_siswa',
            'nis',
            'nohp_siswa',
            'alamat_siswa',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'nama_wali_siswa',
            'pekerjaan_wali_siswa',
            'nohp_wali_siswa',
        ];
    }
}