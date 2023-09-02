<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />
        <div class="main-content">
            <x-admin.navbar-new />
            {{-- <x-slot name="sample">
                    {{ __('Services') }}
                </x-slot>
            </x-admin-navbar> --}}
            <div class="panel">
                <h1 class="page-title">Services</h1>

                <div class="flex flex-col gap-2 py-5 w-full h-full">
                    <div class="w-full grid grid-cols-2 grid-flow-row gap-4">
                        <div class="header-selection bg-accent">
                            <div class="header-title">
                                <i class="fi fi-rr-person-dolly"></i>
                                Total Services
                            </div>

                            <span class="text-6xl font-bold text-white truncate max-w-[250px]">
                                {{ $total }}
                            </span>
                        </div>

                        <div class="header-selection">
                            <span class="header-title">
                                total of not availble services
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-row-reverse">
                        <a href="{{ route('admin.services.create') }}">
                            <button class="btn-generic uppercase">
                                <i class="ri-add-line"></i>
                                Create
                            </button>
                        </a>
                    </div>

                    <div class="bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700 flex flex-col gap-2">
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <td></td>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Session Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($services as $service)
                                        <tr>
                                            <th><img src="{{ $service->image }}" alt="" srcset=""
                                                    class="w-12 h-12 object-cover object-top"></th>
                                            <th>{{ $service->id }}</th>
                                            <td>{{ $service->name }}</td>
                                            <td>{!! $service->description !!}</td>
                                            <td>{{ $service->price }}</td>
                                            <td>{{ $service->session_time }} min</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="5">
                                                <h1 class="w-full text-center text-lg">
                                                    No Item Service
                                                </h1>
                                            </th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-2">
                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
