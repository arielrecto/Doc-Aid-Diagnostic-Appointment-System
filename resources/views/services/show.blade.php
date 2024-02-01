<x-app-layout>
<div class="min-h-screen w-full flex flex-col">
    <div class="w-full flex justify-center">
        <div class="w-5/6 p-2">
            <x-landing-page.navbar/>
        </div>
    </div>
    <div class="w-full flex justify-center">
        <div class="w-5/6 flex gap-2 p-2 mt-20 ">
            <div class="flex gap-2">
                <img src="{{$service->image}}" alt="" srcset="" class="object objec-center h-96 w-auto">
            </div>
            <div class="flex flex-col gap-2 ml-5 w-full">
                <div class="min-h-[20rem] max-h-auto border-b-2 border-gray-300">
                    <h1 class="text-5xl font-bold capitalize tracking-widest">
                        {{$service->name}}
                    </h1>
                    <div class="min-h-[12rem] h-auto">
                        <p class="whitespace-pre-line">
                            {!!$service->description!!}
                        </p>

                    </div>

                    <div class="flex flex-col gap-2">
                        <h1 class="text-lg">Available</h1>
                        <div class="flex gap-2">

                            @foreach ($service->days as $day)
                                <h1 class="text-sm text-gray-700 p-2 border-2 rounded-lg">{{$day->name}}</h1>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="flex justify-end">
                   <p class="text-4xl font-bold gap-2">  &#8369 {{$service->price}}</p>
                </div>
            </div>
        </div>
    </div>

</div>

</x-app-layout>
