<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />
        <div class="main-content">
            <x-admin.navbar-new />
            @if (Session::has('message'))
                <div class="panel-success">
                    <span>
                        {{ Session::get('message') }}
                    </span>
                </div>
            @endif
            <div class="panel min-h-screen">
                <h1 class="page-title">Carousel</h1>
                <div class="flex justify-end">
                    <a href="{{ route('admin.imageCarousel.create') }}" class="btn-generic">Add Image</a>
                </div>
                <div class="w-full flex flex-col gap-2 max-h-screen overflow-y-auto">
                    @forelse ($images as $image)
                        <div class="border-y-2 border-gray-100 py-4 gap-2 h-32 grid grid-flow-col grid-cols-5">
                            <div class="w-full h-full flex items-center justify-center border-r-2 border-gray-100">
                                <a href="{{ $image->image }}" class="venobox h-auto w-1/3">
                                    <img src="{{ $image->image }}" alt=""
                                        class="object object-center w-full h-full">
                                </a>
                            </div>
                            <div class=" h-full w-full flex items-center justify-center">
                                <h1 class="text-lg font-bold normal-case">{{ $image->title }}</h1>
                            </div>
                            <div class="flex h-full w-full items-center justify-center border-l-2 border-gray-100">
                                <h1 class="truncate">{{ $image->description }}</h1>
                            </div>
                            <div class="flex h-full w-full items-center justify-center border-l-2 border-gray-100">
                                <h1 class="truncate">{{ $image->active ? 'Active' : 'Inactive' }}</h1>
                            </div>
                            <div class="flex h-full w-full items-center justify-center border-l-2 border-gray-100">
                                <div class="w-1/2 flex items-center gap-2">
                                    <a href="{{ route('admin.imageCarousel.show', ['imageCarousel' => $image->id]) }}"
                                        class=" btn btn-sm btn-accent capitalize border border-accent shadow shadow-accent font-bold">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <form
                                        action="{{ route('admin.imageCarousel.destroy', ['imageCarousel' => $image->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            class=" btn btn-sm btn-error capitalize border border-error shadow shadow-error font-bold"><i
                                                class="fi fi-rr-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="w-full h-96 flex justify-center items-center bg-gray-50 rounded-lg hover:shadow-lg duration-700">
                            <a href="{{ route('admin.imageCarousel.create') }}" class="btn-generic">Add Coursel
                                Image</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
