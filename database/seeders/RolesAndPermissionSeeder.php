<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Contracts\Role as roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

         // Misc
        $miscPermission = Permission::create(['name' => 'N/A']);

         // create permissions
         $userPermission1 = Permission::create(['name' => 'create user ']);
         $userPermission2 = Permission::create(['name' => 'read user']);
         $userPermission3 = Permission::create(['name' => 'update user']);
         $userPermission4 = Permission::create(['name' => 'delete user']);

         $rolePermission1 = Permission::create(['name' => 'create role ']);
         $rolePermission2 = Permission::create(['name' => 'read role']);
         $rolePermission3 = Permission::create(['name' => 'update role']);
         $rolePermission4 = Permission::create(['name' => 'delete role']);

         $permission1 = Permission::create(['name' => 'create permission ']);
         $permission2 = Permission::create(['name' => 'read permission']);
         $permission3 = Permission::create(['name' => 'update permission']);
         $permission4 = Permission::create(['name' => 'delete permission']);

         $adminPermission1 = Permission::create(['name' => 'create admin']);
         $adminPermission2 = Permission::create(['name' => 'read admin']);
         $adminPermission3 = Permission::create(['name' => 'update admin']);
         $adminPermission4 = Permission::create(['name' => 'delete admin']);

         $userRole = Role::create(['name' => 'user'])->syncPermissions([
            $miscPermission,
         ]);

         $superAdminRole = Role::create(['name' => 'super-admin'])->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
            $adminPermission3,
            $adminPermission4,
         ]);


         $adminRole = role::create(['name' => 'admin'])->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
         ]);
         $managerRole = role::create(['name' => 'manager'])->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
         ]);

         User::create([
            'name' => 'super-admin',
            'is_admin' => 1,
            'is_active' => 1,
            'email' => 'super@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(16),
         ])->assignRole($superAdminRole);

         User::create([
            'name' => 'admin',
            'is_admin' => 1,
            'is_active' => 1,
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(16),
         ])->assignRole($adminRole);


         User::create([
            'name' => 'manager',
            'is_admin' => 1,
            'email' => 'manager@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(16),
         ])->assignRole($managerRole);

        for ($i=1; $i < 50; $i++ ){
            User::create([
                'name' => 'Test '.$i,
                'is_admin' => 0,
                'email' => 'test'.$i.'@test.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(16),
            ])->assignRole($userRole);
        }

    }
}
