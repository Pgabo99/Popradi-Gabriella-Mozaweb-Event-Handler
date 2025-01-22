<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InviteesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('invitees')->count() == 0) {
            DB::table('invitees')->insert([
                [
                    'user_id' => 5,
                    'event_id'=>2,
                    'confirmed' => 'yes',
                ],
                [
                    'user_id' => 4,
                    'event_id'=>2,
                    'confirmed' => 'yes',
                ],
                [
                    'user_id' => 5,
                    'event_id'=>1,
                    'confirmed' => 'yes',
                ],
                [
                    'user_id' => 4,
                    'event_id'=>4,
                    'confirmed' => 'yes',
                ],
                [
                    'user_id' => 3,
                    'event_id'=>2,
                    'confirmed' => 'yes',
                ]
                
            ]);
        }
    }
}
