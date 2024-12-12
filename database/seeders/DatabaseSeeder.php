<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            'post_update_others'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin->syncPermissions($permissions);
        $user->syncPermissions([
            'post_show_hidden',
            'post_create',
        ]);

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
        ])->syncRoles(['admin']);
    }
}
