<x-app-layout>
    @include('layouts.navigation')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex gap-2" x-data="calendarData" x-init="initializeCalendar({{ $appointments }})">
        <div>
            <x-patient-siderbar></x-patient-siderbar>
        </div>
        <div class="py-12 flex-grow relative">

            @if (Session::has('message'))
                <div class="w-full p-5 bg-blue-500">
                    <h1 class="text-xl text-center font-bold">{{ Session::get('message') }}</h1>
                </div>
            @endif
            <div id='calendar'></div>

            <div x-show="showModal" class="absolute z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <div class="bg-white rounded-lg p-4 h-[30rem] w-[30rem]">
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
                </div>
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
                                console.log(data)
                            },
                            events : this.convertEvents(data)
                        });
                        calendar.render();
                    },
                    convertEvents(eventsData) {
                        return eventsData.map(event => ({
                            title: event.services[0].name,
                            start: new Date(event.date),
                            end: new Date(event.date),
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
