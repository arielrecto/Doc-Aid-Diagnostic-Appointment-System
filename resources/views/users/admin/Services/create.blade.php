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
                <div class="w-full bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 h-full mb-2">
                    <form action="" method="POST" class="flex flex-col h-full w-full m-0 p-2">
                        <div class="flex w-full h-full gap-2">
                            <div class="w-1/3 h-full">
                                <div class="flex items-center justify-center w-full h-full">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-full border-2
                                         border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                        hover:bg-gray-100
                                        ">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF
                                                (MAX. 800x400px)</p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" @change="uploadImageHandler($event)"/>
                                    </label>
                                </div>

                            </div>
                            <div class="flex-grow h-full flex flex-col gap-2">
                                <h1 class="w-full text-center p-2 font-semibold text-lg capitalize">
                                    Service information
                                </h1>
                                <div class="flex flex-col space-y-2">
                                    <div class="capitalize flex flex-col">
                                        <label for="name" class="text-sm text-gray-500 p-2">Name</label>
                                        <input type="text" placeholder="Name" class="input input-bordered input-accent w-full " />
                                    </div>
                                    <div class="w-full h-64 flex flex-col gap-2" x-init="quillEditor">
                                        <label for="name" class="text-sm text-gray-500 p-2">Description</label>
                                        <div id="editor">

                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 grid-flow-row gap-4">
                                        <div class="capitalize flex flex-col">
                                            <label for="name" class="text-sm text-gray-500 p-2">Price</label>
                                            <input type="text" placeholder="Price" class="input input-bordered input-accent w-full " />
                                        </div>
                                        <div class="capitalize flex flex-col">
                                            <label for="name" class="text-sm text-gray-500 p-2">Initial Downpayment</label>
                                            <input type="text" placeholder="Initial Downpayment" class="input input-bordered input-accent w-full " />
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row-reverse">
                            <button class="btn btn-accent capitalize">Add</button>
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
                    image : null,
                    uploadImageHandler(e) {
                        console.log(e.target.files[0])

                    },
                    quillEditor (){
                        const editor = document.getElementById('editor');
                        const quill = new Quill(editor, {
                            theme: 'snow'
                        })
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
