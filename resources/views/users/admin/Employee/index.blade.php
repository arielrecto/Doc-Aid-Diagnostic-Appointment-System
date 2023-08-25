<x-app-layout>
    <div class="flex min-h-screen">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex-grow flex flex-col gap-2">
            <x-admin-navbar>
                <x-slot name="sample">
                    {{ __('Employee - index') }}
                </x-slot>
            </x-admin-navbar>
            <div class="flex flex-col gap-2 px-5 w-full min-h-max">
                <div class="w-full p-2 flex justify-end">
                    <a href="{{ route('admin.employee.create') }}">
                        <button class="btn btn-accent">Add Employee</button>
                    </a>
                </div>
                <div class="w-full flex justify-center h-full items-center">
                    <div class="w-5/6 h-full shadow-sm hover:shadow-lg duration-700 rounded-lg bg-base-100">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $employee)
                                        <tr>
                                            <th>{{ $employee->id }}</th>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->created_at->format('M-d-Y')}}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-base-200">
                                            <div>No Employee Account</div>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
