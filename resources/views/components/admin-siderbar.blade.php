<div class="h-auto min-h-screen flex flex-col w-full py-8 border-r border-gray-300 bg-base-100 relative"
    x-data="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="h-16 flex gap-2 border-b-2 border-accent p-2 ">
        <img src="{{ asset('image/logo.png') }}" alt="" srcset="" class="w-12 h-auto rounded-full">
        <p class="text-xs text-center" x-show="toggle">
            Doc Aid Diagnostic <br> & <br> Medical Center
        </p>
    </a>
    <button class="bg-base-100 rounded-full px-3 py-2 shadow-lg absolute -right-5" @click="openToggle()">
        <i :class="`fi fi-rr-angle-${toggle ? 'left' : 'right'}`"></i>
    </button>
    <ul class="flex flex-col space-y-1 px-3 pt-2">
        <a href="{{ route('admin.dashboard') }}"
            class="flex space-x-2 items-center rounded-md px-4 py-2 group
            {{ Route::is('admin.dashboard') ? 'border-r-4 border-accent font-bold text-accent bg-gray-200' : 'hover:text-accent duration-700 hover:font-bold hover:bg-gray-200' }} ">
            <i class="fi fi-rr-apps pt-1"></i>
            {{-- <i class='bx bxs-dashboard text-xl'></i> --}}
            <p x-show="toggle">Dashboard</p>
        </a>
        <a href="{{ route('admin.appointment.index') }}"
            class="w-full flex justify-between items-center rounded-md px-4 py-2 group cursor-pointer
            {{ Route::is('admin.appointment.index') ? 'border-r-4 border-accent font-bold text-accent bg-gray-200 ' : 'hover:text-accent duration-700 hover:font-bold hover:bg-gray-200 ' }}">
            <div class="flex space-x-2 items-center">
                {{-- <i class='bx bxs-shopping-bag text-xl'></i> --}}
                <i class="fi fi-rr-edit pt-1"></i>
                <p x-show="toggle">Appointment </p>
            </div>
        </a>
        <a href="{{ route('admin.services.index') }}"
            class="w-full flex justify-between items-center rounded-md px-4 py-2 group cursor-pointer
            {{ Route::is('admin.services.index') || Route::is('admin.services.create') ? 'border-r-4 border-accent font-bold text-accent bg-gray-200 ' : 'hover:text-accent duration-700 hover:font-bold hover:bg-gray-200 ' }}">
            <div class="flex space-x-2 items-center">
                <i class="fi fi-rr-list-check pt-1"></i>
                <p x-show="toggle">Services</p>
            </div>
        </a>

        <a href="{{route('admin.employee.index')}}"
            class="w-full flex justify-between items-center rounded-md px-4 py-2 group cursor-pointer
            {{ Route::is('admin.employee.index') || Route::is('admin.employee.create') ? 'border-r-4 border-accent font-bold text-accent bg-gray-200 ' : 'hover:text-accent duration-700 hover:font-bold hover:bg-gray-200 ' }}">
            <div class="flex space-x-2 items-center">
                <i class="fi fi-rr-users-alt pt-1"></i>
                <p class="text-lg " x-show="toggle">Employee</p>
            </div>
        </a>
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

        <a href="" class="flex space-x-2 items-center rounded-md px-4 py-2 group hover:bg-gray-200 ">
            <i class='bx bx-notepad text-xl'></i>
            <p class="text-lg " x-show="toggle">Inventory</p>
        </a>
        <a href="" class="flex space-x-2 items-center rounded-md px-4 py-2 group hover:bg-gray-200 ">
            <i class='bx bx-notepad text-xl'></i>
            <p class="text-lg " x-show="toggle">Setting</p>
        </a>
    </ul>
</div>


@push('js')
    <script>
        function sidebar() {
            return {
                toggle: true,
                openToggle() {
                    this.toggle = !this.toggle
                }
            }
        }
    </script>
@endpush
