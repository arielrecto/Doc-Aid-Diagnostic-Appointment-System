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

<div class="absolute z-10 top-0 w-full h-auto bg-base-100 flex flex-col lg:hidden " x-data="{expanded : false}">
   <div class="w-full flex">
        <button class="text-center btn btn-xs btn-ghost w-full" @click="expanded = !expanded">
            <i class="fi fi-rr-angle-small-down"></i>
        </button>
   </div>
    <div class="h-screen w-full flex flex-col gap-1 text-primary" x-show="expanded" x-collapse x-cloak>
        <ul class="flex flex-col p-4 justify-center w-full">
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

<div
    class="w-4/5 sm:w-1/2 lg:w-1/4 xl:w-1/6 overflow-hidden h-full pl-8 bg-base-100 absolute z-50 lg:static shrink-0 hidden lg:block">

    <div class="flex p-4 items-center gap-4 relative">
        <div class="w-16 h-16 rounded-full bg-white border shadow">
            @if (Auth::user()->profile !== null)
                <img src="{{ Auth::user()->profile->avatar }}" class="object object-top h-16 w-16 object-cover">
            @else
                <img src="{{ asset('image/logo-transparent.png') }}" class="object object-center h-16 w-16">
            @endif
        </div>
        <span class="font-bold text-lg">{{ Auth::user()->name }}</span>
    </div>


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
