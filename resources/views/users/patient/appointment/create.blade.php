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

                @if (Session::has('message'))
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ Session::get('message') }}</span>
                    </div>
                @endif

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
                                            <option value="{{ $member->full_name }}" class="capitalize">
                                                {{ $member->full_name }}</option>
                                        @empty
                                            <option disabled class="text-xs">No Family Members</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div
                                    class="w-full border-2 border-gray-50 hover:bg-gray-50 duration-700
                                     hover:border-gray-100 rounded-lg h-full">
                                    <div class="p-2 flex flex-col gap-2">
                                        <div class="flex justify-between">
                                            <label for="" class="text-xs">Add Service</label>
                                            <div>
                                                <button @click="openToggle($event)"><i
                                                        class="fi fi-rr-add bg-accent rounded-full text-3xl flex items-center text-base-100"></i></button>
                                            </div>
                                        </div>
                                        <template x-if="selectedService.length > 0">
                                            <div class="flex gap-2 h-auto max-h-sx w-full p-2 overflow-y-auto">
                                                <div class="w-full h-24">
                                                    <table class="table table-xs">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Service</th>
                                                                <th>Time</th>
                                                                <th>price</th>
                                                                <th>Downpayment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <template x-for="service in selectedService"
                                                                :key="service.id">
                                                                <tr>
                                                                    <th>1</th>
                                                                    <td><span x-text="service.name"></span></td>
                                                                    <td><span
                                                                            x-text="service?.selectedSlot?.duration"></span>
                                                                    </td>
                                                                    <td>&#8369 <span x-text="service.price"></span></td>
                                                                    <td>&#8369 <span
                                                                            x-text="service.init_payment"></span></td>
                                                                    <td>
                                                                        <button
                                                                            @click="openDetail($event, service.id)">open</button>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                            <input type="hidden" name="services" :value="JSON.stringify(selectedService)">
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th>Service</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="sDetailID !== null  ">
                                            <div class="w-full flex flex-col gap-2">
                                                <div class="flex flex-col gap-2">
                                                    <h1 class="text-xs">Service</h1>
                                                    <p x-html="sPreview.name" class="text-gray-400"></p>
                                                    <h1 class="text-xs">Description</h1>
                                                    <p x-html="sPreview.description" class="text-gray-400"></p>
                                                    <div class="flex gap-2">
                                                        <div class="flex flex-col gap-2">
                                                            <h1 class="text-xs">Downpayment</h1>
                                                            <p x-text="sPreview.init_payment"
                                                                class="text-gray-400 w-full text-center"></p>
                                                        </div>
                                                        <div class="flex flex-col gap-2">
                                                            <h1 class="text-xs">Price</h1>
                                                            <p x-text="selectedService.price"
                                                                class="text-gray-400 w-full text-center"></p>
                                                        </div>
                                                        <div class="flex flex-col gap-2">
                                                            <h1 class="text-xs">Session Time : </h1>
                                                            <p x-text="sPreview.session_time + ' min'"
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
                                                    <div class="w-full flex justify-end">
                                                        <button @click="openToggleTimeSlot($event)">Minimize</button>
                                                    </div>
                                                    <template x-if="toggleTimeSlot">
                                                        <div class="w-full flex flex-col gap-2">
                                                            <template x-for="(timeSlot, index) in sPreview.time_slot"
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

                                                                                <template
                                                                                    x-if="selectedTimeSlot === null">
                                                                                    <button
                                                                                        @click="selectSlot($event, timeSlot, sPreview)">
                                                                                        <p
                                                                                            class="bg-accent w-7 rounded-full ">
                                                                                            <i
                                                                                                class="fi fi-rr-add text-3xl flex items-center text-base-100">
                                                                                            </i>
                                                                                        </p>
                                                                                    </button>
                                                                                </template>
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>


                                        <template x-if="selectedTimeSlot !== null">
                                            <div class="w-full flex flex-col gap-2" x-init="listTimeExtend">
                                                <label for="" class="text-xs">Selected Slot</label>
                                                <p class="text-xs text-gray-500">
                                                    <span x-text="selectedTimeSlot.duration">

                                                    </span>
                                                    <button class="px-2 py-1 bg-accent rounded-lg"
                                                        @click="reSelectSlot($event, selectedTimeSlot)">Reselect</button>
                                                </p>
                                                <input type="hidden" :value="selectedTimeSlot.duration"
                                                    name="timeSlot">
                                                <div class="flex p-2 items-center gap-2">
                                                    <div>
                                                        <div class="form-control">
                                                            <label class="cursor-pointer label flex gap-2">
                                                                <span class="label-text">Extend</span>
                                                                <input type="checkbox"
                                                                    class="checkbox checkbox-accent"
                                                                    name="is_extended" @change="checkedExtend" />
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{-- <template x-if="extend">
                                                        <div>
                                                            <select class="select select-accent w-full max-w-xs"
                                                                @change="selectedExtension($event)">
                                                                <option disabled selected>Select Time</option>

                                                                <template x-for="(extension, index) in timeExtentions"
                                                                    :key="index">
                                                                    <option :value="extension"
                                                                        x-text="extension + ' - min'"> </option>
                                                                </template>

                                                            </select>
                                                        </div>
                                                    </template> --}}
                                                </div>
                                            </div>

                                        </template>

                                        <div class="w-full flex flex-col gap-2">
                                            <label for="" class="text-xs">Set Date</label>
                                            <input type="date" name="date"
                                                class="input input-border input-accent">
                                        </div>
                                        <div class="w-full p-2 flex flex-col">
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

                                            <template x-if="image !== null">
                                                <div class="flex flex-col gap-2">
                                                    <label for="" class="text-xs text-gray-500">Receipt
                                                        Amount</label>
                                                    <input type="text" name="receipt_amount"
                                                        class="input input-accent" placeholder="Amount"
                                                        @change="computation($event)" x-model="rAmount">
                                                </div>
                                            </template>
                                        </div>
                                        <div class="flex justify-end p-5 gap-2">
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="text-sm text-gray-500">balance</label>
                                                <h1 class="text-accent text-x"> &#8369 <span x-text="balance"></span>
                                                </h1>
                                                <input type="hidden" x-model="balance" name="balance">
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="text-sm text-gray-500">Total Downpayment
                                                    Fee</label>
                                                <h1 class="text-accent"> &#8369 <span x-text="dTotal"></span></h1>
                                                <input type="hidden" x-model="dTotal" name="downpayment_total">
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="text-sm text-gray-500">Total</label>
                                                <h1 class="text-accent"> &#8369 <span x-text="total"></span></h1>
                                                <input type="hidden" x-model="total" name="total">
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
                    balance: 0,
                    extend: false,
                    image: null,
                    previousTimeSlotData: null,
                    rAmount: 0,
                    sDetailID: null,
                    sPreview: null,
                    selectedTimeSlot: null,
                    selectedService: [],
                    services: data,
                    timeExtentions: [],
                    toggle: false,
                    toggleTimeSlot: true,
                    total: 0,
                    dTotal: 0,
                    computation(e) {
                        const amount = e.target.value;
                        this.rAmount = amount;
                        this.balance = this.total - amount;
                    },
                    checkedExtend() {
                        // this.extend = !this.extend
                    },
                    closeImage(e) {
                        e.preventDefault()
                        this.image = null
                    },
                    fullCalendar() {
                        const cal = document.getElementById('calendar');

                        const calendar = new FullCalendar.Calendar(cal, {
                            initialView: 'dayGridMonth'
                        });
                        calendar.render()
                    },
                    listTimeExtend() {
                        // const exTime = parseInt(this.selectedService.extension_time);
                        // for (let i = exTime; i <= 60; i = i + exTime) {
                        //     this.timeExtentions.push(i)
                        // }
                    },
                    openToggle(e) {
                        e.preventDefault();
                        this.toggle = !this.toggle
                    },
                    openDetail(e, id) {
                        e.preventDefault()
                        this.sDetailID = id;
                        this.sPreview = this.selectedService.find(item => item.id === id);
                    },
                    reSelectSlot(e, _slot) {
                        e.preventDefault()
                        // this.selectedService = {
                        //     ...this.selectedService,
                        //     time_slot: this.selectedService.time_slot.map((item) =>
                        //         item = item.duration === _slot.duration ?
                        //         item = {
                        //             ...item,
                        //             slot: item.slot + 1
                        //         } : item

                        //     )
                        // }
                        // this.selectedTimeSlot = null;
                        // this.toggleTimeSlot = true;
                    },
                    selectService(id, e) {
                        e.preventDefault()
                        const service = this.services.find((item) => {
                            return item.id == id
                        });

                        if (this.selectedService.find(item => item.id === service.id)) {
                            return
                        }

                        this.selectedService = [...this.selectedService, {
                            ...service,
                            time_slot: JSON.parse(service.time_slot)
                        }]

                        this.total  = this.selectedService.reduce((total, item) => total + parseInt(item.price), 0)

                        this.dTotal =  this.selectedService.reduce((total, item) => total + parseInt(item.init_payment), 0)

                        console.log(this.dTotal)

                        // this.balance = this.selectedService.price - this.selectedService.init_payment

                        // this.toggle = false

                        console.log(this.selectedService.length)
                    },
                    selectSlot(e, _slot, service) {
                        e.preventDefault()

                        if ('selectedSlot' in service) {
                            service = {
                                ...service,
                                time_slot: service.time_slot.map((item) =>
                                    item = item.duration === service.selectedSlot.duration ?
                                    item = {
                                        ...item,
                                        slot: item.slot + 1
                                    } : item
                                )
                            }
                        }

                        service = {
                            ...service,
                            time_slot: service.time_slot.map((item) =>
                                item = item.duration === _slot.duration ?
                                item = {
                                    ...item,
                                    slot: item.slot - 1
                                } : item

                            )
                        }
                        this.sDetailID = null
                        this.sPreview = null

                        const data = this.selectedService.filter(item => item.id !== service.id);
                        this.selectedService = [...data, {
                            ...service,
                            selectedSlot: _slot
                        }]
                    },
                    selectedExtension(e) {

                        // const min = parseInt(e.target.value);
                        // const slot = this.selectedTimeSlot
                        // const endTime = slot.duration.slice(-8);
                        // const startTime = new Date(`01/01/2000 ${endTime}`)
                        // startTime.setMinutes(startTime.getMinutes() + min)
                        // const formatEndTime = startTime.toLocaleTimeString([], {
                        //     hour: '2-digit',
                        //     minute: '2-digit'
                        // });

                        // this.selectedTimeSlot = {
                        //     ...this.selectService,
                        //     duration: slot.duration.slice(0, -8) + formatEndTime
                        // }
                    },
                    openToggleTimeSlot(e) {
                        e.preventDefault()
                        this.toggleTimeSlot = !this.toggleTimeSlot
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
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
