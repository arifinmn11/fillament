<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create roles
        $superAdmin = Role::create(['name' => 'super admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $pegawaiRole = Role::create(['name' => 'pegawai']);

        // Create permissions
        $manageUsersPermission = Permission::create(['name' => 'manage users']);
        $viewReportsPermission = Permission::create(['name' => 'view reports']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo($manageUsersPermission);
        $superAdmin->givePermissionTo($viewReportsPermission);
        $adminRole->givePermissionTo($manageUsersPermission);
        $adminRole->givePermissionTo($viewReportsPermission);
        // $pegawaiRole->givePermissionTo($viewReportsPermission);
    }
}
