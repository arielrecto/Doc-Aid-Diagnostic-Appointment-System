<x-app-layout>
    <div class="w-full h-screen m-0 p-0">
        <div class="flex w-full h-full">
            <div class="w-1/6">
                <x-patient-siderbar></x-patient-siderbar>
            </div>
            <div class="flex-grow h-full w-full flex flex-col gap-2">
                <x-patient.navbar>
                    <x-slot name="header">
                        {{ __('Appointment - List') }}
                    </x-slot>
                </x-patient.navbar>

                <div class="flex w-full p-5 flex-col space-y-2 h-full">
                    <div class="w-full grid grid-cols-2 grid-flow-row gap-2">
                        <div class="h-32 w-full bg-accent rounded-lg shadow-sm hover:shadow-lg duration-700">

                        </div>
                        <div class="h-32 w-full bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700">

                        </div>
                    </div>
                    <div class="w-full rounded-lg bg-base-100 shadow-sm hover:shadow-lg duration-700 h-full">
                        <div class="flex flex-col gap-2 border-b-2 border-gray-100">
                            <div class="flex w-full p-2">
                                <div class="flex-grow flex items-center">
                                    <h1 class="font-semibold">Appointment - {{$appointments->count()}}</h1>
                                </div>
                                <div class="w-1/3">
                                    <div class="form-control">
                                        <label class="input-group">
                                            <input type="text" placeholder="search"
                                                class="input input-bordered text-xs w-full input-border input-accent" />
                                            <span class="bg-accent text-base-100"><i class="fi fi-rr-search"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex flex-row-reverse p-2">
                                <div class="flex flex-row-reverse w-1/5">
                                    <a href="{{ route('patient.appointment.create') }}">
                                        <button class="capitalized btn btn-accent">Add New Appointment</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="w-full h-full p-2">
                            <div class="overflow-x-auto h-64 w-full">
                                <table class="table">
                                    <!-- head -->
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Service</th>
                                            <th>Date</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($appointments as $appointment)
                                            <tr>
                                                <th>{{ $appointment->id }}</th>
                                                <td>{{ $appointment->service->name }}</td>
                                                <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                                <td>
                                                    <p  class="{{$appointment->status === 'pending' ? 'bg-orange-300' : ($appointment->status === 'approve' ? 'bg-accent' : 'bg-red-400')}}
                                                        py-1 px-2 rounded-lg w-16 text-center">
                                                        {{ $appointment->status }}
                                                    </p>

                                                </td>
                                            </tr>
                                        @empty

                                            <tr>
                                                <th>NO ITEM</th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
