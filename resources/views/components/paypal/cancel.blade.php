<x-app-layout>
    <div class="min-h-screen w-full bg-gray-100 flex items-center justify-center">
        <div class="w-auto h-auto flex flex-col gap-2">
            <div class="w-auto flex justify-center">
                <img src="{{asset('image/logo.png')}}" alt="" srcset="" class="object object-center rounded-full h-16 w-16">
            </div>
            <h1 class="text-3xl font-bold"> Something wrong !</h1>
            <a href="{{route('patient.appointment.create')}}" class="link">Return</a>
        </div>
    </div>
</x-app-layout>
