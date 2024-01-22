@props([
    'total' => $total,
    'pending' => $pending,
    'approved' => $approved,
    'done' => $done
])

@php
    use App\Enums\AppointmentStatus;
@endphp

<div class="grid grid-cols-5 grid-flow-row gap-4">
    <a class="header-selection bg-accent max-w-full" href="{{ route('admin.appointment.index') }}">
        <div class="w-full text-sm 2xl:text-lg font-semibold text-white capitalize">
            <i class="ri-book-mark-line"></i>
            <span>
                total appointment
            </span>
        </div>

        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
            {{ $total }}
        </span>
    </a>
    <a class="header-selection" href="{{ route('admin.appointment.index', ['filter' => 'today']) }}">
        <div class="header-title">
            today Schedule
        </div>
    </a>
    <a class="header-selection" href="{{  route('admin.appointment.index', ['filter' => AppointmentStatus::PENDING->value]) }}">
        <div class="header-title">
            pending appointment
        </div>
         <span class="text-6xl font-bold text-white truncate max-w-[250px]">
            {{ $pending }}
        </span>
    </a>
    <a class="header-selection" href="{{ route('admin.appointment.index', ['filter' => AppointmentStatus::APPROVED->value]) }}">
        <div class="header-title">
            approved appointment
        </div>
        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
            {{ $approved }}
        </span>
    </a>
    <a class="header-selection" href="{{ route('admin.appointment.index', ['filter' => AppointmentStatus::DONE->value]) }}">
        <div class="header-title">
            Done appointment
        </div>
        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
            {{ $done }}
        </span>
    </a>
</div>
