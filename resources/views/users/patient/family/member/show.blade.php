<x-app-layout>
    <div class="main-screen">

        <x-patient-siderbar />

        <div class="main-content">

            <x-patient.navbar />


            <div class="panel overflow-y-auto">
                <div class="full h-full flex flex-col lg:flex-row space-x-2">
                    <div class="w-full lg:w-1/3 p-2 h-full flex flex-col gap-5 border-r-2 border-gray-100">
                        <div class="w-full flex flex-col gap-2 items-center">
                            <a class="venobox" href="{{ $profile->image }}">
                                <img src="{{ $profile->image }}" alt=""
                                    class="w-64 h-64 object-cover object-center rounded-full hover:shadow-lg duration-700"></a>
                            <h1 class="text-lg font-semibold capitalize">{{ $profile->full_name }}</h1>
                            <h1 class="text-sm capitalize"><span>
                                    <p class="text-sm text-gray-500">Date Joined</p>
                                </span>{{ $profile->created_at->format('M-d-Y') }}</h1>
                        </div>
                    </div>
                    <div class="flex-grow w-full h-full flex flex-col space-y-5 p-5">
                        <h1 class="w-full text-center text-lg font-semibold">Personal Information</h1>
                        <div class="grid grid-cols-2 lg:grid-cols-3 grid-flow-row gap-5">
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
                                <h1 class="font-bold">
                                    {{ $profile->middle_name == null ? 'N\A' : $profile->middle_name }}</h1>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row">
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Birthdate</label>

                                <h1 class="font-bold">{{ date('F d, Y', strtotime($profile->birthdate)) }}</h1>
                            </div>
                            <div class="flex flex-col gap-2 capitalize">
                                <label for="" class="text-xs text-gray-500">Sex</label>
                                <h1 class="font-bold">{{ $profile->sex }}</h1>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 capitalize">
                            <label for="" class="text-xs text-gray-500">Contact No.</label>
                            <h1 class="font-bold">{{ $profile->contact_no }}</h1>
                        </div>
                        <h1 class="w-full text-center font-semibold p-5 border-t-2 boder-gray-100">Family - <span
                                class="font-bold text-xl">{{ $profile->family->name }}</span></h1>

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
                                                <h1 class="text-center border-2">{!! $result->description !!}</h1>
                                                <a href="{{ $result->path }}" target="_blank"
                                                    class="text-center border-2"><i
                                                        class="fi fi-rr-document pt-1"></i></a>
                                        @endforeach

                                    </div>
                                @empty
                                    <h1 class="text-center">No Medical History</h1>
                                @endforelse

                                {{-- <table class="table">

                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Subject</th>
                                            <th>Description</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($medicalHistory as $medical)
                                            <tr class="">
                                                <th></th>
                                                <td class="capitalize">{{ $medical->name }}</td>
                                                <td>
                                                    <p class="truncate">{!! $medical->description !!}</p>
                                                </td>
                                                <td><a href="{{ $medical->path }}" target="_blank"><i
                                                            class="fi fi-rr-document pt-1"></i></a> </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td>No Medical History</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
