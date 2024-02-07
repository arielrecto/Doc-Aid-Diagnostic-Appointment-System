<x-app-layout>
<div class="min-h-screen w-full flex flex-col">
    <div class="w-full flex justify-center">
        <div class="w-5/6 p-2">
            <x-landing-page.navbar/>
        </div>
    </div>
    <div class="w-full flex justify-center">
        <div class="w-full md:w-5/6 flex flex-col md:flex-row gap-2 p-2 mt-20">
            <div class="flex gap-2 md:w-1/3 lg:h-96 md:h-64">
                <img src="{{$service->image}}" alt="" srcset="" class="object objec-center h-full w-auto">
            </div>
            <div class="flex flex-col gap-2 ml-5 lg:w-4/6 md:w-1/2">
                <div class="min-h-[20rem] max-h-auto border-b-2 border-gray-300 flex flex-col">
                    <h1 class="text-2xl lg:text-5xl md:text-3xl font-bold capitalize tracking-widest">
                        {{$service->name}}
                    </h1>
                    <div class="min-h-[12rem] h-auto">
                        <p class="whitespace-pre-line text-xs lg:text-sm">
                            {!!$service->description!!}
                        </p>

                    </div>

                    <div class="flex flex-col gap-2">
                        <h1 class="text-sm lg:text-lg">Available</h1>
                        <div class="flex gap-2 w-full overflow-x-auto">

                            @foreach ($service->days as $day)
                                <h1 class="text-xs lg:text-sm text-gray-700 p-2 border-2 rounded-lg">{{$day->name}}</h1>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="flex justify-end">
                   <p class="text-2xl lg:text-4xl font-bold gap-2">  &#8369 {{$service->price}}</p>
                </div>
            </div>
        </div>
    </div>

</div>

</x-app-layout>
