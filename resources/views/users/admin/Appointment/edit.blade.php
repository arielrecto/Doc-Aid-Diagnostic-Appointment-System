<x-app-layout>
    <div class="flex h-screen">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex flex-col w-full h-full">
            <x-admin-navbar>
                <x-slot name="sample">{{ __('appointment - Edit') }}</x-slot>
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
            @if (Session::has('message'))
                <div class="w-full p-5 bg-green-500">
                    <h1 class="text-xl text-center">{{ Session::get('message') }}</h1>
                </div>
            @endif
            <div class="w-full h-full px-5">
                <div class="flex flex-col gap-2 py-5 w-full h-full">
                    <div class="w-full h-full flex justify-center items-center">
                        <form method="POST" action="{{route('admin.appointment.update', ['appointment' => $appointment->id])}}"
                            class="w-5/6 h-auto bg-base-100 rounded-lg shadow-md hover:shadow-lg duration-700 flex flex-col space-y-2 relative">
                            @csrf @method('put')
                            <h1 class="w-full text-center text-xl font-semibold p-2">Appointment</h1>
                            <div class="w-full flex flex-col gap-2 p-2">
                                <h1 class="text-base text-gray-500">Patient</h1>
                                <div>
                                    <h1 class="text-lg font-bold">{{ $appointment->patient }}</h1>
                                    <select class="select select-accent w-full" id="interval" name="patient"
                                        @change="setTimeItervalForm">
                                        <option disabled selected>Patient</option>
                                        <option value="{{ $appointment->patient }}">{{ $appointment->patient }}</option>
                                        <option disabled> - Family Members - </option>
                                        @forelse ($appointment->user->family->members ?? [] as $member)
                                            <option value="{{ $member->full_name }}" class="capitalize">
                                                {{ $member->full_name }}</option>
                                        @empty
                                            <option disabled class="text-xs">No Family Members</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="w-full flex flex-col gap-2 p-2" x-data="appointmentShow">
                                <h1 class="text-base text-gray-500">Service</h1>
                                <div class="flex space-x-4 w-full">
                                    <img src="{{ $appointment->service->image }}" alt="" srcset=""
                                        class="h-64 w-96 object-cover">
                                    <div class="w-full h-full flex flex-col gap-2">
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-gray-500 text-sm">Name</label>
                                            <h1 class="font-semibold">{{ $appointment->service->name }}</h1>
                                        </div>
                                        <div class="grid grid-cols-2 grid-flow-row gap-2">
                                            <div class="flex flex-col gap-2 w-full">
                                                <label for="" class="text-gray-500 text-sm">Time</label>
                                                <h1 class="font-semibold">{{ $appointment->time }}</h1>
                                                <div class="grid grid-cols-2 gap-2 grid-flow-row">
                                                    <div class="flex flex-col gap-2">
                                                        <label for="" class="text-xs text-gray-500">Start
                                                            time</label>
                                                        <input type="time" class="input input-accent" name="start_time" id="sTime">
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label for="" class="text-xs text-gray-500">End
                                                            time</label>
                                                        <input type="time" class="input input-accent" name="end_time" id="eTime"
                                                            @change="calculateDuration">
                                                    </div>
                                                    <input type="hidden" name="duration" x-model="duration">
                                                </div>
                                            </div>
                                            <div class="flex flex-col gap-2 w-full">
                                                <label for="" class="text-gray-500 text-sm">Date</label>
                                                <h1 class="font-semibold flex gap-4">
                                                    {{ date('M-d-Y', strtotime($appointment->date)) }}
                                                </h1>
                                                <input type="date" name="date" class="input input-accent">
                                            </div>
                                            <div class="flex flex-col gap-2 w-full">
                                                <label for="" class="text-gray-500 text-sm">Session Time</label>

                                                <template x-if="duration !== null">
                                                    <h1 class="font-semibold"> <span x-text="duration"></span>
                                                        @if ($appointment->is_extended)
                                                            <span class="font-semibold text-gray-500">Extend</span>
                                                        @endif
                                                    </h1>
                                                </template>
                                                <template x-if="duration === null">
                                                    <h1 class="font-semibold">{{ $appointment->service->session_time }}
                                                        -
                                                        min
                                                        @if ($appointment->is_extended)
                                                            <span class="font-semibold text-gray-500">Extend</span>
                                                        @endif
                                                    </h1>
                                                </template>
                                            </div>
                                            <div class="flex flex-col gap-2 w-full">

                                                <label for="" class="text-gray-500 text-sm">Price</label>
                                                <h1 class="font-semibold">{{ $appointment->service->price }}
                                                </h1>
                                                <label for="" class="text-gray-500 text-sm">Downpayment</label>
                                                <h1 class="font-semibold">{{ $appointment->service->init_payment }}
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="text-gray-500 text-sm">Receipt
                                                    Image</label>
                                                <a href="{{ $appointment->receipt_image }}" target="_blank">
                                                    <img src="{{ $appointment->receipt_image }}" alt=""
                                                        class="h-24 w-24 object-cover">
                                                </a>
                                            </div>
                                            <div class="flex-grow flex items-center space-x-5">
                                                <div class="flex flex-col gap-2">
                                                    <h1 class="text-sm text-gray-500">
                                                        Balance
                                                    </h1>
                                                    <p class="font-semibold">
                                                        {{ $appointment->balance }}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col gap-2">
                                                    <h1 class="text-sm text-gray-500">
                                                        Total
                                                    </h1>
                                                    <p class="font-semibold">
                                                        {{ $appointment->total }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex p-5 justify-end">
                                <button class="btn btn-accent">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    @push('js')
        <script>
            function appointmentShow() {
                return {
                    reschedModal: false,
                    duration: null,
                    openReschedModal() {
                        this.reschedModal = !this.reschedModal
                    },
                    calculateDuration() {
                        const sTime = document.getElementById('sTime').value;
                        const eTime = document.getElementById('eTime').value;

                        const start = new Date(`2000-01-01 ${sTime}`);
                        const end = new Date(`2000-01-01 ${eTime}`);

                        const diffInMinutes = Math.floor((end - start) / (1000 * 60));
                        const hours = Math.floor(diffInMinutes / 60);
                        const minutes = diffInMinutes % 60;



                        console.log(diffInMinutes)
                        if (diffInMinutes < 60) {
                            this.duration = `${minutes} - min`
                        } else {
                            this.duration = `${hours}:${minutes < 10 ? '0' : ''}${minutes}`;
                        }

                    }
                }
            }
        </script>
    @endpush

</x-app-layout>
