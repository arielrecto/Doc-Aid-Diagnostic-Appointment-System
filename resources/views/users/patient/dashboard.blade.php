<x-app-layout>
    <div class="main-screen" x-data="calendarData" x-init="initializeCalendar({{ $appointments }})">
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
                    <div class="panel overflow-hidden">
                        <div class="flex-grow flex flex-col gap-2">
                            <h1 class="page-title">
                                Welcome back, {{ Auth::user()->name }}
                            </h1>
                        </div>
                    </div>
                @endif
                <div class="panel h-5/6 overflow-hidden">
                    <h1 class="page-title text-lg">
                        Services
                    </h1>
                    <div class="">
                        @forelse ($services as $service)
                            <div class="w-64 h-full bg-base-100 rounded-lg flex flex-col m-auto shadow-xl">
                                <img src="{{ $service->image }}" alt="" srcset=""
                                    class="w-full h-4/6 object-cover rounded-t-lg object-top">
                                <div class="p-2 flex flex-col gap-2">
                                    <h1 class="text-lg font-bold h-16">{{ $service->name }}</h1>
                                    <div class="flex">
                                        {{-- <button
                                            class="bg-accent px-2 py-1 rounded-lg text-base-100 hover:scale-105 duration-700 text-xs mr-auto">Set
                                            Appointment</button> --}}
                                        <p class="text-accent text-base font-semibold">{{ $service->price }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="panel">
                    <div class="grid grid-cols-2 grid-flow-row gap-2">
                        <div class="header-selection">
                            <h1 class="header-title">total appointment today </h1>
                            <span
                                class="text-6xl font-bold text-white truncate max-w-[250px]">{{ $todayAppointments->count() }}</span>
                        </div>
                        <div class="w-full bg-base-100 h-32 rounded-lg shadow-sm hover:shadow-lg duration-700">

                        </div>
                    </div>

                    <div class="flex gap-2">
                        <div
                            class="flex-grow h-full flex flex-col gap-2 bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 p-2">
                            <h1 class="font-semibold text-base">Today Appointment - {{ now('GMT+8')->format('M-d-Y') }}
                            </h1>
                            <div class="overflow-x-auto">
                                <table class="table table-zebra">
                                    <!-- head -->
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Patient</th>
                                            <th>No. Service</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($todayAppointments as $appointment)
                                            <tr>
                                                <th>{{ $appointment->id }}</th>
                                                <th>{{ $appointment->patient }}</th>
                                                <td>{{ $appointment->subscribeServices()->count() }}</td>
                                                <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="w-1/3 h-full bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 p-2">
                            <div id="calendar" class="w-full h-full text-xs fc-bg-event">

                            </div>
                        </div>
                    </div>
                </div>


            </div>


            {{-- <div id='calendar'></div>


            <div x-show="showModal" class="absolute z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <div class="bg-base-100 rounded-lg p-5 w-[42rem]">
                    <div class="w-full flex flex-col gap-2">
                        <div>
                            <h1>date : <span x-text="clickedDate === null ? '' : clickedDate.toDateString()"></span></h1>
                        </div>
                        <h1 class="text-lg font-bold gap-2 text-center w-full">
                            Time Slot
                        </h1>
                        @forelse ($timeInterval as $_timeInterval)
                            <div class="w-full">
                                <h1>{{ $_timeInterval }}</h1>
                            </div>
                        @empty
                            <h1>not set</h1>
                        @endforelse
                    </div>
                </div> --}}

            {{-- <div class="bg-white rounded-lg p-4 h-[30rem] w-[30rem]">
                    <h2 class="text-lg font-bold mb-2">Clicked Date:</h2>
                    <p x-text="clickedDate.toDateString()" class="text-gray-700"></p>
                    <h1 class="text-center text-xl font-bold">
                        Set Appointment
                    </h1>
                    <form action="{{ route('patient.appointment.store') }}" method="post" class="flex flex-col gap-2">
                        @csrf
                        <div class="w-full">
                            <input type="hidden" name="appointment_date" x-model:value="clickedDate.toDateString()">
                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 ">Select
                                Time</label>
                            <select id="countries" name="time" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                 ">
                                <option selected>Choose a Time</option>
                                <option value="7:00 AM - 8:00 AM">7:00 AM - 8:00 AM</option>
                                <option value="8:00 AM - 9:00 AM">8:00 AM - 9:00 AM</option>
                                <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                                <option value="11:00 - 12:00">11:00 AM - 12:00 NN</option>
                                <option value="11:00 - 12:00">12:00 NN - 1:00 PM</option>
                                <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                                <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                                <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label for="countries"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Services</label>
                            <select id="countries" name="service" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                 ">
                                <option selected>Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->name }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 ">Type of
                            Service</label>
                        <select id="countries" name="type" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                             ">
                            <option selected>Select Service type</option>

                            <option value="Walk In">Walk In</option>
                            <option value="Drive Thru">Drive Thru</option>
                            <option value="Home Service">Home Service</option>
                        </select>

                        <div class="flex gap-2 ">
                            <button class="px-4 py-2 bg-blue-500">Add Appointment</button>
                            <a @click="showModal = false" class="px-4 py-2 bg-red-300">Close</a>
                        </div>

                    </form>
                </div> --}}
        </div>
    </div>
    </div>
    </div>


    @push('js')
        <script>
            function calendarData() {
                return {
                    showModal: false,
                    clickedDate: null,
                    initializeCalendar(data) {
                        var calendarEl = document.getElementById('calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            dateClick: (info) => {
                                this.clickedDate = info.date;
                                this.showModal = true;
                                console.log(this.clickedDate.toDateString())
                            },
                            events: this.convertEvents(data)
                        });
                        calendar.render();
                    },
                    convertEvents(eventsData) {
                        return eventsData.map(event => ({
                            title: event.patient,
                            start: new Date(event.date),
                            end: new Date(event.date),
                            backgroundColor: event.status === 'pending' ? '#fbbd23' : event.status === 'approved' ?
                                '#04ABA3' : '#f87272'
                        }));
                    }
                };
            }
        </script>
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    dateClick: function(info) {
                        alert('a day has been clicked');
                    }
                });
                calendar.render();
            });
        </script> --}}
    @endpush
</x-app-layout>
