<x-app-layout>
    <div class="main-screen" x-data="create({{ $services }})">
        <x-patient-siderbar />
        <div class="main-content">

            <x-patient.navbar />


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
            @if (Session::has('reject'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span>{{ Session::get('reject') }}</span>
                </div>
            @endif

            <div class="flex flex-col gap-2 p-5 w-full h-full relative panel overflow-y-auto">
                <div class="flex flex-col md:flex-row h-full w-full md:gap-2">
                    <div
                        class="flex-grow w-full lg:w-1/2 md:w-1/2 h-full rounded-lg shadow-sm hover:shadow-lg
                             duration-700 p-2 flex flex-col gap-2">
                        <h1 class="w-full text-lg font-semibold text-center py-2">Set Appointment</h1>
                        <form
                            :action="isPayPal ? `{{ route('patient.paypal.paypal') }}` :
                                `{{ route('patient.appointment.store') }}`"
                            method="POST" class="w-full h-full flex flex-col gap-2">
                            @csrf

                            <div class="w-full flex flex-col gap-2">
                                <label for="" class="text-xs">Patient</label>
                                <select class="select select-accent w-full " id="interval" name="patient"
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
                                @if ($errors->has('patient'))
                                    <p class="text-xs text-error">{{ $errors->first('patient') }}</p>
                                @endif
                            </div>


                            <div class="w-full flex flex-col gap-2">
                                <label for="" class="text-xs">Set Date</label>
                                <input type="date" name="date" class="input input-border input-accent"
                                    @change="checkIsDateIsPast" x-model="sDate">
                                @if ($errors->has('date'))
                                    <p class="text-xs text-error">{{ $errors->first('date') }}</p>
                                @endif
                                <template x-if="'date' in error">
                                    <p x-text="error.date" class="text-xs text-error"></p>
                                </template>
                            </div>

                            <template x-if="showFields">
                                <div
                                    class="w-full border-2 border-gray-50 hover:bg-gray-50 duration-700
                                     hover:border-gray-100 rounded-lg h-full">
                                    <div class="p-2 flex flex-col gap-2">
                                        <div class="flex justify-between">
                                            <label for="" class="text-xs">Add Service
                                                <span class="text-xs text-gray-400">(click the + button to select
                                                    service)</span>
                                            </label>

                                            <div>
                                                <button @click="openToggle($event)"><i
                                                        class="fi fi-rr-add bg-accent rounded-full text-3xl flex items-center text-base-100"></i></button>
                                            </div>
                                        </div>

                                        <template x-if="selectedServices.length !== 0">
                                            <div class="w-full overflow-y-auto h-96 fkex flex-col gap-2">
                                                <template x-for="serviceData in selectedServices"
                                                    :key="serviceData.id">
                                                    <div class="flex gap-2 w-full h-auto">
                                                        {{-- <div class="w-1/3 h-auto">
                                                            <img :src="serviceData.image" alt="" srcset=""
                                                                class="object object-center w-full h-auto">
                                                        </div> --}}
                                                        <div
                                                            class="flex flex-col gap-2 w-full border-2 border-gray-300 rounded-lg p-2">
                                                            <div class="flex justify-between items-center">
                                                                <h1 class="font-bold text-lg capitalize">
                                                                    <span x-text="serviceData.name"></span>
                                                                </h1>
                                                                <button class="btn btn-xs btn-error"
                                                                    @click.prevent="removeService(serviceData.id)">x</button>
                                                            </div>

                                                            <div class="flex items-center gap-2">
                                                                <h1 class="text-xs w-1/2">Downpayment</h1>
                                                                <p x-text="serviceData.init_payment"
                                                                    class="text-accent w-full"></p>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <h1 class="text-xs w-1/2">Price</h1>
                                                                <p x-text="serviceData.price"
                                                                    class="text-accent w-full"></p>
                                                            </div>
                                                            <div class="flex items-center gap-2 text-sm">
                                                                <h1 class="text-xs w-1/2">Session Time : </h1>
                                                                <p x-text="serviceData.session_time + ' min'"
                                                                    class="text-gray-400 w-full"></p>
                                                            </div>
                                                            <template x-if="'selectedSlot' in serviceData">
                                                                <div class="flex items-center gap-2 text-sm">
                                                                    <h1 class="text-xs w-1/2">Selected Time & Slot</h1>
                                                                    <p
                                                                        class="text-gray-400 w-full flex items-center gap-2">
                                                                        <span
                                                                            x-text="serviceData.selectedSlot.duration">

                                                                        </span>
                                                                        <template x-if="!dropDownToggle">
                                                                            <button class="btn btn-xs btn-accent"
                                                                                @click.prevent="reSelectSlot(serviceData, serviceData.selectedSlot)">
                                                                                change
                                                                            </button>
                                                                        </template>
                                                                    </p>


                                                                </div>
                                                            </template>

                                                            <div class="flex flex-col gap-2"
                                                                x-show="serviceData.selectedSlot === undefined"
                                                                x-transition.duration.700ms>
                                                                <h1
                                                                    class="w-full text-center text-sm text-gray-500 font-semibold">
                                                                    Service Time Slot</h1>
                                                                <div class="w-full">
                                                                    <template x-if="toggleTimeSlot">

                                                                        <select class="select select-accent w-full"
                                                                            @change="selectSlot($event, serviceData)">
                                                                            <option disabled selected>Select Time
                                                                            </option>
                                                                            <template
                                                                                x-for="(timeSlot, index) in serviceData.time_slot.slots"
                                                                                :key="index">
                                                                                <template
                                                                                    x-if="timeSlot.slot !== 'break' && timeSlot.slot !== 0">
                                                                                    <option :value="timeSlot.duration">
                                                                                        <div class="flex gap ">
                                                                                            <span
                                                                                                x-text="timeSlot.duration"
                                                                                                class="flex-grow"></span>
                                                                                            /
                                                                                            Slot : <span
                                                                                                x-text="timeSlot.slot"></span>
                                                                                        </div>
                                                                                    </option>
                                                                                </template>
                                                                            </template>
                                                                        </select>

                                                                    </template>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <input type="hidden" name="services"
                                                            :value="JSON.stringify(selectedServices)">

                                                    </div>
                                                </template>

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
                                                </div>
                                            </div>

                                        </template>
                                        <div class="w-full h-auto flex flex-col gap-2">
                                            <div class="flex items-center gap-5">
                                                {{-- <input type="checkbox" class="checkbox"
                                                    @change=" class=""> --}}
                                                <button @click.prevent="checkIsPayPal">
                                                    <img src="{{ asset('image/paypal.png') }}" alt=""
                                                        srcset="" class="object object-center h-12 w-12">
                                                </button>

                                                <button @click.prevent="isPayPal = false"
                                                    class="btn btn-ghost relative">
                                                    <img src="{{ asset('image/more.png') }}" alt=""
                                                        srcset="" class="object object-center h-12 w-12">
                                                    <p class="absolute z-10 top-0">Other</p>
                                                </button>

                                            </div>
                                            <template x-if="!isPayPal">
                                                <div>
                                                    <div class="w-full p-2 flex flex-col gap-2">

                                                        @foreach ($accounts as $account)
                                                            <label for="" class="text-xs">Bank
                                                                name: {{ $account->name }}</label>
                                                            <div class="text-sm font-bold">
                                                                <h1>Account Number:
                                                                    <span>{{ $account->account_number }}</span>
                                                                </h1>
                                                                <h1> Account Name: <span>
                                                                        {{ $account->account_name }}</span></h1>
                                                            </div>

                                                            @if ($account->image !== null)
                                                                <button @click.prevent="paymentToggle = true">
                                                                    <img src="{{ $account->image }}" alt=""
                                                                        srcset=""
                                                                        class="object object-center h-32 w-32">
                                                                </button>
                                                                <div x-show="paymentToggle"
                                                                    class="absolute z-10 w-full h-full backdrop-blur-sm flex items-center justify-center top-0"
                                                                    x-transition.duration.700ms>
                                                                    <div class="h-96 w-auto"
                                                                        @click.outside="paymentToggle = false">
                                                                        <img src="{{ $account->image }}"
                                                                            alt="" srcset=""
                                                                            class="object object-center h-full w-full">

                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
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
                                                                        <i
                                                                            class="fi fi-rr-circle-xmark text-accent"></i>
                                                                    </button>
                                                                </div>
                                                            </template>
                                                            <div class="h-full flex items-center">
                                                                <input type="hidden" x-model="image" name="receipt">
                                                                <label>
                                                                    <input type="file" id=""
                                                                        class="hidden"
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
                                                            <div class="w-full flex flex-col gap-2">
                                                                <div class="flex flex-col gap-2">
                                                                    <label for=""
                                                                        class="text-xs text-gray-500">Reference
                                                                        Number</label>
                                                                    <input type="text" name="receipt_number"
                                                                        class="input input-accent"
                                                                        placeholder="Reference Number">
                                                                </div>
                                                                <div class="flex flex-col gap-2">
                                                                    <label for=""
                                                                        class="text-xs text-gray-500">Receipt
                                                                        Amount</label>
                                                                    <input type="text" name="receipt_amount"
                                                                        class="input input-accent"
                                                                        placeholder="Amount"
                                                                        @change="computation($event)"
                                                                        x-model="rAmount">
                                                                    <template x-if="'insuffiecient' in error">
                                                                        <p class="text-xs text-error"
                                                                            x-text="error.insuffiecient"></p>
                                                                    </template>
                                                                </div>
                                                            </div>

                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <input type="hidden" name="payment_type"
                                                :value="isPayPal ? 'paypal' : 'other'">

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
                                    <template
                                        x-if="selectedServices.length !== 0 && dTotal <= rAmount || selectedServices.length !== 0 && isPayPal">
                                        <div class="w-full flex flex-row-reverse">
                                            <button class="btn btn-accent">
                                                <span x-text="isPayPal ? 'Set with Paypal' : 'Set'">
                                                </span>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </form>
                    </div>
                    <div class="hidden md:block w-full md:w-1/2   h-full rounded-lg shadow-sm hover:shadow-lg duration-700 p-2"
                        x-init="fullCalendar">
                        <div id="calendar" class="w-full h-96 text-xs">

                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-center z-10 absolute" x-show="toggle" x-transition.duration.700ms
                    x-cloak @click.outside="openToggle">
                    <div class="w-5/6 lg:w-1/2 flex flex-col gap-2 bg-base-100 rounded-lg shadow-lg p-2">
                        <div class="flex w-full items-center justify-between">
                            <h1 class="text-primary text-lg font-bold capitalize">
                                Select Services
                            </h1>
                            <button @click="openToggle" class="text-accent text-lg">
                                <i class="fi fi-rr-circle-xmark"></i>
                            </button>
                        </div>
                        <div class="flex flex-col gap-2 w-full">
                            <template x-if="'service_error' in error">
                                <p class="text-xs text-error" x-text="error.service_error"></p>
                            </template>
                            <template x-for="service in services">

                                <div
                                    class="p-4 w-full border-2 border-gray-200 rounded-lg flex items-center justify-between">
                                    <h1 class="text-bold gap-2">
                                        <span x-text="service.name"></span>
                                    </h1>
                                    <div class="flex 2 items-center">
                                        <template x-if="!selectedServices.some(obj => obj.id === service.id)">
                                            <button class="btn btn-xs btn-accent"
                                                @click="selectService(service, $event)">Add</button>
                                            <p x-text="service.price" class="text-sm font-semibold text-accent"></p>
                                        </template>

                                        <template x-if="selectedServices.some(obj => obj.id === service.id)">
                                            <button class="btn btn-xs btn-error"
                                                @click="removeService(service.id)">remove</button>
                                            <p x-text="service.price" class="text-sm font-semibold text-accent"></p>
                                        </template>

                                    </div>
                                </div>
                            </template>
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
                    sDate: null,
                    sPreview: null,
                    selectedTimeSlot: null,
                    selectedServices: [],
                    services: data,
                    timeExtentions: [],
                    toggle: false,
                    toggleTimeSlot: true,
                    total: 0,
                    dTotal: 0,
                    isPayPal: false,
                    showFields: false,
                    error: {},
                    paymentToggle: false,
                    dropDownToggle: true,
                    computation(e) {
                        const amount = e.target.value;
                        this.rAmount = amount;
                        this.balance = this.total - amount;

                        this.dTotalCompareToInitPayment()
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
                    reSelectSlot(service, _slot) {
                        console.log(service, );
                        service = {
                            ...service,
                            time_slot: {
                                ...service.time_slot,
                               slots : service.time_slot.slots.map((item) => {
                                        if (item.duration === _slot.duration) {

                                            // timeData = {
                                            //     ...item,
                                            //     slot: `${item.slot + 1}`
                                            // }
                                            item.slot = `${item.slot + 1}`;
                                            return item
                                        }

                                        return item
                                    }
                                )
                            }
                        }


                        delete service['selectedSlot']

                        console.log(service);

                        const serviceList = this.selectedServices.filter(item => item.id !== service.id)

                        this.selectedServices = [
                            ...serviceList,
                            service
                        ]
                        // this.selectedTimeSlot = null;
                        // this.toggleTimeSlot = true;
                    },
                    selectService(data, e) {
                        e.preventDefault()


                        const date = new Date(this.sDate)
                        console.log(date.getDay());
                        let daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                        const dayOfWeek = daysOfWeek[date.getDay()];

                        console.log(dayOfWeek);
                        const serviceIsAvailable = data.days.filter(item => item.name === dayOfWeek);

                        if (serviceIsAvailable.length === 0) {

                            const serviceAvailableDay = data.days.map(day => day.name).join(', ');
                            this.error = {
                                'service_error': `Service: ${data.name} is not available on the ${dayOfWeek} ${this.sDate}, Service available days is ${serviceAvailableDay}`
                            }

                            console.log(this.error);

                            return
                        }
                        this.error = {}


                        const service = {
                            ...data,
                            time_slot: {
                                ...data.time_slot[0],
                                slots: JSON.parse(data.time_slot[0].slots)
                            }
                        };

                        this.selectedServices = [
                            ...this.selectedServices,
                            service
                        ]




                        this.total = this.selectedServices.reduce((accumulator, currentValue) => {
                            return accumulator + parseInt(currentValue.price);
                        }, 0);


                        this.dTotal = this.selectedServices.reduce((accumulator, currentValue) => {
                            return accumulator + parseInt(currentValue.init_payment);
                        }, 0);
                    },
                    removeService(id) {
                        this.selectedServices = this.selectedServices.filter(item => item.id !== id);
                    },
                    selectSlot(e, service) {
                        e.preventDefault()

                        const slot = service.time_slot.slots.find((item) => {
                            if (item.duration === e.target.value) {
                                return item
                            }
                        })
                        console.log(slot);
                        console.log(this.sDate)

                        if ('selectedSlot' in service) {
                            service = {
                                ...service,
                                time_slot: {
                                    ...service.time_slot,
                                    slots: service.time_slot.slots.map((item) => {
                                        item = item.duration === service.selectedSlot.duration ?
                                            item = {
                                                ...item,
                                                slot: item.slot + 1
                                            } : item

                                        return item;
                                    })
                                }

                            }
                        }


                        service = {
                            ...service,
                            time_slot: {
                                ...service.time_slot,
                                date: this.sDate,
                                slots: service.time_slot.slots.map((item) => {
                                    item = item.duration === slot.duration ?
                                        item = {
                                            ...item,
                                            slot: item.slot - 1
                                        } : item

                                    return item;
                                })
                            }

                        }
                        console.log(service);
                        this.sDetailID = null
                        this.sPreview = null

                        let serviceData = this.selectedServices.find(item => item.id === service.id);

                        serviceData = {
                            ...service,
                            selectedSlot: slot
                        }

                        const serviceList = this.selectedServices.filter(item => item.id !== service.id)

                        this.selectedServices = [
                            ...serviceList,
                            serviceData
                        ]

                        this.dropDownToggle = false;

                        // this.selectedServices =
                    },
                    selectedExtension(e) {

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
                    },
                    checkIsPayPal() {
                        this.isPayPal = !this.isPayPal
                    },
                    checkIsDateIsPast() {
                        const currentDate = new Date().toJSON().slice(0, 10);
                        const date2 = new Date(currentDate).getTime();
                        const date1 = new Date(this.sDate).getTime();

                        if (date2 < date1) {
                            this.showFields = true;
                            this.error = {}
                            return
                        }
                        this.showFields = false

                        this.error = {
                            'date': 'The Fields Didn\'t show becuase the selected Date is past'
                        }
                    },
                    dTotalCompareToInitPayment() {


                        if (this.rAmount < this.dTotal) {
                            console.log('hell no')
                            this.error = {
                                insuffiecient: 'can\'t process your amount is less than to downpayment'
                            }
                            return
                        }

                        this.error = {}
                        return
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
