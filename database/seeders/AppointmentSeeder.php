<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
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

        Appointment::factory(20)->create();

        SubscribeService::factory(Appointment::count())->create();


            collect($this->appointment->get())->map(function ($item) {
            if ($item->subscribeService === null) {
                SubscribeService::create([
                    'appointment_id' => $item->id,
                    'service_id' => fake()->numberBetween(1, $this->service->count()),
                    'start_time' => fake()->time("H:i"),
                    'end_time' => fake()->time('H:i')
                ]);
            }
        });


        $appointments = Appointment::whereStatus(AppointmentStatus::DONE->value)->get();

        collect($appointments)->map(function($appointment){
            $services = $appointment->subscribeServices()->get();
            foreach($services as $sub_service){
                $appointment->update([
                    'total' => $sub_service->service->price,
                    'balance' => 0
                ]);
            }
        });
    }
}
