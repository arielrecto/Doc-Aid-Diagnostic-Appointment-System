<x-app-layout>
    <div class="main-screen">
        <x-patient-siderbar />

        <div class="main-content w-5/6 md:w-full">
            <x-patient.navbar />

            @if (Session::has('rejected'))
                <div class="panel-error">
                    <span>
                       {{Session::get('reject')}}
                    </span>
                </div>
            @endif

            @if (Session::has('approved'))
                <div class="panel-success">
                    <span>
                       {{Session::get('approved')}}
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
                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <h1 class="page-title">Reschedule Request</h1>
                        <div class="flex items-center gap-2">
                            <form action="{{route('patient.appointment.reschedule.approved')}}" method="post">

                                @csrf
                                @method('put')
                                <input type="hidden" name="reschedule_id" value="{{$reschedule->id}}">
                                <button class="btn btn-accent btn-sm uppercase shadow border">
                                    Approved
                                </button>
                            </form>

                            <div class="w-full" x-data="reject">
                                <button id="reject-modal-trigger" class="btn btn-error btn-sm uppercase shadow border" @click="toggle = true">
                                    <i class="fi fi-rr-square-x hover:font-bold"></i> reject
                                </button>
                                <div class="absolute w-1/2 h-auto
                                top-0 left-0 z-10" id="reject-modal">
                                    <form class="w-full flex flex-col gap-4 p-5 bg-white
                                    shadow-sm border h-full rounded-lg" action="{{route('patient.appointment.reschedule.reject')}}"
                                        method="post" x-show="toggle">
                                        @method('put')
                                        <h1 class="text-lg font-bold text-primary">
                                            Remark
                                        </h1>
                                        <input type="hidden" name="reschedule_id" value="{{$reschedule->id}}">
                                        <textarea class="textarea textarea-accent w-full" name="remark" placeholder="Remark"></textarea>
                                        @csrf
                                        <button class="btn btn-error btn-sm uppercase shadow border">
                                            <i class="fi fi-rr-square-x hover:font-bold"></i> reject
                                        </button>
                                    </form>
                                </div>

                            </div>

                            {{-- <form action="{{route('admin.appointment.reschedule.reject')}}" method="post">

                                @csrf
                                @method('put')
                                <input type="hidden" name="reschedule_id" value="{{$reschedule->id}}">
                                <button class="btn btn-error btn-sm uppercase shadow border">
                                    Reject
                                </button>
                            </form> --}}


                        </div>
                    </div>
                    <div class="flex w-full h-auto gap-5">
                        <div class="text-sm w-1/3 h-auto" x-data="calendar" x-init="initializeCalendar({{$appointments}})">
                            <div id="calendar">

                            </div>
                        </div>
                        <div class="w-4/6 p-2 rounded-lg border-2 border-gray-200 flex flex-col gap-2">
                            <div class="grid grid-cols-2 grid-flow-row gap-2">
                                <div class="flex flex-col gap-2">
                                    <label for="" class="c-input-label">Date:</label>
                                    <p>{{date('F d, Y',  strtotime($reschedule->date))}}</p>
                                </div>
                                <div class="grid grid-cols-2 grid-flow-row gap-2">
                                    <div class="flex flex-col gap-2">
                                        <label for="" class="c-input-label">Start</label>
                                        <p>{{date('g:i A',  strtotime($reschedule->start_time))}}</p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="" class="c-input-label">End</label>
                                        <p>{{date('g:i A',  strtotime($reschedule->end_time))}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-lg h-full p-2">
                                <p>{{$reschedule->remark}}</p>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center">
                        <h1 class="page-title">Appointment Details</h1>


                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 grid-rows-2 gap-4 p-4 border shadow-sm rounded">
                        <div class="flex flex-col gap-2 ">
                            <label for="" class="text-gray-500 text-sm">Date</label>
                            <h1 class="font-semibold flex gap-4 text-xs lg:text-base">
                                {{ date('M-d-Y', strtotime($appointment->date)) }}

                            </h1>
                        </div>
                        <div class="flex flex-col gap-2 ">
                            <label for="" class="text-gray-500 text-sm">Time:</label>
                            <h1 class="font-semibold flex gap-4 text-xs lg:text-base">
                                @php
                                    $service = $appointment->subscribeServices->first();
                                @endphp
                                {{ date('g:i A', strtotime($service->start_time)) }} -
                                {{ date('g:i A', strtotime($service->end_time)) }}
                            </h1>
                        </div>
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


                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Sex : </label>
                                            <h3 class="text-sm">{{ $profile->sex }}</h3>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="text-sm font-bold">Birthdate : </label>
                                            <h3 class="text-sm">{{ date('F d, Y', strtotime($profile->birthdate)) }}
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4" x-data="{ toggle: false }">
                    <div class="w-full h-auto ">

                    </div>
                    <h1 class="page-title">Payment Status</h1>
                    <div class="flex justify-between">
                        <h1 class="text-lg font-bold"> <span class="text-sm md:text-base font-thin">Referrence Number
                            :</span>{{ $appointment->receipt_number }}</h1>
                            <button @click="toggle = !toggle" class="btn-generic">open</button>
                    </div>


                    <div class="w-full flex flex-col gap-2 p-2" x-show="toggle" x-cloak>
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


                <div class="flex flex-col gap-2 bg-white rounded-lg shadow-md p-4" x-data="{toggle : false}">

                    <div class="flex justify-between">
                        <h1 class="page-title">Services Availed</h1>
                        <button class="btn-generic" @click="toggle = !toggle">open</button>
                    </div>

                    <div class="overflow-x-auto h-96 w-full" x-show="toggle" x-cloak>




                        @foreach ($appointment->subscribeServices as $s_service)
                            <table class="table w-[64rem] lg:w-full">
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
                                        <th{{ $s_service->service->id }}< /th>
                                            <th><img src="{{ $s_service->service->image }}" alt=""
                                                    srcset="" class="object object-center h-10 w-10"></th>
                                            <td class="text-xs md:text-sm">{{ $s_service->service->name }}</td>
                                            <td>{!! $s_service->service->description !!}</td>
                                            <td>&#8369 {{ $s_service->service->init_payment }}</td>
                                            <td>&#8369 {{ $s_service->service->price }}</td>

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
        const reject = () => ({
            toggle: false,
            description: null,
            cleanupUI: null,

            init() {
                const button = document.getElementById("reject-modal-trigger");
                const tooltip = document.getElementById("reject-modal");

                this.cleanupUI = window.FloatingUI.autoUpdate(button, tooltip, () =>
                    this.spawnModal(button, tooltip)
                );

                this.$watch("toggle", () => {
                    this.spawnModal(button, tooltip);
                });
            },

            spawnModal(button, tooltip) {
                const {
                    computePosition,
                    autoPlacement
                } = window.FloatingUI;

                computePosition(button, tooltip, {
                    placement: "bottom-end",
                    // middleware: [
                    //     autoPlacement()
                    // ],
                }).then(({
                    x,
                    y
                }) => {
                    Object.assign(tooltip.style, {
                        left: `${x}px`,
                        top: `${y}px`,
                    });
                });
            },

            openToggle() {
                this.toggle = !this.toggle;
            },

            // quillEditor() {
            //     const editor = document.getElementById("editor");
            //     const quill = new Quill(editor, {
            //         theme: "snow",
            //     });
            // },

            // content() {
            //     const desription = document
            //         .getElementById("editor")
            //         .querySelector(".ql-editor").innerHTML;
            //     this.description = desription;
            // },
        })
    </script>

    @endpush

</x-app-layout>
