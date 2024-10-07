<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'create_book'],
            ['name' => 'edit_book'],
            ['name' => 'delete_book'],
            ['name' => 'create_user'],
            ['name' => 'edit_user'],
            ['name' => 'delete_user'],
            ['name' => 'show_user'],
            ['name' => 'create_permission'],
            ['name' => 'edit_permission'],
            ['name' => 'delete_permission'],
            // create_category

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
