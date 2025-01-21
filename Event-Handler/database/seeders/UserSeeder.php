<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                [
                    'name'=>"Lev Elek",
                    'email' => 'LevElek@gmail.com',
                    'password' => bcrypt('Admin123'),
                ],
                [
                    'name'=>"Csin Csilla",
                    'email' => 'CsinCsilla@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Cicam Ica",
                    'email' => 'CicamIca@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Chat Elek",
                    'email' => 'ChatElek@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Ceruza Elemér",
                    'email' => 'CeruzaElemer@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Egriv Áron",
                    'email' => 'EgrivAron@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Csák Ányos",
                    'email' => 'CsakAnyos@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Dia Dóra",
                    'email' => 'DiaDora@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Folyékony Szilárd",
                    'email' => 'FolyekonySzilard@gmail.com',
                    'password' => bcrypt('almafa12'),
                ],
                [
                    'name'=>"Fehér Farkas",
                    'email' => 'FeherFarkas@gmail.com',
                    'password' => bcrypt('almafa12'),
                ]
            ]);
        }
    }
}
