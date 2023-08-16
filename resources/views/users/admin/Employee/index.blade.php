<x-app-layout>
    <div class="flex">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex-grow flex flex-col gap-2">
            <x-admin-navbar>
                <x-slot name="sample">
                    {{ __('Employee - index') }}
                </x-slot>
            </x-admin-navbar>
            <div class="flex flex-col gap-2 px-5">
                <div class="w-full p-2 flex justify-end">
                    <a href="{{ route('admin.employee.create') }}">
                        <button class="btn btn-accent">Add Employee</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
