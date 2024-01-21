<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />

        <div class="main-content">
            <x-admin.navbar-new />

            @if (Session::has('rejected'))
                <div class="panel-error">
                    <span>
                        {{ Sessiong::get('rejected') }}
                    </span>
                </div>
            @endif
            @if (Session::has('approved'))
                <div class="panel-success">
                    <span>
                        {{ Sessiong::get('approved') }}
                    </span>
                </div>
            @endif

            <div class="panel overflow-y-auto">
                <h1 class="page-title">Appointments</h1>
                <div class="flex flex-col gap-2 py-5 w-full h-full">
                    <x-admin.appointment.header-selection :total="$total" :pending="$totalPending" :approved="$totalApproved"
                        :done="$totalDone" />

                    <div class="w-full h-96 panel p-0 border-accent border space-y-2">
                        <div class="bg-gray-200 p-2 rounded-t-lg">

                        </div>
                        <div class="overflow-auto h-4/6">
                            <table class="table table-xs">
                                <thead>
                                    <tr>
                                        {{-- <th></th> --}}
                                        <th>Patient</th>
                                        <th>No. Service</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($appointments as $appointment)
                                        <tr>
                                            {{-- <th>1</th> --}}
                                            <td>{{ $appointment->patient }}</td>
                                            <td>{{ $appointment->subscribeServices()->count() }}</td>
                                            <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                            {{-- <td>{{ $appointment->time }}</td>
                                            <td>{{ $appointment->service->session_time }} mins</td> --}}
                                            <td>{{ $appointment->status }}</td>
                                            <td>
                                                <div class="flex gap-2 p-2 items-center">

                                                    <a
                                                        href="{{ route('admin.appointment.show', ['appointment' => $appointment->id]) }}">
                                                        <button
                                                            class="text-blue-500 text-xs hover:scale-105 duration-700">
                                                            <i class="fi fi-rr-eye hover:font-bold"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Patient</th>
                                        <th>No. Service</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="panel relative" x-data="calendar(`{{ Auth::user()->roles()->first()->name }}`)" x-init="initializeCalendar({{ $calendarAppointment }})">
                        <div id="calendar">

                        </div>
                        <div
                            class="w-full h-full absolute z-20 top-0 backdrop-blur-sm flex justify-center items-center" x-show="toggle">
                            <div class="w-4/6 h-1/2 bg-gray-50 shadow-lg rounded-lg p-2 flex flex-col gap-2">
                                <div class="flex justify-between">
                                    <h1 class="page-title">Appointments</h1>
                                    <button class="text-error text-xs hover:scale-105 duration-700" @click="toggle = false">
                                        <i class="fi fi-rr-square-x hover:font-bold"></i>
                                    </button>
                                </div>
                                <div class="w-full h-full overflow-y-auto">
                                    <template x-if="appointments.length !== 0">
                                        <template x-for="appointment in appointments" :key="appointment.id">
                                            <div
                                                class="w-full p-2 rounded-lg border-2 border-gray-100 flex items-center justify-between">
                                                <h1 class="text-sm font-bold flex items-center gap-2">
                                                    <span>Patient:</span>
                                                    <span class="font-normal" x-text="appointment.patient"></span>
                                                </h1>
                                                <div class="flex items-center gap-5">

                                                    <h1 class="text-sm font-bold flex items-center gap-2">
                                                        <span>Service:</span>
                                                        <span class="font-normal" x-text="appointment.subscribe_services[0].service.name"></span>
                                                    </h1>
                                                    <h1 class="text-sm font-bold flex items-center gap-2">
                                                        <span>Time:</span>
                                                        <div class="flex items-center text-xs">
                                                            <span class="font-normal" x-text="timeFormat(appointment.subscribe_services[0].start_time)"></span> -
                                                            <span class="font-normal" x-text="timeFormat(appointment.subscribe_services[0].end_time)"></span>
                                                        </div>
                                                    </h1>

                                                    <h1 class="text-sm font-bold flex items-center gap-2">
                                                        <span>Status:</span>
                                                        <span class="font-normal" x-text="appointment.status"></span>
                                                    </h1>
                                                    <a :href="`/admin/appointment/${appointment.id}`" class="btn-generic">
                                                        view
                                                    </a>
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                    <template x-if="appointments.length === 0">
                                        <div>
                                            <h1 class="text-center">No Appointments </h1>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
