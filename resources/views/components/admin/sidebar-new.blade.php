    @php
        $routes = [
            'Dashboard' => [
                'route' => 'admin.dashboard',
                'icon' => 'fi fi-rr-apps pt-1',
            ],

            'Appointment' => [
                'route' => 'admin.appointment.index',
                'icon' => 'fi fi-rr-edit pt-1',
            ],

            'Services' => [
                'route' => 'admin.services.index',
                'icon' => 'fi fi-rr-list-check pt-1',
            ],

            'Employee' => [
                'route' => 'admin.employee.index',
                'icon' => 'fi fi-rr-users-alt pt-1',
            ],
            'Carousel' => [
                'route' => 'admin.imageCarousel.index',
                'icon' => 'fi fi-rr-copy-image pt-1',
            ],
            'Sales Report' => [
                'route' => 'admin.report.index',
                'icon' => 'fi fi-rr-stats pt-1',
            ],
        ];
    @endphp


    <div class="w-4/5 sm:w-1/2 lg:w-1/3 xl:w-1/6 overflow-hidden h-full pl-8 bg-base-100 absolute z-50 lg:static shrink-0">
        <div class="flex p-4 items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-white border shadow">
                <img src="{{ asset('image/logo-transparent.png') }}" class="object-fill">
            </div>
            <span class="font-bold text-2xl">Admin</span>
        </div>

        {{-- Menus --}}
        <div class="flex flex-col gap-1">
            <ul class="flex flex-col p-4">

                @foreach ($routes as $name => $values)
                    <a href="{{ route($values['route']) }}"
                        class="nav-link
            {{ Route::is($values['route']) ? 'font-bold text-primary ' : 'hover:text-accent' }} ">
                        <i class="{{ $values['icon'] }}"></i>
                        <p x-show="toggle">{{ $name }}</p>
                    </a>
                @endforeach

            </ul>
        </div>
    </div>
