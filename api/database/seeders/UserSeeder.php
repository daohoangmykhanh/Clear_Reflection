<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('account')->insert([
            'email' => 'h@gmail.com',
            'password' => bcrypt(12345),
            'role_id' => 1,
            'full_name' => 'abc',
            'phone_number' => 'abc',
        ]);
    }
}
