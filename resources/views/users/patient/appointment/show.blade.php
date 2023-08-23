<x-app-layout>
    <div class="w-full min-screen flex">
        <div class="w-1/6">
            <x-patient-siderbar/>
        </div>
        <div class="flex-grow flex flex-col gap-2 w-full h-full">
            <div class="w-full">
                <x-patient.navbar>
                    <x-slot name="header">
                        {{__("appointment - show")}}
                    </x-slot>
                </x-patient.navbar>
            </div>

            @if (Session::has('message'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{Session::get('message')}}</span>
              </div>
            @endif
            <div class="w-full h-96 flex justify-center items-center">
                <div class="bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 w-1/2 flex gap-2 p-2">
                    <div class="w-1/3 flex flex-col gap-2 border border-2 rounded-lg">
                        <img src="{{$appointment->service->image}}" alt="">
                        <h1 class="text-xl font-semibold text-center w-full">{{$appointment->service->name}}</h1>
                        <div class="grid grid-cols-2 grid-flows-row gap-2">
                            <div class="w-full flex justify-center">
                               <p class="text-xs text-gray-500 font-semibold">Price : <span>{{$appointment->service->price}}</span></p>
                            </div>
                            <div class="w-full flex justify-center">
                                <p class="text-xs text-gray-500 font-semibold">Price : <span>{{$appointment->service->init_payment}}</span></p>
                             </div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-2 p-2">
                        <div class="w-full flex flex-col gap-2">
                            <h1 class="text-gray-500 text-base">Patient</h1>
                            <p class="font-bold">{{$appointment->patient}}</p>
                        </div>
                        <div class="w-full flex flex-col gap-2">
                            <h1 class="text-gray-500 text-base">Schedule</h1>
                            <p class="font-bold">{{date('M-d-Y', strtotime($appointment->date)) . ' - ' . $appointment->time}}</p>
                        </div>
                        <div class="w-full flex flex-col gap-2">
                            <h1 class="text-gray-500 text-base">Status</h1>
                            <p class="font-bold">{{$appointment->status}}</p>
                        </div>
                        <div class="w-full flex flex-col gap-2">
                            <h1 class="text-gray-500 text-base">Balance</h1>
                            <p class="font-bold">{{$appointment->balance}}</p>
                        </div>
                        <div class="w-full flex justify-end">
                            <a href="{{route('patient.appointment.edit', ['appointment' => $appointment->id])}}">
                                <button class="btn btn-accent">Edit/Reschedule</button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
