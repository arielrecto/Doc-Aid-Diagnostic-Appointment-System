@props([
    'total' => $total,
])

<div class="grid grid-cols-4 grid-flow-row gap-4">
    <a class="panel bg-accent max-w-full" href="{{ route('admin.appointment.index') }}">
        <div class="w-full text-xl font-semibold capitalize text-white flex gap-2">
            <i class="ri-book-mark-line"></i>
            <span>
                total appointment
            </span>
        </div>

        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
            {{-- {{ $total }} --}}
            1234567890
        </span>
    </a>
    <a class="panel bg-secondary" href="{{ route('admin.appointment.filter', ['filter' => 'today']) }}">
        <div class="w-full h-32  text-xl font-semibold text-white capitalize">
            today Schedule
        </div>
    </a>
    <a class="panel bg-secondary" href="{{ route('admin.appointment.filter', ['filter' => 'pending']) }}">
        <div class="w-full h-32 text-xl font-semibold text-white capitalize">
            pending appointment
        </div>
    </a>
    <a class="panel bg-secondary" href="{{ route('admin.appointment.filter', ['filter' => 'approved']) }}">
        <div class="w-full h-32 text-xl font-semibold capitalize text-white">
            approved appointment
        </div>
    </a>
</div>
