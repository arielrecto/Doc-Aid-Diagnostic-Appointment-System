<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Appointment;
use App\Models\Day;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\SubscribeService;
use Spatie\Permission\Models\Role;
use Database\Seeders\ServiceSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Factories\ServicesFactory;
use Database\Seeders\AppointmentSeeder;

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


        $daysOfWeek = [];

        $startOfWeek = Carbon::now()->startOfWeek();

        for ($i = 0; $i < Carbon::DAYS_PER_WEEK; $i++) {
            $daysOfWeek[] = $startOfWeek->copy()->addDays($i)->format('l');
        }

        collect($daysOfWeek)->map(function ($day) {
            Day::create([
                'name' => $day
            ]);
        });

        // $this->call([
        //     ServiceSeeder::class,
        //     AppointmentSeeder::class
        // ]);
    }
}
