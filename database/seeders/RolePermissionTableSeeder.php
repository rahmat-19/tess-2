<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolePermission::create([
            'role_id' => 1,
            'permission_id' => 1,
            'created_at' => '2023-05-22 15:08:48',
            'updated_at' => '2023-05-22 15:08:48'
        ]);

        RolePermission::create([
            'role_id' => 2,
            'permission_id' => 2,
            'created_at' => '2023-05-22 15:08:49',
            'updated_at' => '2023-05-22 15:08:49',
        ]);

        RolePermission::create([

            'role_id' => 2,
            'permission_id' => 3,
            'created_at' => '2023-05-22 15:08:50',
            'updated_at' => '2023-05-22 15:08:50',
        ]);

        RolePermission::create([

            'role_id' => 2,
            'permission_id' => 4,
            'created_at' => '2023-05-22 15:08:51',
            'updated_at' => '2023-05-22 15:08:51',
        ]);

        RolePermission::create([

            'role_id' => 2,
            'permission_id' => 5,
            'created_at' => '2023-05-22 15:08:52',
            'updated_at' => '2023-05-22 15:08:52',
        ]);

        RolePermission::create([

            'role_id' => 3,
            'permission_id' => 3,
            'created_at' => '2023-05-22 15:08:53',
            'updated_at' => '2023-05-22 15:08:53',
        ]);
    }
}
