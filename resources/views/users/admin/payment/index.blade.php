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
                    <h1 class="page-title">Payment Accounts</h1>
                    <a href="{{ route('admin.paymentAccount.create') }}">
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
                                        <th>Bank Name</th>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($accounts as $account)
                                        <tr>
                                            <th>{{ $account->id }}</th>
                                            <td>{{ $account->account_name}}</td>
                                            <td>{{ $account->account_number }}</td>
                                            {{-- <td>{{ $employee->created_at->format('M-d-Y') }}</td> --}}
                                            <td>
                                                <div class="flex items-center gap-5">
                                                    <a href="{{ route('admin.paymentAccount.edit', ['paymentAccount' => $account->id]) }}"
                                                        class="btn btn-accent btn-xs">
                                                        <i class="fi fi-rr-edit"></i>
                                                    </a>
                                                    <form action="{{route('admin.paymentAccount.destroy', ['paymentAccount' => $account->id])}}" method="post">
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
                                            <div>No Account</div>
                                        </tr>
                                    @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
