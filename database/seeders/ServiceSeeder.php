<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::factory(20)->create();


        $services = Service::all();

        collect($services)->map(function ($service){

            TimeSlot::create([
                'slots' => '[{"duration":"08:00 AM - 08:40 AM","slot":2},{"duration":"08:40 AM - 09:20 AM","slot":2},{"duration":"09:20 AM - 10:00 AM","slot":2},{"duration":"10:00 AM - 10:40 AM","slot":2},{"duration":"10:40 AM - 11:20 AM","slot":2},{"duration":"11:20 AM - 12:00 PM","slot":2},{"duration":"12:00 PM - 01:00 PM","slot":2},{"duration":"01:00 PM - 01:40 PM","slot":2},{"duration":"01:40 PM - 02:20 PM","slot":2},{"duration":"02:20 PM - 03:00 PM","slot":2},{"duration":"03:00 PM - 03:40 PM","slot":2},{"duration":"03:40 PM - 04:20 PM","slot":2},{"duration":"04:20 PM - 05:00 PM","slot":2}]',
                'service_id' => $service->id
            ]);
        });
    }
}
