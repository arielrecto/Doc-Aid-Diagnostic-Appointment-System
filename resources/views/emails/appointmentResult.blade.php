@component('components.message.app')
    <div class="w-full flex flex-col gap-2">
        <h1 class="w-full text-3xl font-semibold text-center">{{$data->name}}</h1>
        <div class="w-full p-2">
            {!!$data->description!!}
        </div>
        <div>
            <a href="{{asset($data->path)}}" download>
                Result file
            </a>
        </div>
    </div>
@endcomponent
