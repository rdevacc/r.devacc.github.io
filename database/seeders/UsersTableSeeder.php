<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create User
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Get All Permissions
        $permissions = Permission::all();

        // Get Role Admin
        $role = Role::find(1);

        // Assign Permission to Role
        $role->syncPermissions($permissions);

        // Assign Role to User
        $user->assignRole($role);
    }
}
