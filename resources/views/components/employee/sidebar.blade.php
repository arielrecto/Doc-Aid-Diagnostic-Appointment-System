<div class="w-1/6 h-screen bg-base-100 flex flex-col space-y-2">
    <div class="h-24 w-full p-2 flex border-b-2 border-accent">
        <img src="{{asset('image/logo.png')}}" alt="" srcset="" class="rounded-lg w-16">
        <p class="flex-grow text-sm font-medium text-center pt-2">
            Doc Aid Diagnostic <br> & <br> Medical Center
        </p>
    </div>
    <ul class="w-full capitalize flex flex-col gap-4">
        <li class="text-center font-lg  p-4 duration-700 {{Route::is('employee.dashboard') ? 'text-accent border-r-4 border-accent bg-gray-100 font-bold' : 'hover:text-accent hover:border-r-4 hover:border-accent hover:bg-gray-100 hover:font-bold'}}">
            dashboard
        </li>
    </ul>
</div>
