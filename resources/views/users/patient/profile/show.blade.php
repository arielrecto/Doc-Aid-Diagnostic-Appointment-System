<x-app-layout>
    <div class="flex w-full min-h-screen">
        <div class="w-64">
            <x-patient-siderbar />
        </div>
        <div class="flex flex-col space-y-5 w-full h-full">
            <div class="w-full">
                <x-patient.navbar>
                    <x-slot name="header">
                        {{ __('Profile - ' . Auth::user()->name) }}
                    </x-slot>
                </x-patient.navbar>
            </div>
            <div class="w-full h-full flex justify-center items-center p-5">
                <div class="w-5/6 h-full bg-base-100 shadow-sm hover:shadow-lg duration-700 flex space-x-2">
                    <div class="w-1/3 p-2 h-full flex flex-col gap-5 border-r-2 border-gray-100">
                        <div class="w-full flex flex-col gap-2 items-center">
                            <img src="{{ $profile->avatar }}" alt=""
                                class="w-64 h-64 object-cover object-center rounded-full hover:shadow-lg duration-700">
                            <h1 class="text-lg font-semibold capitalize">{{ $profile->full_name }}</h1>
                            <h1 class="text-sm capitalize"><span>
                                    <p class="text-sm text-gray-500">Date Joined</p>
                                </span>{{ $profile->created_at->format('M-d-Y') }}</h1>
                        </div>
                    </div>
                    <div class="flex-grow w-full h-full flex flex-col space-y-5 p-5">
                        <h1 class="w-full text-center text-lg font-semibold">Personal Information</h1>
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Last Name</label>
                                <h1 class="font-bold">{{ $profile->last_name }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">First Name</label>
                                <h1 class="font-bold">{{ $profile->first_name }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Middle Name</label>
                                <h1 class="font-bold">{{ $profile->middle_name }}</h1>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 capitalize">
                            <label for="" class="text-xs text-gray-500">Sex</label>
                            <h1 class="font-bold">{{ $profile->gender }}</h1>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Street</label>
                                <h1 class="font-bold">{{ $profile->street }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Barangay</label>
                                <h1 class="font-bold">{{ $profile->barangay }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Municipality</label>
                                <h1 class="font-bold">{{ $profile->municipality }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Region</label>
                                <h1 class="font-bold">{{ $profile->region }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Zip Code</label>
                                <h1 class="font-bold">{{ $profile->zip_code }}</h1>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 capitalize">
                            <label for="" class="text-xs text-gray-500">Contact No.</label>
                            <h1 class="font-bold">{{ $profile->contact_no }}</h1>
                        </div>
                        <h1 class="w-full text-center font-semibold p-5 border-t-2 boder-gray-100">Family</h1>
                        <div class="w-full flex flex-col gap-2">
                            @if (Auth::user()->family === null)
                                <a href="{{ route('patient.family.index') }}">
                                    <button class="btn btn-accent">Add</button>
                                </a>
                            @else
                                <div class="flex flex-col gap-2 capitalize">
                                    <label for="" class="text-xs text-gray-500">Name</label>
                                    <h1 class="font-bold">{{ Auth::user()->family->name }}</h1>
                                    <a href="{{ route('patient.family.members.create') }}">
                                        <button class="btn btn-accent">Add Member</button>
                                    </a>
                                </div>
                            @endif

                            <div class="overflow-x-auto">
                                <table class="table">
                                    <!-- head -->
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Sex</th>
                                            <th>Relationship</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- row 1 -->
                                        @forelse (Auth::user()->family->members ?? [] as $member)
                                            <tr class="">
                                                <th>1</th>
                                                <td class="capitalize">{{ $member->full_name }}</td>
                                                <td>{{ $member->email }}</td>
                                                <td>{{ $member->sex }}</td>
                                                <td>{{ $member->relationship }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>No Family Member</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
