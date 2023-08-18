@props([
    'total' => $total
])

<div class="grid grid-cols-4 grid-flow-row gap-4">
    <a href="{{ route('admin.appointment.index') }}">
        <div
            class="w-full h-32  rounded-lg bg-base-100 show-sm duration-700 hover:shadow-lg">
            total appointment {{$total}}
        </div>
    </a>
    <a href="{{ route('admin.appointment.filter', ['filter' => 'today']) }}">
        <div
            class="w-full h-32  rounded-lg bg-base-100 show-sm duration-700 hover:shadow-lg">
            today Schedule
        </div>
    </a>
    <a href="{{ route('admin.appointment.filter', ['filter' => 'pending']) }}">
        <div
            class="w-full h-32 rounded-lg bg-base-100 show-sm duration-700 hover:shadow-lg">
            pending appointment
        </div>
    </a>
    <a href="{{ route('admin.appointment.filter', ['filter' => 'approved']) }}">
        <div
            class="w-full h-32 bg-base-100 rounded-lg show-sm duration-700 hover:shadow-lg">
            approved appointment
        </div>
    </a>
</div>
