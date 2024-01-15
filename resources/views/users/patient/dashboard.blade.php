<x-app-layout>
    <div class="main-screen" x-data="calendar" x-init="initializeCalendar({{ $appointments }})">
        <x-patient-siderbar />
        <div class="main-content">


            <x-patient.navbar />
            {{-- <x-patient.navbar>
                <x-slot name="header">
                    {{ __('dashboard') }}
                </x-slot>
            </x-patient.navbar> --}}

            @if (Session::has('message'))
                <div class="w-full p-5 bg-blue-500">
                    <h1 class="text-xl text-center font-bold">{{ Session::get('message') }}</h1>
                </div>
            @endif


            <div class="panel bg-opacity-0 shadow-none">

                @if (Route::is('patient.dashboard'))
                    <div class="panel overflow-hidden m-0">
                        <div class="flex-grow flex flex-col gap-2">
                            <h1 class="page-title">
                                Welcome back, {{ Auth::user()->name }}
                            </h1>
                        </div>
                    </div>
                @endif

            </div>

            <div class="panel overflow-none">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-flow-row gap-2">
                    <div class="header-selection">
                        <h1 class="header-title">Today Appointments - {{ now('GMT+8')->format('M-d-Y')}}</h1>
                        <span
                            class="text-3xl lg:text-6xl font-bold text-white truncate max-w-[250px]">{{ $todayAppointments }}</span>
                    </div>
                    <div class="header-selection bg-primary">
                        <h1 class="header-title">total appointment</h1>
                        <span
                            class="text-3xl lg:text-6xl font-bold text-white truncate max-w-[250px]">{{ count($totalAppointments) }}</span>
                    </div>
                </div>

                <div class="flex gap-2 xl:min-h-[25rem] lg:min-h-[20rem] max-h-screen overflow-hidden">
                    <div
                        class="flex-grow h-full flex flex-col gap-2 bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 p-2">
                        <h1 class="font-semibold text-sm lg:text-base">Appointments
                        </h1>
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Patient</th>
                                        <th>No. Service</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($totalAppointments as $appointment)
                                        <tr>
                                            <th>{{ $appointment->id }}</th>
                                            <th>{{ $appointment->patient }}</th>
                                            <td>{{ $appointment->subscribeServices()->count() }}</td>
                                            <td>{{ $appointment->status }}</td>
                                            <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                        </tr>
                                    @empty
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
    </div>


    @push('js')

    @endpush
</x-app-layout>
