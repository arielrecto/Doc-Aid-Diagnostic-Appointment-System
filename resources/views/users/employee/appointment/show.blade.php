<x-app-layout>
    <div class="main-screen">
        <x-employee.sidebar />

        <div class="main-content overflow-y-auto">
            <x-employee.navbar />

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

            <div class="panel bg-transparent p-0 shadow-none rounded-none">
                {{-- Appointment Details --}}
                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center">
                        <h1 class="page-title">Appointment Details</h1>

                        <div class="flex p-2 justify-end items-center flex-wrap-3 gap-10">
                            {{-- <div class="w-full flex justify-center">
                                <a href="{{ route('admin.appointment.edit', ['appointment' => $appointment->id]) }}"
                                    class="flex items-center">
                                    <button class="btn btn-accent btn-sm uppercase shadow border">
                                        <i class="fi fi-rr-edit hover:bold"></i> edit
                                    </button>
                                </a>
                            </div> --}}

                            @if ($appointment->status === 'pending')
                                <form
                                    action="{{ route('employee.appointment.approved', ['appointment' => $appointment->id]) }}"
                                    method="post" class="w-full flex justify-center">
                                    @csrf
                                    <button class="btn btn-primary btn-sm uppercase shadow border">
                                        <i class="fi fi-rr-checkbox  hover:font-bold"></i> approved
                                    </button>
                                </form>

                                <form
                                    action="{{ route('employee.appointment.reject', ['appointment' => $appointment->id]) }}"
                                    method="post" class="w-full flex justify-center">

                                    @csrf
                                    <button class="btn btn-error btn-sm uppercase shadow border">
                                        <i class="fi fi-rr-square-x hover:font-bold"></i> reject
                                    </button>
                                </form>
                            @endif

                            <div class="w-full p-2 flex flex-col gap-2" x-data="result">
                                {{-- <div class="w-full flex justify-center">
                                    <button id="result-mail-modal-trigger" class="btn-generic uppercase"
                                        @click="openToggle">
                                        <span><i class="fi fi-rr-upload"></i></span>
                                        Send Result
                                    </button>
                                </div> --}}


                                <div id="result-mail-modal"
                                    class="absolute w-1/2 h-1/2
                                top-0 left-0" x-cloak
                                    @click.outside="openToggle" x-show="toggle">
                                    <form action="{{ route('admin.appointment.result.store') }}" method="post"
                                        class="w-full flex flex-col gap-4 p-5 bg-white
                                        shadow-sm border h-full overflow-auto rounded-lg"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <h1 class="text-xl font-bold w-full">Result</h1>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="c-input-label">Subject</label>
                                            <input type="text" class="c-input" name="name">
                                        </div>

                                        <div class="max-w-full h-[200px] grow flex flex-col gap-2"
                                            x-init="quillEditor">
                                            <label for="name" class="c-input-label">Description</label>

                                            <div class="flex flex-col rounded-lg border overflow-hidden [&>*]:border-0">
                                                <div id="editor" class="w-full max-w-full overflow-hidden border-2">

                                                </div>
                                                <input type="hidden" name="description" x-model="description">
                                                @if ($errors->has('description'))
                                                    <div class="text-error text-sm">
                                                        <p>{{ $errors->first('description') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex flex-col gap-2 h-64">
                                            <label for="" class="c-input-label">Upload File</label>
                                            <input type="file"
                                                class="file-input file-input-sm file-input-bordered
                                                file-input-primary w-full"
                                                name="file" />
                                        </div>
                                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                        <div class="w-full flex justify-end">
                                            <button class="btn btn-accent" @click="content()">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                        <div class="flex flex-col gap-2 ">
                            <label for="" class="text-gray-500 text-sm">Time:</label>
                            @foreach ($appointment->subscribeServices as $service)
                                <h1 class="font-semibold flex gap-4 text-xs lg:text-base">
                                    <span>
                                        Service : {{ $service->service->name }}|
                                    </span>
                                    <span class="flex items-center">
                                        {{ date('g:i A', strtotime($service->start_time)) }} -
                                        {{ date('g:i A', strtotime($service->end_time)) }}
                                    </span>

                                </h1>
                            @endforeach
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
                    @if (!$appointment->is_family)
                        <div class="w-full flex flex-col gap-2">
                            <label for="" class="text-gray-500 text-sm">Patient</label>
                            <div class="flex gap-5 w-full">
                                <img src="{{ $appointment->user->profile->avatar }}" alt="" srcset=""
                                    class="h-36 w-auto object object-center">
                                <div class="w-full h-auto flex flex-col gap-2 bg-gray-100 rounded-lg p-2">

                                    @php
                                        $profile = $appointment->user->profile;
                                    @endphp
                                    <div class="grid grid-cols-3 grid-flow-row gap-2 w-full">
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Last Name</label>
                                            <h3 class="text-sm">{{ $profile->last_name }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">First Name</label>
                                            <h3 class="text-sm">{{ $profile->first_name }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Middle Name</label>
                                            <h3 class="text-sm">{{ $profile->middle_name }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Age : </label>
                                            <h3 class="text-sm">{{ $profile->age }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Sex : </label>
                                            <h3 class="text-sm">{{ $profile->gender }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Birthdate : </label>
                                            <h3 class="text-sm">{{ date('F d, Y', strtotime($profile->birthdate)) }}
                                            </h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Street : </label>
                                            <h3 class="text-sm">{{ $profile->street }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Barangay: </label>
                                            <h3 class="text-sm">{{ $profile->barangay }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Municipality : </label>
                                            <h3 class="text-sm">{{ $profile->municipality }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Region : </label>
                                            <h3 class="text-sm">{{ $profile->region }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Municipality : </label>
                                            <h3 class="text-sm">{{ $profile->zip_code }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">

                                            <label for="" class="text-sm font-bold">Contact #: </label>
                                            <h3 class="text-sm">{{ $profile->contact_no }}</h3>
                                        </div>

                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <h1 class="text-sm font-bold">Valid ID Information</h1>
                                        <a class="venobox" href="{{ $profile->valid_id_image }}">
                                            <img src="{{ $profile->valid_id_image }}" alt="" srcset=""
                                                class="object object-center h-auto w-32">
                                        </a>
                                        <div clas="flex gap-2">
                                            <h1 class="text-sm capitalize font-bold">
                                                <span>ID type: </span>
                                                <span
                                                    class="font-normal uppercase">{{ $profile->valid_id_type }}</span>
                                            </h1>
                                            <h1 class="text-sm capitalize font-bold">
                                                <span>ID number: </span>
                                                <span
                                                    class="font-normal uppercase">{{ $profile->valid_id_number }}</span>
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="w-full flex flex-col gap-2">
                            <label for="" class="text-gray-500 text-sm">Patient</label>
                            <div class="flex gap-5 w-full">
                                <img src="{{ $appointment->family_member->image }}" alt="" srcset=""
                                    class="h-36 w-auto object object-center">
                                <div class="w-full h-auto flex flex-col gap-2 bg-gray-100 rounded-lg p-2">

                                    @php
                                        $profile = $appointment->family_member;
                                    @endphp

                                    <div class="grid grid-cols-3 grid-flow-row gap-2 w-full">
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Last Name</label>
                                            <h3 class="text-sm">{{ $profile->last_name }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">First Name</label>
                                            <h3 class="text-sm">{{ $profile->first_name }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Middle Name</label>
                                            <h3 class="text-sm">{{ $profile->middle_name }}</h3>
                                        </div>

                                        {{-- <div class="flex flex-col gap-2">
                                        <label for="" class="text-sm font-bold">Age : </label>
                                        <h3 class="text-sm">{{ $profile->age }}</h3>
                                    </div> --}}
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Sex : </label>
                                            <h3 class="text-sm">{{ $profile->sex }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Birthdate : </label>
                                            <h3 class="text-sm">{{ date('F d, Y', strtotime($profile->birthdate)) }}
                                            </h3>
                                        </div>
                                        {{-- <div class="flex flex-col gap-2">
                                        <label for="" class="text-sm font-bold">Street : </label>
                                        <h3 class="text-sm">{{ $profile->street }}</h3>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="" class="text-sm font-bold">Barangay: </label>
                                        <h3 class="text-sm">{{ $profile->barangay }}</h3>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="" class="text-sm font-bold">Municipality : </label>
                                        <h3 class="text-sm">{{ $profile->municipality }}</h3>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="" class="text-sm font-bold">Region : </label>
                                        <h3 class="text-sm">{{ $profile->region }}</h3>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="" class="text-sm font-bold">Municipality : </label>
                                        <h3 class="text-sm">{{ $profile->zip_code }}</h3>
                                    </div>
                                    <div class="flex flex-col gap-2">

                                        <label for="" class="text-sm font-bold">Contact #: </label>
                                        <h3 class="text-sm">{{ $profile->contact_no }}</h3>
                                    </div> --}}

                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <h1 class="text-sm font-bold">Valid ID Information</h1>
                                        <a class="venobox" href="{{ $profile->valid_id_image }}">
                                            <img src="{{ $profile->valid_id_image }}" alt="" srcset=""
                                                class="object object-center h-auto w-32">
                                        </a>
                                        <div clas="flex gap-2">
                                            <h1 class="text-sm capitalize font-bold">
                                                <span>ID type: </span>
                                                <span
                                                    class="font-normal uppercase">{{ $profile->valid_id_type }}</span>
                                            </h1>
                                            <h1 class="text-sm capitalize font-bold">
                                                <span>ID number: </span>
                                                <span
                                                    class="font-normal uppercase">{{ $profile->valid_id_number }}</span>
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
                    <h1 class="page-title">Payment Status</h1>
                    <h1 class="text-lg font-bold"> <span class="font-thin">Referrence Number
                            :</span>{{ $appointment->receipt_number }}</h1>
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
                                    <th>Minimum Downpayment</th>
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


    @push('js')
        <script>
            function result() {
                return {
                    toggle: false,
                    description: null,

                    openToggle() {
                        this.toggle = !this.toggle
                    },

                    quillEditor() {
                        const editor = document.getElementById('editor');
                        const quill = new Quill(editor, {
                            theme: 'snow'
                        })
                    },

                    content() {
                        const desription = document.getElementById('editor').querySelector(".ql-editor").innerHTML;
                        this.description = desription;
                    },
                }
            }
        </script>
    @endpush

</x-app-layout>
