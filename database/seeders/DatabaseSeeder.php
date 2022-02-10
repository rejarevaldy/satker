<?php

namespace Database\Seeders;

use App\Models\Urk;
use App\Models\Panduan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
      /**
       * Seed the application's database.
       *
       * @return void
       */
      public function run()
      {
            Panduan::create(
                  [
                        'nama' => 'Cara Input Data',
                        'file' => null
                  ]
            );

            Panduan::create(
                  [
                        'nama' => 'Panduan Pelaksanaan Anggaran',
                        'file' => null
                  ]
            );

            Panduan::create(
                  [
                        'nama' => 'RKAKL',
                        'file' => null
                  ]
            );
            Panduan::create(
                  [
                        'nama' => 'Usulan Rencana Kerja',
                        'file' => null
                  ]
            );

            Urk::create(
                  [
                        'bidang' => 'Umum',
                        'file' => null
                  ]
            );
            Urk::create(
                  [
                        'bidang' =>  'PPA I',
                        'file' => null
                  ]
            );
            Urk::create(
                  [
                        'bidang' =>  'PPA II',
                        'file' => null
                  ]
            );
            Urk::create(
                  [
                        'bidang' =>  'SKKI',
                        'file' => null
                  ]
            );
            Urk::create(
                  [
                        'bidang' => 'PAPK',
                        'file' => null
                  ]
            );
      }
}
