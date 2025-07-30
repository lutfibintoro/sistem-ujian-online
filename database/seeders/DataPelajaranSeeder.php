<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelajaran')->insert([
            ['nama_pelajaran' => 'Matematika'],
            ['nama_pelajaran' => 'Bahasa Inggris'],
            ['nama_pelajaran' => 'Kimia'],
            ['nama_pelajaran' => 'Ilmu Pengetahuan Alam'],
            ['nama_pelajaran' => 'Ilmu Pengetahuan Sosial'],
            ['nama_pelajaran' => 'Fisika'],
            ['nama_pelajaran' => 'Pendidikan Kewarganegaraan'],
            ['nama_pelajaran' => 'Pendidikan Jasmani dan Kesehatan'],
            ['nama_pelajaran' => 'Seni Budaya'],
            ['nama_pelajaran' => 'Prakarya'],
            ['nama_pelajaran' => 'Biologi'],
            ['nama_pelajaran' => 'Ekonomi'],
            ['nama_pelajaran' => 'Bahasa Indonesia'],
            ['nama_pelajaran' => 'Geografi'],
            ['nama_pelajaran' => 'Sejarah'],
            ['nama_pelajaran' => 'TIK (Teknologi Informasi dan Komunikasi)'],
            ['nama_pelajaran' => 'Bahasa Jawa'],
            ['nama_pelajaran' => 'Bahasa Arab'],
            ['nama_pelajaran' => 'Sosiologi'],
            ['nama_pelajaran' => 'Antropologi'],
        ]);
    }
}
