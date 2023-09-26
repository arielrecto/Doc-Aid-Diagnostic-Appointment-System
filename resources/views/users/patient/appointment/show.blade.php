<x-app-layout>
    <div class="main-screen">
        <x-patient-siderbar/>

        <div class="main-content">
            <x-patient.navbar/>

            @if (Session::has('rejected'))
                <div class="panel-error">
                    <span>
                        CODE ERROR - Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, dolor?
                    </span>
                </div>
            @endif

            @if (Session::has('approved'))
                <div class="panel-success">
                    <span>
                        CODE SUCCESS - Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, voluptatum?
                    </span>
                </div>
            @endif

            @if (Session::has('message'))
                <div class="panel-success">
                    <span>
                        {{ Session::get('message') }}
                    </span>
                </div>
            @endif

            <div class="panel bg-transparent p-0 shadow-none rounded-none overflow-auto">
                {{-- Appointment Details --}}
                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center">
                        <h1 class="page-title">Appointment Details</h1>


                    </div>

                    <div class="grid grid-cols-3 grid-rows-2 gap-4 p-4 border shadow-sm rounded">
                        {{-- <div class="flex flex-col gap-1">
                            <label for="" class="text-gray-500 text-sm">Time</label>
                            <h1>{{ $appointment->time }}</h1>
                        </div> --}}

                        <div class="flex flex-col gap-2 ">
                            <label for="" class="text-gray-500 text-sm">Date</label>
                            <h1 class="font-semibold flex gap-4">
                                {{ date('M-d-Y', strtotime($appointment->date)) }}
                                <span x-data="appointmentShow">
                                    <button id="resched-modal-trigger" @click="openReschedModal">
                                        <i class="fi fi-rr-edit text-accent"></i>
                                    </button>

                                    <div id="resched-modal" class="absolute top-0 left-0 w-96"
                                        @click.outside="openReschedModal" x-cloak x-show="reschedModal">
                                        <div class="rounded-lg bg-white border shadow-md p-5">
                                            <form
                                                action="{{ route('admin.appointment.reschedule', ['appointment' => $appointment->id]) }}"
                                                method="post" class="flex flex-col gap-2">
                                                @csrf
                                                @method('put')
                                                <h1 class="text-lg font-bold text-left">Reschedule</h1>
                                                <p class="text-xs text-gray-500">Date</p>
                                                <input type="date" name="date" class="c-input">
                                                <button class="btn-generic uppercase">Save</button>
                                            </form>
                                        </div>
                                    </div>

                                </span>
                            </h1>
                        </div>

                        {{-- <div class="flex flex-col gap-2 ">
                            <label for="" class="text-gray-500 text-sm">Session Time</label>
                            <h1 class="font-semibold">{{ $appointment->service->session_time }} -
                                min
                                @if ($appointment->is_extended)
                                    <span class="font-semibold text-gray-500">Extend</span>
                                @endif
                            </h1>
                        </div> --}}

                        {{-- <div class="flex flex-col gap-2 ">
                                <label for="" class="text-gray-500 text-sm">Downpayment</label>
                                <h1 class="font-semibold">PHP {{ $appointment->subscribeServices->service->init_payment }}
                            </div> --}}
                    </div>
                    <div class="w-full flex flex-col gap-2">
                        <label for="" class="text-gray-500 text-sm">Patient</label>
                        <h1 class="text-lg font-bold">{{ $appointment->patient }}</h1>
                    </div>
                </div>

                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
                    <h1 class="page-title">Payment Status</h1>
                    <h1 class="text-lg font-bold"> <span class="font-thin">Referrence Number :</span>{{$appointment->receipt_number}}</h1>
                    <div class="w-full flex flex-col gap-2 p-2">
                        <div class="w-full h-full flex flex-col gap-2">

                            <div class="flex gap-2">
                                <div class="flex flex-col gap-2">
                                    <label for="" class="text-gray-500 text-sm">Receipt
                                        Image</label>
                                    <a href="{{ $appointment->receipt_image }}" target="_blank" class="w-1/2">
                                        <img src="{{ $appointment->receipt_image }}" alt=""
                                            class="object-center object-cover">
                                    </a>
                                </div>

                            </div>
                        </div>




                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="text-sm text-gray-500">Patient</h1>
                        <h1 class="text-lg font-bold">{{ $appointment->patient }}</h1>
                    </div>

                    <div class="flex-grow flex items-center space-x-5">
                        <div class="flex flex-col gap-2">
                            <h1 class="text-sm text-gray-500">
                                Balance
                            </h1>
                            <p class="font-semibold">
                                PHP {{ $appointment->balance }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <h1 class="text-sm text-gray-500">
                                Total
                            </h1>
                            <p class="font-semibold">
                                PHP {{ $appointment->total }}
                            </p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="panel">
                <h1 class="page-title">Services Availed</h1>
                <div class="overflow-x-auto h-96">




                    @foreach ($appointment->subscribeServices as $s_service)
                        <table class="table">
                            <!-- head -->
                            <thead class="capitalize">
                                <tr>
                                    <th></th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>description</th>
                                    <th>Dowmpayment</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr class="">
                                    <th>{{ $s_service->service->id }}</th>
                                    <th><img src="{{ $s_service->service->image }}" alt="" srcset=""
                                            class="object object-center h-10 w-10"></th>
                                    <td>{{ $s_service->service->name }}</td>
                                    <td>{!! $s_service->service->description !!}</td>
                                    <td>&#8369 {{ $s_service->service->init_payment }}</td>
                                    <td>&#8369 {{ $s_service->service->price }}</td>

                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>

            </div>


            <div class="panel">
                <h1 class="page-title">Result</h1>
                <div class="overflow-x-auto h-96">




                    @foreach ($appointment->results as $result)
                        <table class="table">
                            <!-- head -->
                            <thead class="capitalize">
                                <tr>
                                    <th>Subject</th>
                                    <th>description</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr class="">
                                    <th>{{ $result->name }}</th>
                                    <td>{!! $result->description !!}</td>
                                    <td><a href="{{ $result->path }}" target="_blank"><i
                                                class="fi fi-rr-document"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>

            </div>


            {{-- <div class="w-full flex flex-col gap-2">
                                        <h1 class="text-lg font-semibold w-full text-center capitalize">result</h1>
                                        <div class="overflow-x-auto">


                                            @foreach ($appointment->result as $result)
                                                <table class="table">
                                                    <!-- head -->
                                                    <thead class="capitalize">
                                                        <tr>
                                                            <th></th>
                                                            <th>Name</th>
                                                            <th>description</th>
                                                            <th>action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- row 1 -->
                                                        <tr class="bg-base-200">
                                                            <th>{{ $result->id }}</th>
                                                            <td>{{ $result->name }}</td>
                                                            <td>{!! $result->description !!}</td>
                                                            <td>
                                                                <div class="flex justify-ned p-2 gap-4">
                                                                    <a href="{{ asset($result->path) }}"
                                                                        target="_blank">
                                                                        <button><i
                                                                                class="fi fi-rr-eye text-accent"></i></button>
                                                                    </a>

                                                                    <a href="{{ asset($result->path) }}" download>
                                                                        <button><i
                                                                                class="fi fi-rr-download"></i></button>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div> --}}
        </div>
    </div>


</x-app-layout>
