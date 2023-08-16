<x-app-layout>
    <div class="flex">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex-grow flex flex-col gap-2">
            <x-admin-navbar>
                <x-slot name="sample">
                    {{ __('Employee - Create') }}
                </x-slot>
            </x-admin-navbar>
            @if (Session::has('message'))
                <div class="w-full p-2">
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ Session::get('message') }}</span>
                    </div>
                </div>
            @endif
            <div class="flex justify-center items-center gap-2 p-5 w-full h-full">
                <div
                    class=" w-1/2 h-auto flex flex-col gap-2 rounded-lg shadow-sm hover:shadow-lg duration-700 bg-base-100 p-5">
                    <form action="{{ route('admin.employee.store') }}" method="post">
                        @csrf
                        <div class="w-full flex justify-center">
                            <h1 class="text-xl font-semibold">
                                Create Employee Account
                            </h1>
                        </div>
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
                            <button class="btn btn-accent">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
