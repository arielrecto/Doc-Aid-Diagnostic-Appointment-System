{{-- @props([
    'user' => $user
]) --}}

<div class="w-full flex flex-col" x-data="navbar">
    <div class=" h-24 flex item-center">
        <div class="flex h-full py-4 flex-1">
            <input type="text" placeholder="Type here"
                class="input bg-white border focus:outline-none w-1/2 shadow-md" />
        </div>

        <div class="w-1/5 flex items-center justify-end p-4 relative">
            <div class="relative">

                <button @click="openToggle" class="flex gap-2">
                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                    <i class="fi fi-rr-user"></i>
                </button>
                <div class="absolute z-10 bg-white top-full right-0 shadow-lg rounded-lg p-2 w-64" x-show="toggle" x-transition>
                    <ul class="flex flex-col gap-2">
                        <li class="p-2 bg-gray-50 hover:bg-gray-100 text-center text-primary-focus font-bold shadow-md duration-150">
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
    <script>
        function navbar() {
            return {
                toggle: false,
                openToggle() {
                    this.toggle = !this.toggle
                }
            }
        }
    </script>
@endpush
