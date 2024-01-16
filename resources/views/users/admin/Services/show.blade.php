<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />

        <div class="main-content">
            <x-admin.navbar-new />
            <div class="panel">
                <div class="flex gap-2 h-96 w-full">
                    <div class="w-1/4 h-full">
                        <img src="{{ $service->image }}" alt="" class="h-64 w-64 object object-center">
                        <h1 class="text-center text-semibold p-2">{{ $service->name }}</h1>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="w-full flex flex-col gap-2">
                                <span class="text-gray-400 text-xs">Price</span>
                                <h1 class="text-semibold text-sm">
                                    {{ $service->price }}
                                </h1>
                            </div>
                            <div class="w-full flex flex-col gap-2">
                                <span class="text-gray-400 text-xs">Downpayment</span>
                                <h1 class="text-semibold text-sm">
                                    {{ $service->init_payment }}
                                </h1>
                            </div>
                            <div>
                                <h1 class="text-xs text-gray-400 xs">Status:
                                    <span class="text-semibold text-sm text-black">{{$service->availability->name}}</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        {!! $service->description !!}
                    </div>
                </div>
                <div class="w-full flex justify-end p-2 space-x-2">
                    <a href="{{ route('admin.services.edit', ['service' => $service->id]) }}">
                        <button class="btn-generic">Edit</button>
                    </a>

                    {{-- <form action="{{ route('admin.services.destroy', ['service' => $service->id]) }}" method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                        class="btn btn-sm btn-error capitalize border border-error shadow shadow-error font-bold">Delete</button>
                    </form> --}}


                    @if ($service->availability->name == 'INACTIVE')
                        <form action="{{ route('admin.service.availability', ['Service' => $service->id]) }}" method="POST">

                            @csrf
                            @method('patch')
                            <input type="hidden" name="availability" value="ACTIVE">
                            <button
                                class="btn btn-sm btn-accent capitalize border border-accent shadow shadow-accent font-bold">Restor</button>

                        @else
                            <form action="{{ route('admin.service.availability', ['Service' => $service->id]) }}" method="POST">

                                @csrf
                                @method('patch')
                                <input type="hidden" name="availability" value="INACTIVE">
                                <button
                                    class="btn btn-sm btn-accent capitalize border border-accent shadow shadow-accent font-bold">Archive</button>
                            </form>
                    @endif
                </div>
            </div>
            {{-- <div class="panel">
                <h1>

                </h1>
                <div class="w-full grid grid-cols-3 grid-flow-row gap-2 h-32">
                    <div class="header-selection bg-accent">
                        <h1 class="header-title">
                            total Appointments
                        </h1>
                    </div>
                    <div class="header-selection">
                        <h1 class="header-title">
                            sales
                        </h1>
                    </div>
                    <div class="header-selection">
                        <h1 class="header-title">

                        </h1>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
