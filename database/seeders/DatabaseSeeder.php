<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Database\Factories\ServicesFactory;
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

        Service::factory(20)->create();

        Appointment::factory(200)->create();

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
