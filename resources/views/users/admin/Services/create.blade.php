<x-app-layout>
    <div class="flex">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex-grow flex flex-col gap-2">
            <x-admin-navbar>
                <x-slot name="sample">
                    {{ __('Services - Create') }}
                </x-slot>
            </x-admin-navbar>

            <div class="flex flex-col gap-2 px-5 h-full" x-data="servicesCreate">
                @if (Session::has('message'))
                    <div class="alert alert-success w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ Session::get('message') }}</span>
                    </div>
                @endif
                <div class="w-full bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 h-full mb-2">
                    <form action="{{ route('admin.services.store') }}" method="POST"
                        class="flex flex-col h-full w-full m-0 p-2">
                        <div class="flex w-full h-full gap-2">
                            @csrf
                            <div class="w-1/3 h-full">
                                <div class="w-full h-full flex flex-col gap-2">
                                    <div class="flex items-center justify-center w-full h-[41rem]">
                                        <template x-if="image === null">
                                            <label for="dropzone-file"
                                                class="flex flex-col items-center justify-center w-full h-full border-2
                                             border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                            hover:bg-gray-100
                                            ">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
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
                                            <div class="w-full h-full relative">
                                                <img :src="image" alt="" srcset=""
                                                    class="object-cover w-full h-[34rem]">
                                                <button @click="() => image = null"
                                                    class="btn btn-ghost absolute top-0 right-0">
                                                    <i class="fi fi-rr-cross text-accent"></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    @if ($errors->has('image'))
                                        <div class="text-error text-sm">
                                            <p>{{ $errors->first('image') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow h-full flex flex-col gap-2">
                                <h1 class="w-full text-center p-2 font-semibold text-lg capitalize">
                                    Service information
                                </h1>
                                <div class="flex flex-col space-y-2">
                                    <div class="capitalize flex flex-col">
                                        <label for="name" class="text-sm text-gray-500 p-2">Name</label>
                                        <input type="text" placeholder="Name" name="name"
                                            class="input input-bordered input-accent w-full " />
                                    </div>
                                    @if ($errors->has('name'))
                                        <div class="text-error text-sm">
                                            <p>{{ $errors->first('name') }}</p>
                                        </div>
                                    @endif
                                    <div class="w-full h-64 flex flex-col gap-2" x-init="quillEditor">
                                        <label for="name" class="text-sm text-gray-500 p-2">Description</label>
                                        <div id="editor">

                                        </div>
                                        <input type="hidden" name="description" x-model="description">
                                        @if ($errors->has('description'))
                                            <div class="text-error text-sm">
                                                <p>{{ $errors->first('description') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 grid-flow-row gap-4">
                                        <div class="capitalize flex flex-col">
                                            <label for="name" class="text-sm text-gray-500 p-2">Price</label>
                                            <input type="text" placeholder="Price" name="price"
                                                class="input input-bordered input-accent w-full " />
                                            @if ($errors->has('price'))
                                                <div class="text-error text-sm">
                                                    <p>{{ $errors->first('price') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="capitalize flex flex-col">
                                            <label for="name" class="text-sm text-gray-500 p-2">Initial
                                                Downpayment</label>
                                            <input type="text" placeholder="Initial Downpayment" name="initPayment"
                                                class="input input-bordered input-accent w-full " />
                                            @if ($errors->has('initPayment'))
                                                <div class="text-error text-sm">
                                                    <p>{{ $errors->first('initPayment') ? 'The Initial Downpayment field is Required' : '' }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full py-2">
                                        <h1 class="p-2 w-full text-center text-base capitalized text-gray-500">
                                            Set Service Time
                                        </h1>
                                        <div class="grid grid-cols-3 grid-flow-row gap-2">
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="text-sm text-gray-500 p-2">Start</label>
                                                <input type="time" placeholder="Type here" id="start"
                                                    class="input input-bordered input-accent w-full" />
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="text-sm text-gray-500 p-2">End</label>
                                                <input type="time" placeholder="Type here" id="end"
                                                    class="input input-bordered input-accent w-full" />
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="text-sm text-gray-500 p-2">Session Time -
                                                   </label>
                                                <select class="select select-accent w-full max-w-xs" id="interval" name="session_time"
                                                    @change="setTimeItervalForm">
                                                    <option disabled selected>Duration</option>
                                                    <option value="40">40 min</option>
                                                    <option value="60">1 hr</option>
                                                </select>
                                                @if ($errors->has('session_time'))
                                                    <div class="text-error text-sm">
                                                        <p>{{ $errors->first('session_time') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <template x-for="(timeInterval, index) in timeIntervals"
                                            :key="index">
                                            <div class="grid grid-cols-2 grid-flow-row gap-2 p-2">
                                                <h1 class="min-w-full">
                                                    <span x-text="timeInterval.duration"></span>
                                                </h1>

                                                <template x-if="timeInterval.slot === 'break'">
                                                    <input type="text" placeholder="Slot"
                                                        x-model="timeInterval.slot" disabled
                                                        class="input input-bordered input-accent w-full " />
                                                </template>
                                                <template x-if="timeInterval.slot !== 'break'">
                                                    <input type="text" placeholder="Slot"
                                                        x-model="timeInterval.slot"
                                                        class="input input-bordered input-accent w-full " />
                                                </template>
                                            </div>
                                        </template>
                                        <input type="hidden" :value="JSON.stringify(timeIntervals)" name="timeSlot">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row-reverse">
                            <button class="btn btn-accent capitalize" @click="content()">Add</button>
                        </div>
                    </form>
                </div>
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
                            if (formattedTime === '12:00 PM') {
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
                    },
                    fomattedTime(time) {
                        const _time = time.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        })
                        return _time;
                    }

                }
            }
        </script>
    @endpush
</x-app-layout>
