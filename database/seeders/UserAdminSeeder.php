<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wp_users')->insert([
            'user_phone_number' => '+62895605113577',
            'user_type' => 'admin',
        ]);
    }
}
