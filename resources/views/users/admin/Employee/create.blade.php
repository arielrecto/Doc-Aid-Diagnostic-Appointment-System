<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />

        <div class="main-content">
            <x-admin.navbar-new />

            @if (Session::has('rejected'))
                <div class="panel-error">
                    <span>
                        CODE ERROR - Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, dolor?
                    </span>
                </div>
            @endif

            @if (Session::has('approved'))
                <div class="panel-success">
                    <span>
                        CODE SUCCESS - Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, voluptatum?
                    </span>
                </div>
            @endif

            @if (Session::has('message'))
                <div class="panel-success">
                    <span>{{ Session::get('message') }}</span>
                </div>
            @endif

            <div class="panel">
                <h1 class="page-title">Create New Employee</h1>
                <div class="h-auto flex flex-col gap-2 rounded p-4">
                    <form action="{{ route('admin.employee.store') }}" method="post">
                        @csrf

                        <div class="flex flex-col space-y-5 w-full">
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm text-gray-500">Full Name</label>
                                <input type="text" class="input input-accent w-full" placeholder="Full Name"
                                    name="name">
                                @if ($errors->has('name'))
                                    <p class="text-xs text-error">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm text-gray-500">Email</label>
                                <input type="email" class="input input-accent w-full" placeholder="Email"
                                    name="email">
                                @if ($errors->has('email'))
                                    <p class="text-xs text-error">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm text-gray-500">Password</label>
                                <input type="password" class="input input-accent w-full" placeholder="Password"
                                    name="password">
                                @if ($errors->has('password'))
                                    <p class="text-xs text-error">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm text-gray-500">Confirm Password</label>
                                <input type="password" class="input input-accent w-full" placeholder="Confirm Password"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="flex justify-end p-2">
                            <button class="btn-generic btn-sm uppercase">+ Create Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
