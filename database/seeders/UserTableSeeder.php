<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'super-admin@mail.com',
            'password' => bcrypt('password'),
            'kode_referal' => 1,
            'role_id' => 1
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'kode_referal' => 2,
            'role_id' => 2
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => bcrypt('password'),
            'kode_referal' => 3,
            'role_id' => 3
        ]);
    }
}
