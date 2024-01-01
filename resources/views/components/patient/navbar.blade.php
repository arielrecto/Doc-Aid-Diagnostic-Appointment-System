 {{-- <div class="w-full bg-base-100 h-32 flex flex-col">
     <div class="flex w-full h-5/6 border-b-2 border-gray-50 pl-5">
         <h1 class="text-center">
             Patient - {{ Auth::user()->name }}
         </h1>

         <div>
             <form action="{{ route('logout') }}" method="post">
                 @csrf
                 <button>Logout</button>
             </form>
         </div>
     </div>
     <div class="w-full bg-gray-50 pl-5">
         @if (isset($header))
             <h1 class="text-lg font-bold capitalize p-2">
                 {{ $header }}
             </h1>
         @endif
     </div>
 </div> --}}

 {{-- @props([
    'user' => $user
]) --}}

<div class="w-full flex flex-col" x-data="navbar">
    <div class=" h-24 flex item-center">
        <div class="flex h-full py-7 lg:py-4 flex-1">
            <input type="text" placeholder="Type here"
                class="w-full lg:w-1/2 input-generic" />
        </div>

        <div class="w-1/3 md:w-1/4 flex items-center justify-end p-1 md:p-2 lg:p-4 relative">
            <div class="relative">

                <button @click="openToggle" class="flex gap-2 text-xs md:text-base">
                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                    <i class="fi fi-rr-user"></i>
                </button>
                <div class="absolute z-10 bg-white top-full right-0 shadow-lg rounded-lg p-2  w-16 md:w-32 lg:w-64" x-cloak x-show="toggle" x-transition>
                    <ul class="flex flex-col lg:gap-2">
                        <li class="p-2 text-xs  lg:text-base bg-gray-50 hover:bg-gray-100 text-center text-primary-focus font-bold shadow-md duration-150">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{-- @if (isset($sample))
        <div class="w-full bg-base-100 p-5 border-t-2 border-gray-100">
            <h1 class="text-xl font-semibold capitalize">
                {{ $sample }}
            </h1>
        </div>
    @endif --}}


</div>


@push('js')
    {{-- <script>
        function navbar() {
            return {

            }
        }
    </script> --}}
@endpush

