<div class="w-full p-4 flex bg-primary rounded-lg justify-between">
    <div class="flex flex-col justify-center gap-2 md:flex-row lg:gap-2">
        <div class="w-full md:w-10 md:h-10 flex justify-center">
            <img src="{{ asset('image/logo.png') }}" alt="" srcset=""
                class="h-5 w-5 md:h-full md:w-full rounded-full object object-center">
        </div>
        <p
            class="capitalize text-xs lg:text-base text-center font-semibold flex flex-col md:flex-row md:items-center text-base-100 gap-2">
            <span class="uppercase">Doc aid </span> <span class="hidden md:flex">diagnostic Center & medical clinic</span>
        </p>
    </div>
    <div class="flex gap-2 items-center">
        <a href="/#services">
            <h1
                class="text-base-100 font-thin capitalize text-xs text-center md:text-sm hover:font-bold duration-700 px-2 border-base-100">
                Services
            </h1>
        </a>
        <a href="/#aboutus">
            <h1
                class="text-base-100 font-thin capitalize text-xs text-center md:text-sm hover:font-bold duration-700 px-2 border-base-100">
                About
            </h1>
        </a>


        {{-- <h1
            class="text-base-100 font-thin capitalize  text-sm hover:font-bold duration-700 px-2 border-r-2 border-base-100">
            services
        </h1>
        <h1 class="text-base-100 font-thin capitalize  text-sm hover:font-bold duration-700 px-2">
            services
        </h1> --}}
    </div>
    <div class="flex items-center gap-2">
        @auth

            <a href="{{ route('home') }}" class="btn btn-xs md:btn-sm btn-secondary font-bold text-base-100 capitalize">
                Dashboard
            </a>

        @endauth

        @guest
            <a href="{{ route('login') }}"
                class="text-base-100 font-thin capitalize text-xs md:text-sm hover:font-bold duration-700 px-2">
                login
            </a>
            <a href="{{ route('register') }}" class="btn btn-xs md:btn-sm btn-secondary font-bold text-base-100 capitalize">
                Signup
            </a>
        @endguest

    </div>
</div>
