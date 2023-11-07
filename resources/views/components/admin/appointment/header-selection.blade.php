@props([
    'total' => $total,
])

<div class="grid grid-cols-4 grid-flow-row gap-4">
    <a class="header-selection bg-accent max-w-full" href="{{ route('admin.appointment.index') }}">
        <div class="w-full text-xl font-semibold capitalize text-white flex gap-2">
            <i class="ri-book-mark-line"></i>
            <span>
                total appointment
            </span>
        </div>

        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
            {{ $total }}
        </span>
    </a>
    <a class="header-selection" href="{{ route('admin.appointment.filter', ['filter' => 'today']) }}">
        <div class="header-title">
            today Schedule
        </div>
    </a>
    <a class="header-selection" href="{{ route('admin.appointment.filter', ['filter' => 'pending']) }}">
        <div class="header-title">
            pending appointment
        </div>
    </a>
    <a class="header-selection" href="{{ route('admin.appointment.filter', ['filter' => 'approved']) }}">
        <div class="header-title">
            approved appointment
        </div>
    </a>
</div>
