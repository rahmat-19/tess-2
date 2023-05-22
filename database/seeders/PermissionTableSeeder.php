<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
              
        Permission::create(
            [
                'id' => 1,
                'name' => 'manage:all',
                'description' => 'For Manage ALL API'
            ], 
        );
        
        Permission::create(
            [
                'id' => 2,
                'name' => 'create:user',
                'description' => 'For Create User'
            ],
        );

        Permission::create(
            [
                'id' => 3,
                'name' => 'read:user',
                'description' => 'For read User'
            ],
        );

        Permission::create(
            [
                'id' => 4,
                'name' => 'update:user',
                'description' => 'For update User'
            ],
        );

        Permission::create(
            [
                'id' => 5,
                'name' => 'delete:user',
                'description' => 'For delete User'
            ],
        );

        Permission::create(
            [
                'id' => 6,
                'name' => 'show:user',
                'description' => 'For show User'
            ],
        );
    }
}
