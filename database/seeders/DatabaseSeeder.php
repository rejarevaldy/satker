<?php

namespace Database\Seeders;

use App\Models\Urk;
use App\Models\User;
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
            User::create(
                [
                    'nama' => 'monitor',
                    'username' => 'monitor',
                    'password' => bcrypt('monitor'),
                    'nip' => '12344567890',
                    'gender' => 'Pria',
                    'role' => 'Monitoring',
                ]
            );

            User::create(
                [
                    'nama' => 'satker',
                    'username' => 'satker',
                    'password' => bcrypt('satker'),
                    'nip' => '12344567890',
                    'gender' => 'Wanita',
                    'role' => 'Satker',
                ]
            );

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
