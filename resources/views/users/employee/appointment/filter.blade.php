<x-app-layout>
    <div class="w-full flex h-screen">
        <x-employee.sidebar />
        <div class="flex-grow">
            <div>
                <x-employee.navbar />
            </div>
            <div class="px-2 pt-5 flex flex-col gap-2 w-full h-full">
                <div class="grid grid-cols-2 grid-flow-row gap-5">
                    <div class="w-full h-32 bg-accent shadow-sm duration-700 hover:shadow-lg rounded-lg">
                        total appointment today {{ $appointmentsTodayTotal }}
                    </div>
                    <div class="w-full h-32 bg-base-100 shadow-sm duration-700 hover:shadow-lg rounded-lg">
                        total appointment in this month {{ $appointmentByMonthTotal }}
                    </div>
                </div>

                <div
                    class="w-full bg-base-100 rounded-lg p-2 shadow-sm hover:shadow-lg duration-700 h-full flex flex-col gap-2">
                    <div class="w-full flex justify-end">
                        <form action="{{route('employee.filter')}}" method="get">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Search</span>
                                </label>
                                <label class="input-group">
                                    <input type="text" placeholder="search" name="search"
                                        class="input input-bordered" />
                                        <span class="bg-accent">
                                            <button><i class="fi fi-rr-search"></i></button>
                                        </span>
                                </label>
                            </div>
                        </form>
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
                                    <th>Service</th>
                                    <th>Schedule</th>
                                    <th>Time Slot</th>
                                    <th>Session Duration</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <th>{{ $appointment->id }}</th>
                                        <td>{{ $appointment->patient }}</td>
                                        <td>{{ $appointment->service->name }}</td>
                                        <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                        <td>{{ $appointment->time }}</td>
                                        <td>{{ $appointment->service->session_time }} mins</td>
                                        <td>{{ $appointment->status }}</td>
                                        <td>
                                            <div class="flex gap-2 p-2 items-center">
                                                <a href="#">
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
                                    <th>Schedule</th>
                                    <th>Time Slot</th>
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
