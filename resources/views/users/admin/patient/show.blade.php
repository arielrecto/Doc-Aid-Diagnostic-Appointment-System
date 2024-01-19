<x-app-layout>
    <div class="main-screen">

        <x-admin.sidebar-new />

        <div class="main-content w-5/6">

            <x-admin.navbar-new />


            <div class="panel overflow-y-auto">
                <div class="full h-full flex flex-col lg:flex-row space-x-2">
                    <div class="w-full lg:w-1/3 p-2 h-full flex flex-col gap-5 border-r-2 border-gray-100">
                        <div class="w-full flex flex-col gap-2 items-center">
                            <a class="venobox" href="{{ $profile->avatar }}">
                                <img src="{{ $profile->avatar }}" alt=""
                                    class="w-64 h-64 object-cover object-center rounded-full hover:shadow-lg duration-700"></a>
                            <h1 class="text-lg font-semibold capitalize">{{ $profile->full_name }}</h1>
                            <h1 class="text-sm capitalize"><span>
                                    <p class="text-sm text-gray-500">Date Joined</p>
                                </span>{{ $profile->created_at->format('M-d-Y') }}</h1>
                        </div>
                    </div>
                    <div class="flex-grow w-full h-full flex flex-col space-y-5 p-5">
                        <div class="flex items-center justify-between">
                            <h1 class="w-full  text-lg font-semibold">Personal Information</h1>
                            <a href="{{ route('admin.patient.edit', ['patient' => $profile->id]) }}"
                                class="btn btn-xs btn-accent">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 grid-flow-row gap-5">
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
                        <div class="grid grid-cols-2 md:grid-cols-3 grid-flow-row">
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Age</label>
                                <h1 class="font-bold">{{ $profile->age }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Birthdate</label>
                                <h1 class="font-bold">{{ date('F d, Y', strtotime($profile->birthdate)) }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Sex</label>
                                <h1 class="font-bold">{{ $profile->gender }}</h1>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row gap-5">
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
                        <div class="flex flex-col gap-2">
                            <h1 class="text-sm font-bold">Valid ID Information</h1>

                            <img src="{{ $profile->valid_id_image }}" alt="" srcset=""
                                class="object object-center h-auto w-32">
                            <div clas="flex gap-2">
                                <h1 class="text-sm capitalize font-bold">
                                    <span>ID type: </span>
                                    <span class="font-normal uppercase">{{ $profile->valid_id_type }}</span>
                                </h1>
                                <h1 class="text-sm capitalize font-bold">
                                    <span>ID number: </span>
                                    <span class="font-normal uppercase">{{ $profile->valid_id_number }}</span>
                                </h1>
                            </div>
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
                                        @forelse ($patient->family->members ?? [] as $member)
                                            <tr class="">
                                                <th>1</th>
                                                <td class="capitalize">{{ $member->full_name }}</td>
                                                <td>{{ $member->email }}</td>
                                                <td>{{ $member->sex }}</td>
                                                <td>{{ $member->relationship }}</td>
                                                <td><a
                                                        href="{{ route('admin.patient.family.show', ['family' => $member->id]) }}">
                                                        <i class="fi fi-rr-eye text-primary"></i>
                                                    </a>
                                                </td>
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
                        <h1 class="w-full text-center font-semibold p-5 border-t-2 boder-gray-100">Medical History</h1>
                        <div class="w-full flex flex-col gap-2">
                            <div class="overflow-x-auto">
                                @forelse ($medicalHistory as $medical)
                                    <div class="w-full flex flex-col gap-2">
                                        <div class="flex gap-2 text-sm font-semibold border-y-2 p-2 justify-between">
                                            <h1>Appointment - <span class="">{{ $medical->date }}</span></h1>
                                            <h1>Patient: <span>{{ $medical->patient }}</span></h1>
                                        </div>
                                        <h1 class="capitalize font-semibold">
                                            result
                                        </h1>
                                        <div class="grid grid-flow-row grid-cols-3 gap-2 normal-case font-semibold">
                                            <h1 class="text-center border-2">subject</h1>
                                            <h1 class="text-center border-2">Description</h1>
                                            <h1 class="text-center border-2">file</h1>
                                        </div>
                                        @foreach ($medical->results()->get() as $result)
                                            <div class="grid grid-flow-row grid-cols-3 gap-2 normal-case">
                                                <h1 class="text-center border-2">{{ $result->name }}</h1>
                                                <h1 class="text-center border-2 truncate">{!! $result->description !!}
                                                </h1>
                                                <a href="{{ $result->path }}" target="_blank"
                                                    class="text-center border-2"><i
                                                        class="fi fi-rr-document pt-1"></i></a>
                                            </div>
                                        @endforeach

                                    </div>
                                @empty
                                    <h1 class="text-center">No Medical History</h1>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
