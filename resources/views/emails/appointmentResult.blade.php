@component('components.message.app')
    <x-slot name="subject">
        <h1 class="w-full text-3xl font-semibold text-center">{{ $data->name }}</h1>
    </x-slot>

    {!! $data->description !!}

    <a href="{{ asset($data->path) }}" download>
        Result file
    </a>

    </div>
@endcomponent
