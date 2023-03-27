<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Super Admin',
            'user_name' => 'Admin Username',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Author User',
            'user_name' => 'Author username',
            'email' => 'author@gmail.com',
            'password' => bcrypt('12345678'),
        ]);}
}
