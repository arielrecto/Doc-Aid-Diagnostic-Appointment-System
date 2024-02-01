<x-app-layout>
    <div class="min-h-screen w-full flex flex-col">
        <div class="w-full flex justify-center">
            <div class="w-5/6 p-2">
                <x-landing-page.navbar />
            </div>
        </div>
        <div class="w-full flex justify-center">
            <div class="w-5/6 flex gap-2 p-2 mt-20 overflow-y-hidden">

                <div class="grid grid-cols-4 grid-flow-row gap-2 w-full">
                    @foreach ($services as $service)
                    <a href="{{route('service.show', ['service' => $service->id])}}">
                        <div class="w-full h-96 bg-gray-50 rounded-lg flex flex-col">
                            <div class="w-full h-1/2">
                                <img src="{{ $service->image }}" alt="" srcset=""
                                    class="h-full w-full object object-center object-cover rounded-t-lg">
                            </div>
                            <div class="p-2 flex flex-col justify-between h-full">
                                <div class="w-full max-h-5/6 h-auto">
                                    <h1 class="text-2xl tracking-widest truncate font-bold gap-2 capitalize">
                                        {{ $service->name }}
                                    </h1>
                                    <div class="max-h-full truncate text-xs">
                                        {!! $service->description !!}
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <p class="text-lg text-primary font-bold">₱
                                        {{ $service->price }}</p>
                                </div>
                            </div>
                        </div>
                    </a>

                        {{-- <div class="p-4 w-full bg-white">
                        <div class="h-full bg-gray-100 p-8 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="block w-5 h-5 text-gray-400 mb-4" viewBox="0 0 975.036 975.036">
                                <path
                                    d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z">
                                </path>
                            </svg>

                            <div class="relative">
                                <div class="rating" x-data="displayRating" x-init="initRate({{ $feedback->rate }})">
                                    <template x-for="i in 5">
                                        <input type="radio" name="rating-2"
                                            :class="`mask mask-star-2 ${ i <= rating ?  'bg-orange-400' : 'bg-gray-500' }`" />
                                    </template>

                                </div>
                                <div class="w-full h-full absolute top-0 z-10">

                                </div>
                            </div>


                            <p class="text-xs lg:text-base leading-relaxed mb-6">{{ $feedback->message }}</p>

                            <a class="inline-flex items-center">
                                <img alt="testimonial"
                                    src="{{ $feedback->user->profile->avatar ?? 'https://www.scripps.org/sparkle-assets/images/primary_care_physician_1200x750-163ed71c4c87820817101e72ab78901d.jpg' }}"
                                    class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
                                <span class="flex-grow flex flex-col pl-4">
                                    <span
                                        class="title-font font-medium text-gray-900">{{ $feedback->user->name }}</span>
                                    <span
                                        class="text-gray-500 text-sm">{{ $feedback->user->roles[0]->name }}</span>
                                </span>
                            </a>
                        </div>
                    </div> --}}
                    @endforeach


                </div>
            </div>

        </div>
        @push('js')
            <script>
                const displayRating = () => ({
                    rating: 0,
                    initRate(rate) {
                        this.rating = rate;

                        console.log(this.rating);
                    }
                });
            </script>
        @endpush
</x-app-layout>
