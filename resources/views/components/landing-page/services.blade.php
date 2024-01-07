@props(['services'])

<div class="w-full min-h-screen flex justify-center gap-2 bg-white" data-aos="fade-right" id="services">

    <div class="flex flex-col w-full mt-24 md:w-5/6">

        <section class="text-gray-600 body-font">
            <div class="container md:px-5 py-18 md:py-24 mx-auto">
                <div class="flex flex-wrap w-full mb-20">
                    <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                        <h1 class="text-lg lg:text-3xl md:text-2xl font-medium title-font mb-2 text-gray-900 flex flex-col gap-2">
                            <span class="text-primary font-bold">Doc Aid Medial & Diagnostics</span>
                            <span class="text-sm md:text-xl border-b-2 border-primary">Services Offered</span>
                        </h1>

                    </div>
                    {{-- <p class="lg:w-1/2 w-full leading-relaxed text-gray-500">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table. Franzen you probably haven't heard of them man bun deep jianbing selfies heirloom prism food truck ugh squid celiac humblebrag.</p> --}}
                </div>
                <div class="flex flex-wrap lg:-m-4 h-96 max-h-lg overflow-y-hidden">
                    @foreach ($services as $service)
                        <div class="xl:w-1/4 md:w-1/2 p-4 w-full">
                            <div class="bg-base-100 p-6 rounded-lg">
                                <img class="h-40 rounded w-full object-cover object-center mb-6"
                                    src="{{$service->image}}" alt="content">
                                {{-- <h3 class="tracking-widest text-indigo-500 text-xs font-medium title-font">SUBTITLE</h3> --}}
                                <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{$service->name}}</h2>
                                <p class="leading-relaxed text-base truncate">{!!$service->description!!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

</div>


<div class="w-full min-h-screen flex justify-center gap-2">
    <div class="w-full md:w-5/6 flex flex-col gap-2 py-5">
        <h1 class="text-lg md:text-2xl lg:text-4xl font-bold text-primary capitalize" data-aos="fade-left"> your health our passion
        </h1>
        {{-- <div class="card lg:card-side shadow-xl bg-white">
            <figure><img src="https://www.liveandinvestoverseas.com/wp-content/uploads/2019/10/best-health-care-overseas.jpg" alt="Album"/></figure>
            <div class="card-body">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Before they sold out
                    <br class="hidden lg:inline-block">readymade gluten
                </h1>
              <p>Copper mug try-hard pitchfork pour-over freegan heirloom neutra air
                plant cold-pressed tacos poke beard tote bag. Heirloom echo park mlkshk tote bag selvage hot
                chicken authentic tumeric truffaut hexagon try-hard chambray.</p>
              <div class="card-actions justify-end">
                <button class="btn btn-primary">Listen</button>
              </div>
            </div>
          </div> --}}
        <section class="text-gray-600 body-font " data-aos="fade-right">
            <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div
                    class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">{{$services[0]->name ?? 'Stephen Bacolor'}}
                        {{-- <br class="hidden lg:inline-block">readymade gluten --}}
                    </h1>
                    <p class="mb-8 leading-relaxed text-sm">{!!$services[0]->description ?? 'Ganda Mo tii'!!}</p>
                    <div class="flex justify-center">
                        <button
                            class="inline-flex text-white bg-primary border-0 py-2 px-6 focus:outline-none
                            ounded text-lg">View</button>
                        {{-- <button
                            class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0
                             py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Button</button> --}}
                    </div>
                </div>
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                    <img class="object-cover object-center rounded" alt="hero"
                        src="{{$services[0]->image ?? 'https://www.myhealth.ph/wp-content/uploads/2021/04/Homer-serice-600x250.png'}}">
                </div>
            </div>
        </section>

        <section class="text-gray-600 body-font" data-aos="fade-left">
            <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                    <img class="object-cover object-center rounded" alt="hero"
                        src="{{$services[1]->image ?? 'https://www.myhealth.ph/wp-content/uploads/2021/04/Homer-serice-600x250.png'}}">
                </div>
                <div
                    class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                    <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">{{$services[1]->name ?? 'Stephen Bacolor'}}
                        {{-- <br class="hidden lg:inline-block">readymade gluten --}}
                    </h1>
                    <p class="mb-8 leading-relaxed">{!!$services[1]->description ?? 'Ganda Mo Tii'!!}</p>
                    <div class="flex justify-center">
                        <button
                            class="inline-flex text-white bg-primary border-0 py-2 px-6 focus:outline-none rounded text-lg">View</button>
                        {{-- <button
                            class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Button</button> --}}
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>
