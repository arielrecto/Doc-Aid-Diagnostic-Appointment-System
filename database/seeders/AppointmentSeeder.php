<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\SubscribeService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function __construct(public Appointment $appointment, public Service $service)
    {
    }
    public function run(): void
    {

        Appointment::factory(200)->create();

        SubscribeService::factory(Appointment::count())->create();

        foreach ($this->appointment->get() as $appointment) {
           if($appointment->subscribeService === null) {
                SubscribeService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $this->service->first()->id,
                    'start_time' => fake()->time("H:i"),
                    'end_time' => fake()->time('H:i')
                ]);
           }
        }
    }
}
