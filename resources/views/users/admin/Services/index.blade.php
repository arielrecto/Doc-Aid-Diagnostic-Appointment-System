<x-app-layout>
    <div class="flex">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex-grow flex flex-col gap-2">
            <x-admin-navbar>
                <x-slot name="sample">
                    {{ __('Services') }}
                </x-slot>
            </x-admin-navbar>
            <div class="flex flex-col gap-2 px-5">
                <div class="w-full grid grid-cols-2 grid-flow-row gap-4">
                    <div
                        class="w-full text-base-100 bg-accent h-32 rounded-lg shadow-sm hover:shadow-lg duration-700 p-2 flex justify-center items-center">
                        <div class="flex flex-col gap-2 duration-700 rounded-lg hover:scale-105">
                            <div class="flex space-x-4 p-2">
                                <p class="text-lg bg-teal-700 rounded-lg px-2 py-1">
                                    <i class="fi fi-rr-person-dolly"></i>
                                </p>
                                <h1 class="flex gap-2 items-center font-semibold">
                                    Total Services
                                </h1>
                            </div>
                            <div class="w-38 border-b-2 border-base-100 rounded-lg p-2">
                                <h1 class="font-bold text-3xl h-1/2 w-full text-center">
                                    {{ $total }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="w-full bg-base-100 h-32 rounded-lg shadow-sm hover:shadow-lg duration-700">
                        total of not availble services
                    </div>
                </div>
                <div class="flex flex-row-reverse">
                    <a href="{{ route('admin.services.create') }}">
                        <button class="btn btn-accent capitalize">Add new services</button>
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
</x-app-layout>
