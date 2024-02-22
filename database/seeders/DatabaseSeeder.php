<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'superadmin']);

        $role2 = Role::create(['name' => 'admin']);

        $role3 = Role::create(['name' => 'user']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Đỗ Lợi',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'check_first_login' => 1,
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Quản Trị',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'check_first_login' => 1,
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Người Dùng',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'check_first_login' => 1,
        ]);
        $user->assignRole($role3);

        $permission = Permission::create(['name' => 'create-post']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-post']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-post']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'create-category']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-category']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-category']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'create-product']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-product']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-product']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'create-color']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-color']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-color']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        
        $permission = Permission::create(['name' => 'create-type']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-type']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-type']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        
        $permission = Permission::create(['name' => 'create-brand']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-brand']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-brand']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'create-user']);
        $role1->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-user']);
        $role1->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-user']);
        $role1->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'create-role']);
        $role1->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-role']);
        $role1->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-role']);
        $role1->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'create-permission']);
        $role1->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-permission']);
        $role1->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-permission']);
        $role1->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'create-order']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit-order']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'delete-order']);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);

    }
}
