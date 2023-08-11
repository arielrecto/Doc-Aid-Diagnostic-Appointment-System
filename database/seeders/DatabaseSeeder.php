<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('ariel123')
        ]);

        $adminRole = Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'patient'
        ]);
        $employeeRole  = Role::Create([
            'name' => 'employee'
        ]);

        $employee = User::create([
            'name' => 'employee one',
            'email' => 'employee@employee.com',
            'password' => Hash::make('ariel123')
        ]);

       $admin->assignRole($adminRole);

       $employee->assignRole($employeeRole);
    }
}
