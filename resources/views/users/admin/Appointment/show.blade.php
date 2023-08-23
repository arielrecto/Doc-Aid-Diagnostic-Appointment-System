<x-app-layout>
    <div class="flex h-screen">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex flex-col w-full h-full">
            <x-admin-navbar>
                <x-slot name="sample">{{ __('appointment - Show') }}</x-slot>
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
                        <div
                            class="w-5/6 h-auto bg-base-100 rounded-lg shadow-md hover:shadow-lg duration-700 flex flex-col space-y-2">
                            <h1 class="w-full text-center text-xl font-semibold p-2">Appointment</h1>
                            <div class="w-full flex flex-col gap-2 p-2">
                                <h1 class="text-base text-gray-500">Patient</h1>
                                <div>
                                    <h1 class="text-lg font-bold">{{ $appointment->patient }}</h1>
                                </div>
                            </div>
                            <div class="w-full flex flex-col gap-2 p-2">
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
                                            </div>
                                            <div class="flex flex-col gap-2 w-full">
                                                <label for="" class="text-gray-500 text-sm">Date</label>
                                                <h1 class="font-semibold">
                                                    {{ date('M-d-Y', strtotime($appointment->date)) }}</h1>
                                            </div>
                                            <div class="flex flex-col gap-2 w-full">
                                                <label for="" class="text-gray-500 text-sm">Session Time</label>
                                                <h1 class="font-semibold">{{ $appointment->service->session_time }} -
                                                    min
                                                    @if ($appointment->is_extended)
                                                        <span class="font-semibold text-gray-500">Extend</span>
                                                    @endif
                                                </h1>
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

                                @if ($appointment->status === 'pending')
                                    <div class="flex w-full p-2 justify-end flex-wrap gap-2">
                                        <form
                                            action="{{ route('admin.appointment.approved', ['id' => $appointment->id]) }}"
                                            method="post">
                                            @csrf
                                            <button class="text-accent text-lg hover:scale-105 duration-700">
                                                <i class="fi fi-rr-checkbox  hover:font-bold"></i>
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('admin.appointment.reject', ['id' => $appointment->id]) }}"
                                            method="post">

                                            @csrf
                                            <button class="text-error text-lg hover:scale-105 duration-700">
                                                <i class="fi fi-rr-square-x hover:font-bold"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>


                            <div class="w-full p-2 flex flex-col gap-2" x-data="result">
                                @if ($appointment->result === null)
                                    <div class="w-full flex justify-center">
                                        <button class="btn btn-accent" @click="openToggle">
                                            <span><i class="fi fi-rr-upload"></i></span>
                                            Upload Result
                                        </button>
                                    </div>
                                @else
                                    <div class="w-full flex flex-col gap-2">
                                        <h1 class="text-lg font-semibold w-full text-center capitalize">result</h1>
                                        <div class="overflow-x-auto">
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
                                                        <th>{{ $appointment->result->id }}</th>
                                                        <td>{{ $appointment->result->name }}</td>
                                                        <td>{!! $appointment->result->description !!}</td>
                                                        <td>
                                                            <div class="flex justify-ned p-2 gap-4">
                                                                <a href="{{ asset($appointment->result->path) }}"
                                                                    target="_blank">
                                                                    <button><i
                                                                            class="fi fi-rr-eye text-accent"></i></button>
                                                                </a>

                                                                <a href="{{ asset($appointment->result->path) }}"
                                                                    download>
                                                                    <button><i class="fi fi-rr-download"></i></button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                    }
                }
            }
        </script>
    @endpush

</x-app-layout>
