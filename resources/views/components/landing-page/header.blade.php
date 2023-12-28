@props([
    'carousels' => $carousels,
])

<div class="flex flex-col w-full h-screen">
    <div class="w-full h-screen flex relative justify-center bg-base-200">
        <div class="w-5/6 py-5 absolute z-10">
            <x-landing-page.navbar />
        </div>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                @foreach ($carousels as $carousel)
                    <div class="swiper-slide relative">
                        <img src="{{$carousel->image}}" alt="" srcset="">
                        <div class="w-1/2 h-96 flex flex-col space-y-5 absolute z-10 top-1/2 left-10 ">
                            <h1 class="text-5xl font-bold text-parimary tracking-widest capitalize">
                                {{$carousel->title}}
                            </h1>
                            <p>
                                {{$carousel->description}}
                            </p>
                        </div>
                    </div>
                @endforeach



            </div>
            <div class="swiper-pagination"></div>

        </div>
    </div>
</div>
