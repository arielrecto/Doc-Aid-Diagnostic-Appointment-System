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

            <div class="panel grow">
                <div class="w-full p-2 flex justify-between">
                    <h1 class="page-title">Employee</h1>
                    <a href="{{ route('admin.employee.create') }}">
                        <button class="btn-generic btn-sm uppercase">+ Add</button>
                    </a>
                </div>

                <div class="w-full flex h-full items-center">
                    <div class="w-full border shadow h-full rounded-lg">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr class="uppercase">
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
                                            <td>{{ $employee->created_at->format('M-d-Y') }}</td>
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
