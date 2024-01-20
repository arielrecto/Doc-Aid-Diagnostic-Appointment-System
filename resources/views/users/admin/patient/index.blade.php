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
                    <h1 class="page-title">Patients</h1>
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
                                        <th>Family Member</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($patients as $patient)
                                        <tr>
                                            <th>{{ $patient->id }}</th>
                                            <td>{{ $patient->name }}</td>
                                            <td>{{ $patient->email }}</td>
                                            @if ($patient->family !== null)
                                                <td>{{ count($patient->family->members) }}</td>
                                            @else
                                                <td>0</td>
                                            @endif

                                            <td>{{ $patient->created_at->format('M-d-Y') }}</td>
                                            <td>
                                                <div class="flex items-center gap-5">
                                                    <a href="{{ route('admin.patient.show', ['patient' => $patient->id]) }}"
                                                        class="btn btn-accent btn-xs">
                                                        <i class="fi fi-rr-eye"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.patient.destroy', ['patient' => $patient->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-xs btn-error">
                                                            <i class="fi fi-rr-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
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
