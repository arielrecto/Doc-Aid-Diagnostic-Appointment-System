<x-app-layout>
    <div class="w-full min-h-screem m-0 p-0" x-data="create({{ $services }})">
        <div class="flex w-full h-full">
            <div class="w-1/6">
                <x-patient-siderbar></x-patient-siderbar>
            </div>
            <div class="w-full flex-grow flex flex-col gap-2 h-full">
                <x-patient.navbar>
                    <x-slot name="header">
                        {{ __('Appointent - Create') }}
                    </x-slot>
                </x-patient.navbar>

                <div class="flex flex-col gap-2 p-5 w-full h-full relative">
                    <div class="flex h-full w-full gap-2">
                        <div
                            class="flex-grow w-full h-full bg-base-100 rounded-lg shadow-sm hover:shadow-lg
                             duration-700 p-2 flex flex-col gap-2">
                            <h1 class="w-full text-lg font-semibold text-center py-2">Set Appointment</h1>
                            <form action="{{ route('patient.appointment.store') }}" method="POST"
                                class="w-full h-full flex flex-col gap-2">
                                @csrf

                                <div class="w-full flex flex-col gap-2">
                                    <label for="" class="text-xs">Patient</label>
                                    <select class="select select-accent w-full" id="interval" name="patient"
                                        @change="setTimeItervalForm">
                                        <option disabled selected>Patient</option>
                                        <option value="{{ Auth::user()->name }}">{{ Auth::user()->name }}</option>
                                        <option disabled> - Family Members - </option>
                                        @forelse ($familyMembers as $member)
                                            <option value="{{ $member->full_name }}" class="capitalize">{{ $member->full_name }}</option>
                                        @empty
                                            <option disabled class="text-xs">No Family Members</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div
                                    class="w-full border-2 border-gray-50 hover:bg-gray-50 duration-700
                                     hover:border-gray-100 rounded-lg h-full">
                                    <div class="p-2 flex flex-col gap-2">
                                        <label for="" class="text-xs">Add Service</label>
                                        <div class="flex gap-2 h-24 w-full p-2">
                                            <template x-if="selectedService !== null">
                                                <div
                                                    class="h-full w-24 bg-base-100 rounded-lg shadow-lg flex flex-col gap-2 relative">
                                                    <button class="text-xs text-accent absolute z-10 top-1 right-1"
                                                        @click="() => {selectedService = null}"> <i
                                                            class="fi fi-rr-circle-xmark"></i></button>
                                                    <img :src="selectedService.image" alt="" srcset=""
                                                        class="object-cover h-12 w-full rounded-t-lg">
                                                    <p
                                                        class="text-xs font-semibold w-full text-center"x-text="selectedService.name">
                                                    </p>
                                                    <input type="hidden" name="service" :value="selectedService.id">
                                                </div>
                                            </template>
                                            <div x-show="selectedService === null">
                                                <button @click="openToggle($event)"><i
                                                        class="fi fi-rr-add bg-accent rounded-full text-3xl flex items-center text-base-100"></i></button>
                                            </div>
                                        </div>
                                        <template x-if="selectedService !== null">
                                            <div class="w-full flex flex-col gap-2">
                                                <div class="flex flex-col gap-2">
                                                    <h1 class="text-xs">Description</h1>
                                                    <p x-html="selectedService.description" class="text-gray-400"></p>
                                                    <div class="flex gap-2">
                                                        <div class="flex flex-col gap-2">
                                                            <h1 class="text-xs">Downpayment</h1>
                                                            <p x-text="selectedService.init_payment"
                                                                class="text-gray-400 w-full text-center"></p>
                                                        </div>
                                                        <div class="flex flex-col gap-2">
                                                            <h1 class="text-xs">Price</h1>
                                                            <p x-text="selectedService.price"
                                                                class="text-gray-400 w-full text-center"></p>
                                                        </div>
                                                        <div class="flex flex-col gap-2">
                                                            <h1 class="text-xs">Session Time : </h1>
                                                            <p x-text="selectedService.session_time + ' min'"
                                                                class="text-gray-400 w-full text-center"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col gap-2">
                                                    <h1 class="w-full text-center text-sm text-gray-500 font-semibold">
                                                        Service Time Slot</h1>
                                                    <div class="grid grid-cols-2 grid-flow-row gap-2">
                                                        <div class="w-full">
                                                            <h1 class="text-xs font-semibold">Time</h1>
                                                        </div>
                                                        <div class="w-full">
                                                            <h1 class="text-xs font-semibold">Slot</h1>
                                                        </div>
                                                    </div>
                                                    <template x-for="(timeSlot, index) in selectedService.time_slot"
                                                        :key="index">
                                                        <div class="grid grid-cols-2 grid-flow-row gap-2 p-2">
                                                            <div class="w-full">
                                                                <span x-text="timeSlot.duration"
                                                                    class="text-xs text-gray-500">

                                                                </span>

                                                            </div>
                                                            <div class="w-full flex">
                                                                <span x-text="timeSlot.slot"
                                                                    class="text-xs flex-grow text-gray-500"></span>
                                                                <div>
                                                                    <template
                                                                        x-if="timeSlot.slot !== 'break' && timeSlot.slot !== 0">
                                                                        <button @click="selectSlot($event, timeSlot)">
                                                                            <p class="bg-accent w-7 rounded-full ">
                                                                                <i
                                                                                    class="fi fi-rr-add text-3xl flex items-center text-base-100">
                                                                                </i>
                                                                            </p>
                                                                        </button>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>


                                        <template x-if="selectedTimeSlot !== null">
                                            <div class="w-full flex flex-col gap-2">
                                                <label for="" class="text-xs">Selected Slot</label>
                                                <p x-text="selectedTimeSlot.duration" class="text-xs text-gray-500">

                                                </p>
                                                <input type="hidden" :value="selectedTimeSlot.duration"
                                                    name="timeSlot">
                                            </div>
                                        </template>

                                        <div class="w-full flex flex-col gap-2">
                                            <label for="" class="text-xs">Set Date</label>
                                            <input type="date" name="date"
                                                class="input input-border input-accent">
                                        </div>
                                        <div class="w-full p-2">
                                            <label for="" class="text-xs">Upload Receipt</label>
                                            <div class="w-full h-24 flex gap-2">
                                                <template x-if="image !== null">
                                                    <div class="h-full w-24 relative">
                                                        <img :src="image" alt=""
                                                            class="h-full w-full object-cover">
                                                        <button @click="closeImage($event)"
                                                            class="absolute top-1 right-1">
                                                            <i class="fi fi-rr-circle-xmark text-accent"></i>
                                                        </button>
                                                    </div>
                                                </template>
                                                <div class="h-full flex items-center">
                                                    <input type="hidden" x-model="image" name="receipt">
                                                    <label>
                                                        <input type="file" id="" class="hidden"
                                                            @change="uploadImageHandler($event)">
                                                        <p class="bg-accent w-7 rounded-full ">
                                                            <i
                                                                class="fi fi-rr-add text-3xl flex items-center text-base-100">
                                                            </i>
                                                        </p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex flex-row-reverse">
                                    <button class="btn btn-accent">Set</button>
                                </div>
                            </form>
                        </div>
                        <div class="w-1/3 h-full bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 p-2"
                            x-init="fullCalendar">
                            <div id="calendar" class="w-full h-96 text-xs">

                            </div>
                        </div>
                    </div>
                    <div class="w-full flex justify-center z-10 absolute" x-show="toggle" x-transition.duration.700ms>
                        <div class="w-1/2 flex flex-col gap-2 bg-base-100 rounded-lg shadow-lg p-2">
                            <div class="flex w-full flex-row-reverse">
                                <button @click="openToggle" class="text-accent text-lg">
                                    <i class="fi fi-rr-circle-xmark"></i>
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-2 justify-center p-2 w-full overflow-y-auto h-96">
                                <template x-for="service in services">
                                    <div class="h-44 w-44 bg-base-100 rounded-lg shadow-xl">
                                        <img :src="service.image" alt="" class="w-full h-20 object-cover">
                                        <div class="flex flex-col gap-2 w-full h-16 p-2">
                                            <span x-text="service.name" class="text-xs font-bold"></span>
                                        </div>
                                        <div class="flex p-2">
                                            <button
                                                class="px-1  rounded-lg bg-accent hover:scale-105 duration-700 text-xs mr-auto"
                                                @click="selectService(service.id, $event)">Add</button>
                                            <p x-text="service.price" class="text-sm font-semibold text-accent"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function create(data) {
                return {
                    selectedService: null,
                    services: data,
                    toggle: false,
                    image: null,
                    selectedTimeSlot: null,
                    openToggle(e) {
                        e.preventDefault();
                        this.toggle = !this.toggle
                    },
                    selectService(id, e) {
                        e.preventDefault()
                        const service = this.services.find((item) => {
                            return item.id == id
                        });

                        this.selectedService = {
                            ...service,
                            time_slot: JSON.parse(service.time_slot)
                        };

                        this.toggle = false

                        console.log(service)
                    },
                    uploadImageHandler(e) {
                        const {
                            files
                        } = e.target;

                        const reader = new FileReader();

                        reader.onload = function() {
                            this.image = reader.result
                        }.bind(this)

                        reader.readAsDataURL(files[0]);

                    },
                    fullCalendar() {
                        const cal = document.getElementById('calendar');

                        const calendar = new FullCalendar.Calendar(cal, {
                            initialView: 'dayGridMonth'
                        });
                        calendar.render()
                    },
                    closeImage(e) {
                        e.preventDefault()
                        this.image = null
                    },
                    selectSlot(e, _slot) {
                        e.preventDefault()

                        this.selectedService = {
                            ...this.selectedService,
                            time_slot: this.selectedService.time_slot.map((item) =>
                                item = item.duration === _slot.duration ?
                                item = {
                                    ...item,
                                    slot: item.slot - 1
                                } : item

                            )
                        }
                        this.selectedTimeSlot = _slot
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
