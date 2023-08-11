{{-- @props([
    'user' => $user
]) --}}

<div class="w-full flex flex-col" x-data="navbar">
    <div class="w-full bg-base-100 h-24 flex">
        <div class="flex pl-10 h-full pt-5 flex-grow">
            <input type="text" placeholder="Type here" class="input input-ghost w-full" />
        </div>
        <div class="w-1/5 flex flex-row-reverse p-5 relative">
            <button @click="openToggle" class="flex gap-2">
                <p>{{Auth::user()->name}}</p>
                <i class="fi fi-rr-user"></i>
            </button>
            <div class="absolute z-10 bg-base-100 -bottom-4 shadow-lg rounded-lg pt-2" x-show="toggle" x-transition.duration.700ms>
                <ul class="flex flex-col space-y-2">
                    <li class="p-2 hover:bg-accent hover:font-bold duration-700">
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <button>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @if (isset($sample))
        <div class="w-full bg-base-100 p-5 border-t-2 border-gray-100">
            <h1 class="text-xl font-semibold capitalize">
                {{ $sample }}
            </h1>
        </div>
    @endif

    @if (Route::is('admin.dashboard'))
        <div class="w-full flex gap-2">
            <div class="flex-grow flex flex-col gap-2 p-5">
                <h1 class="font-semibold text-xl">
                    Welcome back, admin
                </h1>
                <p class="text-gray-500 text-xs">
                    update last 7 days
                </p>
            </div>
        </div>
    @endif
</div>


@push('js')
    <script>
        function navbar () {
            return {
                toggle : false,
                openToggle() {
                    this.toggle = !this.toggle
                }
            }
        }
    </script>
@endpush
