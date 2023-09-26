<x-app-layout>
    <div class="main-screen">
        <x-patient-siderbar />
        <div class="main-content">
            <x-patient.navbar />
            <div class="panel">
                <div class="page-title">
                    <h1 class="font-semibold">Appointments</h1>
                </div>
            </div>
            <div class="panel">
                {{-- <x-patient.navbar>
                    <x-slot name="header">
                        {{ __('Appointment - List') }}
                    </x-slot>
                </x-patient.navbar> --}}
                <div class="flex w-full p-5 flex-col space-y-2 h-full">
                    <div class="w-full grid grid-cols-2 grid-flow-row gap-2">
                        <div class="header-selection bg-accent">
                            <h1 class="header-title">total appointment</h1>
                            <span
                                class="text-6xl font-bold text-white truncate max-w-[250px]">{{ $appointments->count() }}</span>
                        </div>
                        {{-- <div class="header-selection">

                        </div> --}}
                    </div>
                    <div class="w-full rounded-lg bg-base-100 shadow-sm hover:shadow-lg duration-700 h-full">
                        <div class="flex flex-col gap-2 border-b-2 border-gray-100">
                            {{-- <div class="flex w-full p-2 justify-end">
                                <div class="w-1/3">
                                    <div class="form-control">
                                        <label class="input-group">
                                            <input type="text" placeholder="search"
                                                class="input input-bordered text-xs w-full input-border input-accent" />
                                            <span class="bg-accent text-base-100"><i class="fi fi-rr-search"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="w-full flex justify-between p-2">

                                <label class="input-group max-w-lg">
                                    <input type="text" placeholder="search"
                                        class="w-1/2 input-generic rounded-lg" />
                                    <span class="bg-accent text-base-100"><i class="fi fi-rr-search"></i></span>
                                </label>


                                <a href="{{ route('patient.appointment.create') }}">
                                    <button class="capitalized btn btn-accent">Add New Appointment</button>
                                </a>
                            </div>
                        </div>
                        <div class="w-full h-full p-2">
                            <div class="overflow-x-auto h-64 w-full">
                                <table class="table">
                                    <!-- head -->
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Patient</th>
                                            <th>No. Services</th>
                                            <th>Date</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($appointments as $appointment)
                                            <tr>
                                                <th>{{ $appointment->id }}</th>
                                                <th>{{ $appointment->patient }}</th>
                                                <td><a
                                                        href="{{ route('patient.appointment.show', ['appointment' => $appointment->id]) }}">
                                                        {{ $appointment->subscribeServices()->count() }}</a>
                                                </td>
                                                <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                                <td>
                                                    <div class="flex justify-center w-full">
                                                        <p
                                                            class="{{ $appointment->status === 'pending' ? 'bg-orange-300' : ($appointment->status === 'approved' ? 'bg-accent' : 'bg-red-400') }}
                                                            p-2 rounded-lg text-center capitalize">
                                                            {{ $appointment->status }}
                                                        </p>
                                                    </div>
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
