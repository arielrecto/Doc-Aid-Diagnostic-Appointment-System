@props([
    'carousels' => $carousels,
])

<div class="flex flex-col w-full h-64 lg:h-screen md:h-96">
    <div class="w-full h-screen flex flex-col lg:flex-row relative justify-center bg-base-200">
        <div class="w-full lg:w-5/6 lg:py-5 lg:absolute lg:z-10">
            <x-landing-page.navbar />
        </div>
        <div class="w-full h-full">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">

                    @foreach ($carousels as $carousel)
                        <div class="swiper-slide relative">
                            <img src="{{ $carousel->image }}" alt="" srcset="">
                            <div class="w-1/2 h-96 flex flex-col md:space-y-2 lg:space-y-5 absolute z-10 top-1/2 left-10 ">
                                <h1 class="text-xl md:text-3xl lg:text-5xl font-bold text-parimary tracking-widest capitalize">
                                    {{ $carousel->title }}
                                </h1>
                                <p class="text-xs md:text-sm lg:text-lg">
                                    {{ $carousel->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach



                </div>
                <div class="swiper-pagination"></div>

            </div>
        </div>

    </div>
</div>
