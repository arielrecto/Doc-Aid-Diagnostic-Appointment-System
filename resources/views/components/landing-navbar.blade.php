<div class="w-full m-0 p-0 flex">
    <div class="flex-grow flex p-2 gap-2">
        <img src="{{ asset('image/logo.png') }}" alt="" srcset="" class="rounded-full w-12 h-12">
        <h1 class="capitalized font-bold text-lg text-neutral mt-2">
            Doc Aid Diagnostic and medical Center
        </h1>
    </div>

    @if (!Auth::user())
        <div class="w-1/5 flex flex-row-reverse capitalize p-2 gap-4">
            <a href="{{ route('login') }}" class="btn btn-base-100">login</a>
            <a href="{{ route('register') }}" class="btn btn-ghost text-neutral">Register</a>
        </div>
    @elseif(Auth::user()->hasRole('patient'))
        <div class="w-1/5 flex flex-row-reverse capitalize p-2 gap-4">
            <a href="{{ route('patient.dashboard') }}" class="btn btn-base-100 capitalize">Return Dashboard</a>
        </div>
    @elseif(Auth::user()->hasRole('admin'))
        <div class="w-1/5 flex flex-row-reverse capitalize p-2 gap-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-base-100 capitalize">Return Dashboard</a>
        </div>
    @elseif(Auth::user()->hasRole('employee'))
        <div class="w-1/5 flex flex-row-reverse capitalize p-2 gap-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-base-100 capitalize">Return Dashboard</a>
        </div>
    @endif
</div>
