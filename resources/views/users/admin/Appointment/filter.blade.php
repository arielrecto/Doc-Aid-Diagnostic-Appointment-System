<x-app-layout>
    <div class="flex h-screen">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex flex-col w-full h-full">
            <x-admin-navbar>
                <x-slot name="sample">{{ __('appointment') }}</x-slot>
            </x-admin-navbar>
            @if (Session::has('rejected'))
                <div class="w-full p-5 bg-red-500">
                    <h1 class="text-xl text-center">{{ Session::get('rejected') }}</h1>
                </div>
            @endif
            @if (Session::has('approved'))
                <div class="w-full p-5 bg-green-500">
                    <h1 class="text-xl text-center">{{ Session::get('approved') }}</h1>
                </div>
            @endif
            <div class="w-full h-full px-5">
                <div class="flex flex-col gap-2 py-5 w-full h-full">
                    <x-admin.appointment.header-selection :total="$total"/>
                    <div
                        class="w-full rounded-lg shadow-sm hover:shadow-lg duration-700 bg-base-100 h-96 flex flex-col space-y-2">
                        <div class="bg-gray-200 p-2 rounded-t-lg">
                            <h1 class="text-lg font-medium capitalize">Appointment - {{$filter}}</h1>
                        </div>
                        <div class="overflow-auto h-4/6">
                            <table class="table table-xs">
                                <thead>
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
                                            <th>1</th>
                                            <td>{{ $appointment->patient }}</td>
                                            <td>{{ $appointment->service->name }}</td>
                                            <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                            <td>{{ $appointment->time }}</td>
                                            <td>{{ $appointment->service->session_time }} mins</td>
                                            <td>{{ $appointment->status }}</td>
                                            <td>
                                                <div class="flex gap-2 p-2 items-center">

                                                    @if($appointment->status === 'pending')
                                                    <form
                                                        action="{{ route('admin.appointment.approved', ['id' => $appointment->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button
                                                            class="text-accent text-xs hover:scale-105 duration-700">
                                                            <i class="fi fi-rr-checkbox  hover:font-bold"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.appointment.reject', ['id' => $appointment->id]) }}"
                                                        method="post">

                                                        @csrf
                                                        <button class="text-error text-xs hover:scale-105 duration-700">
                                                            <i class="fi fi-rr-square-x hover:font-bold"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    <a href="{{route('admin.appointment.show', ['appointment' => $appointment->id])}}">
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
    </div>

</x-app-layout>
