<div class="w-full h-24 bg-base-100 flex">
    <div class="flex-grow">
        <h1 class="text-xl font-bold capitalize">
            employee - {{ Auth::user()->name }}
        </h1>
    </div>
    <div>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button>Log out </button>
        </form>
    </div>
</div>
