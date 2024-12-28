<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Role::create(['name' => 'user']);
        $admin = Role::create(['name' => 'admin']);

        $permissions = [
            'post_show_hidden',
            'post_show_private',
            'post_list_hidden',
            'post_list_private',
            'post_create',
            'post_delete_others',
            'post_force_delete',
            'post_update_others',
            'admin_panel',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin->syncPermissions($permissions);
        $user->syncPermissions([
            'post_show_hidden',
            'post_create',
        ]);
    }
}
