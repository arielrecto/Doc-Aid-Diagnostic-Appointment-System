<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />

        <div class="main-content">
            <x-admin.navbar-new />

            @if (Session::has('rejected'))
                <div class="panel-error">
                    <span class="flex items-center normal-case">
                        {{ Session::get('rejected') }}
                    </span>
                </div>
            @endif

            @if (Session::has('approved'))
                <div class="panel-success">
                    <span>
                        {{ Session::get('approved') }}
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

                        <div class="flex p-2 justify-end gap-2 items-center">
                            @if ($appointment->balance != 0 && $appointment->status == 'approved')
                                <div class="w-full flex justify-center" x-data="payment">
                                    <button id="payment-modal-trigger" @click="openToggle"
                                        class="btn btn-accent btn-sm uppercase shadow border">
                                        <i class="fi fi-rr-credit-card"></i>pay
                                    </button>

                                    <div id="payment-modal"
                                        class="absolute w-1/2 h-1/2
                            top-0 left-0 z-10"
                                        x-cloak @click.outside="openToggle" x-show="toggle">
                                        <form action="{{ route('admin.appointment.payment.store') }}" method="post"
                                            class="w-full flex flex-col gap-4 p-5 bg-white
                                    shadow-sm border h-full overflow-auto rounded-lg"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <h1 class="text-xl font-bold w-full">Payment</h1>
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="c-input-label">Reference #</label>
                                                <input type="text" class="c-input" name="ref_number">
                                            </div>

                                            <div class="flex flex-col gap-2">
                                                <label for="" class="c-input-label">Amount</label>
                                                <input type="text" class="c-input" name="amount">
                                            </div>


                                            <div class="flex flex-col gap-2">
                                                <label for="" class="c-input-label">Upload Receipt</label>
                                                <input type="file" name="image"
                                                    class="file-input file-input-bordered file-input-accent w-full" />
                                            </div>


                                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                                            <button class="btn btn-accent" @click="content()">Upload</button>

                                        </form>
                                    </div>

                                </div>
                            @endif
                            <div class="w-full flex justify-center">
                                <a href="{{ route('admin.appointment.edit', ['appointment' => $appointment->id]) }}">
                                    <button class="btn btn-accent btn-sm uppercase shadow border">
                                        <i class="fi fi-rr-edit hover:bold"></i> edit
                                    </button>
                                </a>
                            </div>

                            @if ($appointment->status === 'pending')
                                <form action="{{ route('admin.appointment.approved', ['id' => $appointment->id]) }}"
                                    method="post" class="flex p-2 justify-end gap-2 items-center">
                                    @csrf
                                    <button class="btn btn-primary btn-sm uppercase shadow border">
                                        <i class="fi fi-rr-checkbox  hover:font-bold"></i> approved
                                    </button>
                                </form>
                                <form action="{{ route('admin.appointment.reject', ['id' => $appointment->id]) }}"
                                    method="post" class="flex p-2 justify-end gap-2 items-center">

                                    @csrf
                                    <button class="btn btn-error btn-sm uppercase shadow border">
                                        <i class="fi fi-rr-square-x hover:font-bold"></i> reject
                                    </button>
                                </form>
                            @endif

                            <div class="w-full p-2 flex flex-col gap-2" x-data="result">
                                <div class="w-full flex justify-center">
                                    <button id="result-mail-modal-trigger" class="btn-generic uppercase"
                                        @click="openToggle">
                                        <span><i class="fi fi-rr-upload"></i></span>
                                        Send Result
                                    </button>
                                </div>


                                <div id="result-mail-modal"
                                    class="absolute w-1/2 h-1/2
                                top-0 left-0 z-10"
                                    x-cloak @click.outside="openToggle" x-show="toggle">
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

                                        <button class="btn btn-accent" @click="content()">Upload</button>

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

                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
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
                                        <th><img src="{{ $s_service->service->image }}" alt=""
                                                srcset="" class="object object-center h-10 w-10"></th>
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


                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
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
