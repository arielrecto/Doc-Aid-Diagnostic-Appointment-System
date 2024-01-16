@php
    use App\Enums\AppointmentStatus;
@endphp

<x-app-layout>
    <div class="main-screen">
        <x-employee.sidebar />
        <div class="flex-grow">
            <div>
                <x-employee.navbar />
            </div>
            <div class="px-1 pt-5 flex flex-col gap-2 w-full h-full">
                <div class="grid grid-cols-2 grid-flow-row gap-5">
                    {{-- <div class="panel h-36 bg-accent">
                        total appointment today {{ $appointmentsTodayTotal }}
                    </div> --}}

                    <div class="header-selection bg-accent">
                        <div class="header-title">
                            <i class="fi fi-rr-person-dolly"></i>
                            appointment today
                        </div>

                        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
                            {{  $appointmentsTodayTotal  }}
                        </span>
                    </div>

                    <div class="header-selection bg-secondary">
                        <div class="header-title">
                            <i class="fi fi-rr-person-dolly"></i>
                            appointments {{now()->format('F')}}
                        </div>

                        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
                            {{$appointmentByMonthTotal }}
                        </span>
                    </div>

                    {{-- <div class="w-full h-32 bg-base-100 shadow-sm duration-700 hover:shadow-lg rounded-lg">
                        total appointment in this month {{ $appointmentByMonthTotal }}
                    </div> --}}
                </div>
                <div
                    class="panel">
                    <div class="w-full flex justify-end">
                        <div class="flex items-center gap-2">
                            <a href="{{route('employee.dashboard')}}" class="btn btn-sm btn-primary">All</a>
                            <form action="{{ route('employee.dashboard') }}" method="get">
                                <input type="hidden" name="filter" value="{{AppointmentStatus::PENDING->value}}">
                                <button class="btn btn-accent btn-sm">Pending</button>
                            </form>
                            <form action="{{ route('employee.dashboard') }}" method="get">
                                <input type="hidden" name="filter" value="{{AppointmentStatus::APPROVED->value}}">
                                <button class="btn btn-secondary btn-sm">Approved</button>
                            </form>
                            <form action="{{ route('employee.dashboard') }}" method="get">
                                <input type="hidden" name="filter" value="{{AppointmentStatus::DONE->value}}">
                                <button class="btn btn-success btn-sm">Done</button>
                            </form>
                            <form action="{{ route('employee.filter') }}" method="get">
                                <div class="form-control">
                                    <label class="input-group">
                                        <input type="text" placeholder="search" name="search"
                                            class="input bg-white border focus:outline-none shadow" />
                                        <span class="bg-accent">
                                            <button><i class="fi fi-rr-search"></i></button>
                                        </span>
                                    </label>
                                </div>
                            </form>
                        </div>

                        {{-- <form method="post" action="w-full flex gap-2">
                            <div class="w-full grid grid-cols-6 grid-flow-row gap-2">
                                <select class="select select-accent w-full max-w-xs">
                                    <option disabled selected>Id</option>
                                    <option>Auto</option>
                                    <option>Dark mode</option>
                                    <option>Light mode</option>
                                </select>
                                <select class="select select-accent w-full max-w-xs">
                                    <option disabled selected>Month</option>
                                    <option>Auto</option>
                                    <option>Dark mode</option>
                                    <option>Light mode</option>
                                </select>
                                <select class="select select-accent w-full max-w-xs">
                                    <option disabled selected>Year</option>
                                    <option>Auto</option>
                                    <option>Dark mode</option>
                                    <option>Light mode</option>
                                </select>
                                <button class="btn btn-accent">Filter</button>
                            </div>
                        </form> --}}
                    </div>
                    <div class="overflow-auto h-4/6 relative">
                        <div class="sticky">
                            {{ $appointments->links() }}
                        </div>
                        <table class="table table-xs">
                            <thead class="sticky">
                                <tr>
                                    <th></th>
                                    <th>Patient</th>
                                    <th>No. Service</th>
                                    <th>Schedule</th>
                                    {{-- <th>Time Slot</th> --}}
                                    {{-- <th>Session Duration</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <th>{{ $appointment->id }}</th>
                                        <td>{{ $appointment->patient }}</td>
                                        <td>{{ $appointment->subscribeServices()->count() }}</td>
                                        <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                        {{-- <td>{{ $appointment->time }}</td> --}}
                                        {{-- <td>{{ $appointment->service->session_time }} mins</td> --}}
                                        <td>{{ $appointment->status }}</td>
                                        <td>
                                            <div class="flex gap-2 p-2 items-center">
                                                <a
                                                    href="{{ route('employee.appointment.show', ['Appointment' => $appointment->id]) }}">
                                                    <button class="text-blue-500 text-xs hover:scale-105 duration-700">
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
                                    <th>Service</th>
                                    {{-- <th>Schedule</th>
                                    <th>Time Slot</th> --}}
                                    <th>Session Duration</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
