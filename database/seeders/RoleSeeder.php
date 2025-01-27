<?php

namespace Database\Seeders;

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
        $unverified = Role::findOrCreate('unverified');
        $user = Role::findOrCreate('user');
        $admin = Role::findOrCreate('admin');

        $permissions = [
            'post_show_hidden',
            'post_show_private',
            'post_list_hidden',
            'post_list_private',
            'post_create',
            'post_delete_others',
            'post_force_delete',
            'post_update_others',
            'post_edit_tags',
            'tag_create',
            'comment_create',
            'comment_delete_others',
            'admin_panel',
            'user_create',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $admin->syncPermissions($permissions);

        // $unverified->syncPermissions([]);

        $user->syncPermissions([
            'post_show_hidden',
            'post_create',
            'post_edit_tags',
            'tag_create',
            'comment_create',
        ]);
    }
}
