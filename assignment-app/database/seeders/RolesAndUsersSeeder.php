<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create roles
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'user']);

        //Create users
        $admin = User::create([
            'name' => 'Niek',
            'email' => 'niek@email.com',
            'password' => bcrypt('password')
        ]);
        $user = User::create([
            'name' => 'Jos',
            'email' => 'jos@email.com',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole('admin');
        $user->assignRole('user');
    }
}
