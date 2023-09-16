<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />

        <div class="main-content">
            <x-admin.navbar-new />

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

            <div class="panel">
                <h1 class="page-title">Appointment Details</h1>

                {{-- Appointment Details --}}
                <div class="grid grid-cols-3 grid-rows-2 gap-4 p-4 border shadow-sm rounded">
                    <div class="flex flex-col gap-1">
                        <label for="" class="text-gray-500 text-sm">Time</label>
                        <h1>{{ $appointment->time }}</h1>
                    </div>

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
                        <label for="" class="text-gray-500 text-sm">Session Time</label>
                        <h1 class="font-semibold">{{ $appointment->service->session_time }} -
                            min
                            @if ($appointment->is_extended)
                                <span class="font-semibold text-gray-500">Extend</span>
                            @endif
                        </h1>
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <label for="" class="text-gray-500 text-sm">Downpayment</label>
                        <h1 class="font-semibold">{{ $appointment->service->init_payment }}
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <label for="" class="text-gray-500 text-sm">Downpayment</label>
                        <h1 class="font-semibold">{{ $appointment->service->init_payment }}
                    </div>
                </div>

                <div class="w-full h-full flex p-4 border shadow-sm rounded">
                    <div class="h-auto rounded-lg flex flex-col space-y-2">
                        <div class="w-full flex flex-col gap-2 p-2">
                            <h1 class="text-base text-gray-500">Patient</h1>
                            <div>
                                <h1 class="text-lg font-bold">{{ $appointment->patient }}</h1>
                            </div>
                        </div>

                        <div class="w-full flex flex-col gap-2 p-2">
                            {{-- <h1 class="text-base text-gray-500">Service</h1> --}}
                            <div class="flex space-x-4 w-full">

                                <div class="w-full h-full flex flex-col gap-2">

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


                            <div class="flex w-full p-2 justify-end flex-wrap gap-2">

                                <a href="{{ route('admin.appointment.edit', ['appointment' => $appointment->id]) }}">
                                    <button class="text-primary text-lg hover:scale-105 duration-700">
                                        <i class="fi fi-rr-edit hover:bold"></i>
                                    </button>
                                </a>
                                @if ($appointment->status === 'pending')
                                    <form
                                        action="{{ route('admin.appointment.approved', ['id' => $appointment->id]) }}"
                                        method="post">
                                        @csrf
                                        <button class="text-accent text-lg hover:scale-105 duration-700">
                                            <i class="fi fi-rr-checkbox  hover:font-bold"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.appointment.reject', ['id' => $appointment->id]) }}"
                                        method="post">

                                        @csrf
                                        <button class="text-error text-lg hover:scale-105 duration-700">
                                            <i class="fi fi-rr-square-x hover:font-bold"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>


                        <div class="w-full p-2 flex flex-col gap-2" x-data="result">
                            @if ($appointment->result->count() === 0)
                                <div class="w-full flex justify-center">
                                    <button class="btn-generic uppercase" @click="openToggle">
                                        <span><i class="fi fi-rr-upload"></i></span>
                                        Send Result
                                    </button>
                                </div>
                            @else
                                <div class="w-full flex flex-col gap-2">
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
                                                                <a href="{{ asset($result->path) }}" target="_blank">
                                                                    <button><i
                                                                            class="fi fi-rr-eye text-accent"></i></button>
                                                                </a>

                                                                <a href="{{ asset($result->path) }}" download>
                                                                    <button><i class="fi fi-rr-download"></i></button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div x-show="toggle" x-transition.duration.700ms>
                                <form action="{{ route('admin.appointment.result.store') }}" method="post"
                                    class="w-full flex flex-col gap-4 p-5" enctype="multipart/form-data">
                                    @csrf
                                    <h1 class="text-xl font-bold w-full text-center p-4">Result</h1>
                                    <div class="flex flex-col gap-2">
                                        <label for="" class="text-sm text-gray-500">Name</label>
                                        <input type="text" class="input input-accent w-full rounded-lg"
                                            name="name">
                                    </div>
                                    <div class="flex flex-col gap-2 h-64" x-init="quillEditor()">
                                        <label for="" class="text-sm text-gray-500">Description</label>
                                        <div id="editor">

                                        </div>
                                        <input type="hidden" name="description" x-model="description">
                                    </div>
                                    <div class="flex flex-col gap-2 h-64">
                                        <label for="" class="text-sm text-gray-500">Upload File</label>
                                        <input type="file"
                                            class="file-input file-input-bordered file-input-accent w-full"
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

            </div>

            <div class="panel grow">
                <h1 class="page-title">Services Availed</h1>

            </div>
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
