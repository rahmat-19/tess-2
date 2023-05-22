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
                'name' => 'manage:all',
                'description' => 'For Manage ALL API'
            ], 
        );
        
        Permission::create(
            [
                'name' => 'create:user',
                'description' => 'For create User'
            ],
        );

        Permission::create(
            [
                'name' => 'read:user',
                'description' => 'For read User'
            ],
        );

        Permission::create(
            [
                'name' => 'update:user',
                'description' => 'For update User'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:user',
                'description' => 'For delete User'
            ],
        );

        Permission::create(
            [
                'name' => 'show:user',
                'description' => 'For show User'
            ],
        );

        Permission::create(
            [
                'name' => 'create:preweddingimages',
                'description' => 'For create preweddingimages'
            ],
        );

        Permission::create(
            [
                'name' => 'read:preweddingimages',
                'description' => 'For read preweddingimages'
            ],
        );

        Permission::create(
            [
                'name' => 'update:preweddingimages',
                'description' => 'For update preweddingimages'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:preweddingimages',
                'description' => 'For delete preweddingimages'
            ],
        );

        Permission::create(
            [
                'name' => 'show:preweddingimages',
                'description' => 'For show preweddingimages'
            ],
        );

        Permission::create(
            [
                'name' => 'create:eventuser',
                'description' => 'For create eventuser'
            ],
        );

        Permission::create(
            [
                'name' => 'read:eventuser',
                'description' => 'For read eventuser'
            ],
        );

        Permission::create(
            [
                'name' => 'update:eventuser',
                'description' => 'For update eventuser'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:eventuser',
                'description' => 'For delete eventuser'
            ],
        );

        Permission::create(
            [
                'name' => 'show:eventuser',
                'description' => 'For show eventuser'
            ],
        );

        Permission::create(
            [
                'name' => 'create:rekening',
                'description' => 'For create rekening'
            ],
        );

        Permission::create(
            [
                'name' => 'read:rekening',
                'description' => 'For read rekening'
            ],
        );

        Permission::create(
            [
                'name' => 'update:rekening',
                'description' => 'For update rekening'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:rekening',
                'description' => 'For delete rekening'
            ],
        );

        Permission::create(
            [
                'name' => 'show:rekening',
                'description' => 'For show rekening'
            ],
        );

        Permission::create(
            [
                'name' => 'create:role',
                'description' => 'For create role'
            ],
        );

        Permission::create(
            [
                'name' => 'read:role',
                'description' => 'For read role'
            ],
        );

        Permission::create(
            [
                'name' => 'update:role',
                'description' => 'For update role'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:role',
                'description' => 'For delete role'
            ],
        );

        Permission::create(
            [
                'name' => 'show:role',
                'description' => 'For show role'
            ],
        );

        Permission::create(
            [
                'name' => 'create:greeting',
                'description' => 'For create greeting'
            ],
        );

        Permission::create(
            [
                'name' => 'read:greeting',
                'description' => 'For read greeting'
            ],
        );

        Permission::create(
            [
                'name' => 'update:greeting',
                'description' => 'For update greeting'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:greeting',
                'description' => 'For delete greeting'
            ],
        );

        Permission::create(
            [
                'name' => 'show:greeting',
                'description' => 'For show greeting'
            ],
        );

        Permission::create(
            [
                'name' => 'create:permission',
                'description' => 'For create permission'
            ],
        );

        Permission::create(
            [
                'name' => 'read:permission',
                'description' => 'For read permission'
            ],
        );

        Permission::create(
            [
                'name' => 'update:permission',
                'description' => 'For update permission'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:permission',
                'description' => 'For delete permission'
            ],
        );

        Permission::create(
            [
                'name' => 'show:permission',
                'description' => 'For show permission'
            ],
        );

        Permission::create(
            [
                'name' => 'create:subdomain',
                'description' => 'For create subdomain'
            ],
        );

        Permission::create(
            [
                'name' => 'read:subdomain',
                'description' => 'For read subdomain'
            ],
        );

        Permission::create(
            [
                'name' => 'update:subdomain',
                'description' => 'For update subdomain'
            ],
        );

        Permission::create(
            [
                'name' => 'delete:subdomain',
                'description' => 'For delete subdomain'
            ],
        );

        Permission::create(
            [
                'name' => 'show:subdomain',
                'description' => 'For show subdomain'
            ],
        );

        Permission::create(
            [
                'name' => 'read:rolepermission',
                'description' => 'For read role permission'
            ],
        );

        Permission::create(
            [
                'name' => 'update:rolepermission',
                'description' => 'For update role permission'
            ],
        );

        Permission::create(
            [
                'name' => 'read:rekeninguser',
                'description' => 'For read rekening user'
            ],
        );

        Permission::create(
            [
                'name' => 'update:rekeninguser',
                'description' => 'For update rekening user'
            ],
        );
    }
}
