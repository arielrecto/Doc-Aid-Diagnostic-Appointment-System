 <div class="w-full bg-base-100 h-32 flex flex-col">
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
 </div>
