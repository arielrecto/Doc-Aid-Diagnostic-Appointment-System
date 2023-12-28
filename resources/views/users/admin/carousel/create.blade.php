<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />
        <div class="main-content">
            <x-admin.navbar-new />

            <div class="panel min-h-screen" x-data="carouselCreate">
                <h1 class="page-title">Carousel - create</h1>
                <div class="flex justify-start">
                    <a href="{{ route('admin.imageCarousel.index') }}" class="btn-generic"><i
                            class="fi fi-rr-arrow-small-left pt-1"></i></a>
                </div>
                <div class="flex gap-2 h-full">
                    <form action="{{ route('admin.imageCarousel.store') }}" method="post"
                        class="w-full h-full flex gap-2 flex-col " enctype="multipart/form-data">

                        @csrf
                        <div class="flex justify-end">
                            <button class="btn-generic">Add</button>
                        </div>
                        <div class="w-full h-full gap-2 flex">
                            <div class="w-1/3 h-96">
                                <template x-if="image !== null">
                                    <div class="relative h-full w-full">
                                        <img :src="image" alt="" srcset=""
                                            class="object object-center object-cover h-full w-full">

                                            <button class="btn-generic absolute z-10 top-1 right-1" @click="image = null"><i class="fi fi-rr-cross-circle"></i></button>
                                    </div>
                                </template>
                                <div class="flex items-center justify-center w-full"
                                    x-show="image === null">
                                        <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-80 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click
                                                to
                                                upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX.
                                            800x400px)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" name="image"
                                        @change="fileUploadHandler($event)" class="hidden" />
                                    </label>
                                </div>


                                @if ($errors->has('image'))
                                    <p class="text-xs text-error">
                                        {{ $errors->first('image') }}</p>
                                @endif
                            </div>
                            <div class="w-full flex flex-col gap-2 h-96">
                                <div class="c-input-group">
                                    <label for="" class="c-input-label">
                                        title
                                    </label>
                                    <input type="text" placeholder="title" name="title" class="c-input" />

                                    @if ($errors->has('title'))
                                        <p class="text-xs text-error">
                                            {{ $errors->first('title') }}</p>
                                    @endif
                                </div>

                                <div class="c-input-group">
                                    <label for="" class="c-input-label">
                                        description
                                    </label>
                                    <textarea class="c-input h-52" name="description" placeholder="description"></textarea>
                                    @if ($errors->has('description'))
                                        <p class="text-xs text-error">
                                            {{ $errors->first('description') }}</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
