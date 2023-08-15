<div class="w-1/6 overflow-hidden h-full">
    <div class="flex p-4 items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-white border shadow">
            <img src="{{ asset('image/logo-transparent.png') }}" class="object-fill">
        </div>
        <span class="font-bold text-2xl">Admin</span>
    </div>

    {{-- Menus --}}
    <div class="flex flex-col gap-2">
        <ul class="flex flex-col space-y-1 px-3 pt-2">
            <a href="{{ route('admin.dashboard') }}"
                class="flex space-x-2 items-center rounded-md px-4 py-2 group
            {{ Route::is('admin.dashboard')
                ? 'font-bold text-primary '
                : 'hover:text-accent' }} ">
                <i class="fi fi-rr-apps pt-1"></i>
                {{-- <i class='bx bxs-dashboard text-xl'></i> --}}
                <p x-show="toggle">Dashboard</p>
            </a>
            <a href="{{ route('admin.appointment.index') }}"
                class="w-full flex justify-between items-center rounded-md px-4 py-2 group cursor-pointer
            {{ Route::is('admin.appointment.index') 
                ? 'border-r-4 border-accent font-bold text-accent bg-gray-200' 
                : 'hover:text-primary-focus' }}">
                <div class="flex space-x-2 items-center">
                    {{-- <i class='bx bxs-shopping-bag text-xl'></i> --}}
                    <i class="fi fi-rr-edit pt-1"></i>
                    <p x-show="toggle">Appointment </p>
                </div>
            </a>

        </ul>
    </div>
</div>
