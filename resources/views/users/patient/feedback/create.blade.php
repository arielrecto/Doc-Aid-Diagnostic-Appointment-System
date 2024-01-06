<x-app-layout>
    <div class="main-screen">

        <x-patient-siderbar />

        <div class="main-content w-5/6">

            <x-patient.navbar />
            @if (Session::has('message'))
                <div role="alert" class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{Session::get('message')}}</span>
                </div>
            @endif

            <div class="panel overflow-y-auto">
                <div class="w-full h-full shadow-sm hover:shadow-lg duration-700">
                    <form action="{{ route('patient.feedbacks.store') }}" method="post"
                        class="p-5 flex flex-col gap-5 w-full h-full" enctype="multipart/form-data"
                        x-data="starRating">
                        @csrf
                        <h1 class="text-lg font-semibold text-center w-full">Feedbacks</h1>
                        <h1 class="text-lg font-bold">Rate
                        </h1>
                        <div class="flex space-x-0 bg-gray-100">

                            <template x-for="(star, index) in ratings" :key="index">
                                <button @click.prevent="rate(star.amount)" @mouseover="hoverRating = star.amount"
                                    @mouseleave="hoverRating = rating" aria-hidden="true" :title="star.label"
                                    class="rounded-sm text-gray-400 fill-current focus:outline-none focus:shadow-outline p-1 w-12 m-0 cursor-pointer"
                                    :class="{
                                        'text-gray-600': hoverRating >= star.amount,
                                        'text-yellow-400': rating >= star
                                            .amount && hoverRating >= star.amount
                                    }">
                                    <svg class="w-15 transition duration-150" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </button>

                            </template>

                        </div>
                        <div class="p-2">
                            <template x-if="rating || hoverRating">
                                <p x-text="currentLabel()"></p>
                            </template>
                            <template x-if="!rating && !hoverRating">
                                <p>Please Rate!</p>
                            </template>
                        </div>
                        <textarea class="textarea textarea-accent" name="message">

                        </textarea>
                        <input type="hidden" x-model="rating" name="rate">

                        <div class="flex w-full p-5 justify-end">
                            <button class="btn btn-accent">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
