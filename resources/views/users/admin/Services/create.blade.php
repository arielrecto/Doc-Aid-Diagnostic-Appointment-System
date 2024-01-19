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

            <div class="panel grow overflow-y-auto" x-data="servicesCreate">
                @if (Session::has('message'))
                    <div class="panel-success">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ Session::get('message') }}
                        </span>
                    </div>
                @endif

                <h1 class="page-title">Create A Service</h1>
                <form action="{{ route('admin.services.store') }}" method="POST"
                    class="m-0 p-2 flex gap-4 grow overflow-y-auto">
                    @csrf
                    {{-- Image and Service Information --}}
                    <div class="w-1/3 max-w-full grow-0 flex flex-col gap-2">
                        <h1 class="w-full text-center text-base capitalized text-primary-focus pb-4">
                            Service Information
                        </h1>

                        @if ($errors->has('image'))
                            <div class="text-error text-sm">
                                <p>{{ $errors->first('image') }}</p>
                            </div>
                        @endif

                        <label for="" class="c-input-label">Service Image</label>
                        <div class="h-[200px] w-[800px] max-w-full overflow-hidden flex flex-col gap-2 shrink-0">
                            <template x-if="image === null">
                                <label for="dropzone-file" class="image-dropzone">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">Click to upload</span> or drag and
                                            drop
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or
                                            GIF
                                            (MAX. 800x400px)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden"
                                        @change="uploadImageHandler($event)" />
                                </label>
                            </template>

                            <input type="hidden" name="image" x-model="image">

                            <template x-if="image !== null">
                                <div class="w-full h-full relative image-dropzone">
                                    <img :src="image" alt="" srcset=""
                                        class="object-cover object-center">
                                    <button @click="() => image = null"
                                        class="btn btn-sm btn-ghost bg-error bg-opacity-80 absolute top-0 right-0">
                                        <i class="fi fi-rr-cross text-white text-bold"></i>
                                    </button>
                                </div>
                            </template>

                        </div>

                        {{-- TIME FIELDS --}}
                        <div class="grow flex flex-col gap-4">

                            <div class="c-input-group">
                                <label for="name" class="c-input-label">Name</label>
                                <input type="text" placeholder="Name" name="name" class="c-input" />
                            </div>
                            @if ($errors->has('name'))
                                <div class="text-error text-sm">
                                    <p>{{ $errors->first('name') }}</p>
                                </div>
                            @endif

                            <div class="max-w-full h-[200px] grow flex flex-col gap-2" x-init="quillEditor">
                                <label for="name" class="c-input-label">Description</label>
                                <div id="editor" class="w-[800px] max-w-full overflow-hidden">

                                </div>
                                <input type="hidden" name="description" x-model="description">
                                @if ($errors->has('description'))
                                    <div class="text-error text-sm">
                                        <p>{{ $errors->first('description') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 grid-flow-row gap-4">

                                <div class="c-input-group">
                                    <label for="name" class="c-input-label">Price</label>
                                    <input type="text" placeholder="Price" name="price" class="c-input" />
                                    @if ($errors->has('price'))
                                        <div class="text-error text-sm">
                                            <p>{{ $errors->first('price') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="c-input-group">
                                    <label for="name" class="c-input-label">Initial
                                        Downpayment</label>
                                    <input type="text" placeholder="Initial Downpayment" name="initPayment"
                                        class="c-input" />
                                    @if ($errors->has('initPayment'))
                                        <div class="text-error text-sm">
                                            <p>{{ $errors->first('initPayment') ? 'The Initial Downpayment field is Required' : '' }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                            </div>


                            {{-- Service Time --}}




                        </div>
                    </div>

                    {{-- Set Service Time --}}
                    <div class="flex flex-col gap-2 w-2/3 shrink-0 px-2 overflow-y-hidden">
                        <h1 class="w-full text-center text-base capitalized text-primary-focus pb-4">
                            Set Service Time
                        </h1>
                        <div class="grid grid-cols-5 grid-flow-row gap-2">
                            <div class="c-input-group">
                                <label for="" class="c-input-label">Start</label>
                                <input type="time" placeholder="Type here" id="start" class="c-input" />
                            </div>
                            <div class="c-input-group">
                                <label for="" class="c-input-label">End</label>
                                <input type="time" placeholder="Type here" id="end" class="c-input" />
                            </div>
                            <div class="c-input-group">
                                <label for="" class="c-input-label">Session Time
                                </label>
                                <select class="c-input" id="interval" name="session_time"
                                    @change="setTimeItervalForm">
                                    <option disabled selected>Duration</option>
                                    <option value="5">5 min</option>
                                    <option value="10">10 min</option>
                                    <option value="20">20 min</option>
                                    <option value="30">30 min</option>
                                    <option value="40">40 min</option>
                                    <option value="50">50 min</option>
                                    <option value="60">1 hr</option>
                                </select>
                                @if ($errors->has('session_time'))
                                    <div class="text-error text-sm">
                                        <p>{{ $errors->first('session_time') }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="c-input-group">
                                <label for="" class="c-input-label">
                                    Extension Time
                                </label>
                                <input type="text" placeholder="ex: 20 mins" name="extension_time"
                                    class="c-input" />

                                @if ($errors->has('extension_time'))
                                    <p class="text-xs text-error">
                                        {{ $errors->first('extension_time') }}</p>
                                @endif
                            </div>
                            <div class="c-input-group">
                                <label for="" class="c-input-label">Extension
                                    Rate</label>
                                <input type="text" placeholder="Type here" id="end" name="extension_price"
                                    class="c-input" />
                                @if ($errors->has('extension_price'))
                                    <p class="text-xs text-error">
                                        {{ $errors->first('extension_price') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 grow overflow-y-auto border-4 border-base-300 rounded-lg p-2">
                            <template x-if="timeIntervals.length <= 0">
                                <span
                                    class="text-primary-focus font-semibold uppercase text-sm text-opacity-50">Service
                                    Time will appear here. Set the time from above.</span>
                            </template>
                            <template x-for="(timeInterval, index) in timeIntervals" :key="index">
                                <div class="grid grid-cols-2 grid-flow-row gap-2 p-2">
                                    <h1 class="min-w-full">
                                        <span x-text="timeInterval.duration"></span>
                                    </h1>

                                    <template x-if="timeInterval.slot === 'break'">
                                        <input type="text" placeholder="Slot" x-model="timeInterval.slot" disabled
                                            class="input input-bordered input-accent w-full " />
                                    </template>
                                    <template x-if="timeInterval.slot !== 'break'">
                                        <input type="text" placeholder="Slot" x-model="timeInterval.slot"
                                            class="input input-bordered input-accent w-full " />
                                    </template>
                                </div>
                            </template>
                        </div>
                        <div class="flex flex-col gap-2" x-init="initDays({{ $days }})">
                            <h1 class="w-full text-center text-base capitalized text-primary-focus pb-4">
                                Days Availability
                            </h1>
                            <div
                                class="flex flex-col gap-2 grow overflow-y-auto border-4 border-base-300 rounded-lg p-2">

                                <template x-if="selectedDays.length === 0">
                                    <h1 class="text-primary-focus font-semibold uppercase text-sm text-opacity-50">
                                        Select Days below
                                    </h1>
                                </template>

                                <template x-if="selectedDays.length !== 0">
                                    <div class="w-full grid grid-cols-7 grid-flow-col">
                                        <template x-for="day in selectedDays" :key="day.id">
                                            <button class="flex btn btn-ghost btn-xs"
                                                @click="removeDayAction(day, $event)">
                                                <span x-text="day.name"></span>
                                            </button>
                                        </template>
                                    </div>

                                </template>
                            </div>
                            <div class="w-full grid grid-cols-7 grid-flow-col">
                                <template x-for="day in days" :key="day.id">
                                    <button class="flex btn btn-ghost btn-xs" @click="addDayAction(day, $event)">
                                        <span x-text="day.name"></span>
                                    </button>
                                </template>
                            </div>
                            @if ($errors->has('service_days'))
                                <div class="text-error text-sm">
                                    <p>{{ $errors->first('service_days') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-row-reverse">
                            <button class="btn-generic uppercase" @click="content">
                                <i class="ri-add-line"></i>
                                Create Service
                            </button>
                        </div>
                        <input type="hidden" :value="JSON.stringify(timeIntervals)" name="timeSlot">
                        <input type="hidden" :value="JSON.stringify(selectedDays)" name="service_days">
                    </div>




                </form>

            </div>
        </div>
    </div>

    @push('js')
        <script>
            function servicesCreate() {
                return {
                    image: null,
                    description: null,
                    timeIntervals: [],
                    days: [],
                    selectedDays: [],
                    uploadImageHandler(e) {
                        const {
                            files
                        } = e.target;

                        const reader = new FileReader();

                        reader.onload = function() {
                            this.image = reader.result
                        }.bind(this)
                        reader.readAsDataURL(files[0])
                    },
                    initDays(days) {
                        this.days = days;

                        console.log(this.days)
                    },
                    quillEditor() {
                        const editor = document.getElementById('editor');
                        const quill = new Quill(editor, {
                            theme: 'snow'
                        })
                    },
                    content() {

                        const data = document.getElementById('editor').querySelector('.ql-editor').innerHTML;
                        if (data === '<p></p>') {
                            return this.description = null
                        }
                        this.description = data
                    },
                    setTimeItervalForm() {
                        const intervals = []
                        const startEl = document.getElementById('start').value;
                        const endEl = document.getElementById('end').value;
                        const intervalEl = document.getElementById('interval').value;

                        let start = new Date(`01/01/2000 ${startEl}`)
                        const end = new Date(`01/01/2000 ${endEl}`)
                        let dStart = null
                        let dEnd = null
                        while (start < end) {

                            const formattedTime = start.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            })
                            if (formattedTime === '12:00 PM' || (formattedTime > '12:00 PM' && formattedTime < '1:00 PM')) {
                                dStart = formattedTime;
                                start = new Date(`01/01/2000 01:00 PM`)

                                dEnd = start.toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                                intervals.push({
                                    duration: `${dStart} - ${dEnd}`,
                                    slot: 'break'
                                })
                            } else {
                                dStart = formattedTime;
                                start.setMinutes(start.getMinutes() + parseInt(intervalEl))
                                dEnd = start.toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                                intervals.push({
                                    duration: `${dStart} - ${dEnd}`,
                                    slot: null
                                });
                            }
                        }

                        this.timeIntervals = intervals

                        // let _slot = this.timeIntervals.map((item) => item.slot = 2 )

                        // console.log(JSON.stringify(this.timeIntervals))

                    },
                    fomattedTime(time) {
                        const _time = time.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        })
                        return _time;
                    },
                    addDayAction(data, e) {
                        e.preventDefault();


                        this.selectedDays = [
                            ...this.selectedDays,
                            data
                        ]

                        this.days = this.days.filter((day) => day.id !== data.id)
                    },
                    removeDayAction(data, e) {
                        e.preventDefault();


                        this.days = [
                            ...this.days,
                            data
                        ]

                        this.selectedDays = this.selectedDays.filter((day) => day.id !== data.id)
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
