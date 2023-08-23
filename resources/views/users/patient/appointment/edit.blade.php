<x-app-layout>
    <div class="w-full min-screen flex">
        <div class="w-1/6">
            <x-patient-siderbar />
        </div>
        <div class="flex-grow flex flex-col gap-2 w-full h-full">
            <div class="w-full">
                <x-patient.navbar>
                    <x-slot name="header">
                        {{ __('appointment - edit') }}
                    </x-slot>
                </x-patient.navbar>
            </div>
            <div class="w-full h-96 flex justify-center items-center">

                <div class="bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 w-1/2 flex gap-2 p-2">
                    <div class="w-1/3 flex flex-col gap-2 border border-2 rounded-lg">
                        <img src="{{ $appointment->service->image }}" alt="">
                        <h1 class="text-xl font-semibold text-center w-full">{{ $appointment->service->name }}</h1>
                        <div class="grid grid-cols-2 grid-flows-row gap-2">
                            <div class="w-full flex justify-center">
                                <p class="text-xs text-gray-500 font-semibold">Price :
                                    <span>{{ $appointment->service->price }}</span></p>
                            </div>
                            <div class="w-full flex justify-center">
                                <p class="text-xs text-gray-500 font-semibold">Price :
                                    <span>{{ $appointment->service->init_payment }}</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-2 p-2">
                        <form action="{{ route('patient.appointment.update', ['appointment' => $appointment->id]) }}"
                            method="post">
                            <div class="w-full flex flex-col gap-2">
                                <label for="" class="text-xs">Patient</label>
                                <select class="select select-accent w-full" id="interval" name="patient">
                                    <option disabled selected>Patient</option>
                                    <option value="{{ Auth::user()->name }}">{{ Auth::user()->name }}</option>
                                    <option disabled> - Family Members - </option>
                                    @forelse (Auth::user()->family ?? [] as $member)
                                        <option value="{{ $member->full_name }}" class="capitalize">
                                            {{ $member->full_name }}</option>
                                    @empty
                                        <option disabled class="text-xs">No Family Members</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="w-full flex flex-col gap-2">
                                <h1 class="text-gray-500 text-base">Schedule</h1>
                                <input type="date" name="date"
                                    placeholder="{{ date('M-d-Y', strtotime($appointment->date)) . ' - ' . $appointment->time }}"
                                    class="input input-accent">
                            </div>
                            <div class="w-full flex flex-col gap-2">
                                <h1 class="text-gray-500 text-base">Status</h1>
                                <p class="font-bold">{{ $appointment->status }}</p>
                            </div>
                            <div class="w-full flex flex-col gap-2">
                                <h1 class="text-gray-500 text-base">Balance</h1>
                                <p class="font-bold">{{ $appointment->balance }}</p>
                            </div>
                            <div class="w-full flex justify-end">
                                @csrf
                                @method('put')
                                <button class="btn btn-accent">save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
