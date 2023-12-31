{{-- <div class="h-auto min-h-screen flex flex-col space-y-2 w-full py-8 bg-base-100">
    <div class="w-full flex gap-2 h-24 items-center">
       <img src="{{asset('image/logo.png')}}" alt="" srcset="" class="rounded-full h-12 w-12 object-cover">
       <p class="capitalize text-base text-center font-semibold">
            Doc aid diagnostic & medical center
       </p>
    </div>
    <ul class="flex flex-col space-y-4 px-3">
        <a href="{{route('patient.dashboard')}}" class="items-center rounded-md p-2 group hover:bg-gray-100
        {{Route::is('patient.dashboard') ? 'text-accent font-semibold border-b-4 border-accent duration-700' : 'hover:text-accent hover:font-semibold hover:border-b-4 hover:border-accent duration-700'}}">
        <div class="flex space-x-2">
            <i class="fi fi-rr-dashboard text-lg"></i>
            <p class="text-base">Dashboard</p>
        </div>

        </a>
        <a href="{{route('patient.appointment.index')}}" class="items-center rounded-md p-2 group hover:bg-gray-100
        {{Route::is('patient.appointment.index') || Route::is('patient.appointment.create') ? 'text-accent font-semibold border-b-4 border-accent duration-700' : 'hover:text-accent hover:font-semibold hover:border-b-4 hover:border-accent duration-700'}}">
            <div class="flex space-x-2">
                <i class="fi fi-rr-calendar-clock text-lg"></i>
                <p class="text-base ">Appointment</p>
            </div>
        </a>
        <a href="{{route('patient.family.index')}}" class="items-center rounded-md p-2 group hover:bg-gray-100
        {{Route::is('patient.family.index') || Route::is('patient.family.create') ? 'text-accent font-semibold border-b-4 border-accent duration-700' : 'hover:text-accent hover:font-semibold hover:border-b-4 hover:border-accent duration-700'}}">
            <div class="flex space-x-2">
                <i class="fi fi-rr-users-alt text-lg"></i>
                <p class="text-base ">Family</p>
            </div>
        </a>
        <a href="{{route('patient.profile.show', ['profile' => Auth::user()->profile->id ?? 0])}}" class="items-center rounded-md p-2 group hover:bg-gray-100
        {{Route::is('patient.profile.show') || Route::is('patient.profile.create') ? 'text-accent font-semibold border-b-4 border-accent duration-700' : 'hover:text-accent hover:font-semibold hover:border-b-4 hover:border-accent duration-700'}}">
            <div class="flex space-x-2">
                <i class="fi fi-rr-user text-lg"></i>
                <p class="text-base ">Profile</p>
            </div>
        </a>
        {{-- <a href="" class="w-full flex justify-between items-center rounded-md px-4 py-2 group hover:bg-gray-200 cursor-pointer">
            <div class="flex space-x-2 items-center">
                <i class='bx bxs-shopping-bag text-xl'></i>
                <p class="text-lg ">Admin User list </p>
            </div>
        </a> --}}
{{-- <div id="productLinks" class="flex flex-col hidden px-2 border-t border-gray-300 py-1">
            <a href="{{route('admin.products.create')}}" class="flex space-x-2 items-center rounded-md px-4 py-2 group hover:bg-gray-200 ">
                <i class='bx bx-plus-circle text-xl'></i>
                <p class="text-base ">Add New</p>
            </a>
            <a href="{{route('admin.products.index')}}" class="flex space-x-2 items-center rounded-md px-4 py-2 group hover:bg-gray-200 ">
                <i class='bx bx-list-ul text-xl'></i>
                <p class="text-base ">List</p>
            </a>
        </div> --}}

{{-- <a href="" class="flex space-x-2 items-center rounded-md px-4 py-2 group hover:bg-gray-200 ">
            <i class='bx bx-notepad text-xl'></i>
            <p class="text-lg ">Inventory</p>
        </a>
        <a href="" class="flex space-x-2 items-center rounded-md px-4 py-2 group hover:bg-gray-200 ">
            <i class='bx bx-notepad text-xl'></i>
            <p class="text-lg ">Setting</p>
        </a>
    </ul>
</div> --}}



@php
    $routes = [
        'Dashboard' => [
            'route' => 'patient.dashboard',
            'icon' => 'fi fi-rr-apps pt-1',
        ],

        'Appointment' => [
            'route' => 'patient.appointment.index',
            'icon' => 'fi fi-rr-edit pt-1',
        ],

        'Family' => [
            'route' => 'patient.family.index',
            'icon' => 'ri-group-line pt-1',
        ],

        // 'Profile' => [
        //     'route' => "patient.profile.show', ['profile' => Auth::user()->profile->id ?? 0]",
        //     'icon' => 'fi fi-rr-users-alt pt-1',
        // ],
    ];
@endphp


<div class="w-4/5 sm:w-1/2 lg:w-1/3 xl:w-1/6 overflow-hidden h-full pl-8 bg-base-100 absolute z-50 lg:static shrink-0">
    <div class="flex p-4 items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-white border shadow">
            @if (Auth::user()->profile !== null)
                <img src="{{ Auth::user()->profile->avatar }}" class="object object-top h-16 w-16 object-cover">
            @else
                <img src="{{ asset('image/logo-transparent.png') }}" class="object object-center h-16 w-16">
            @endif
        </div>
        <span class="font-bold text-2xl">{{ Auth::user()->name }}</span>
    </div>

    {{-- Menus --}}
    <div class="flex flex-col gap-1 text-primary">
        <ul class="flex flex-col p-4">

            @foreach ($routes as $name => $values)
                <a href="{{ route($values['route']) }}"
                    class="nav-link
                    {{ Route::is($values['route']) ? 'font-bold text-primary ' : 'hover:text-accent' }} ">
                    <i class="{{ $values['icon'] }}"></i>
                    <p>{{ $name }}</p>
                </a>
            @endforeach
            <a href="{{ route('patient.profile.show', ['profile' => Auth::user()->profile->id ?? 0]) }}"
                class="nav-link
            {{ Route::is('patient.profile.show') || Route::is('patient.profile.create') ? 'font-bold text-primary ' : 'hover:text-accent' }} ">
                <i class="ri-profile-line pt-1"></i>
                <p>Profile</p>
            </a>
        </ul>
    </div>
</div>
