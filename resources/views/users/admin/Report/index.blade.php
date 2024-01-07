<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />
        <div class="main-content">
            <x-admin.navbar-new />
            @if (Session::has('message'))
                <div class="panel-success">
                    <span>
                        {{ Session::get('message') }}
                    </span>
                </div>
            @endif
            <div class="panel min-h-screen overflow-y-auto">
                <h1 class="page-title">
                    Report
                </h1>
                <div>
                    <div class="w-full h-auto border-2 border-gray-100 p-2">
                        <div class="grid grid-cols-3 grid-flow-row bg-gray-50 p-2">
                            <h1>
                                Days
                            </h1>
                            <h1>
                                No.
                            </h1>
                            <h1>
                                Total
                            </h1>
                        </div>
                        @for ($i = 0; $i < 7; $i++)
                            <div class="grid grid-cols-3 grid-flow-row py-1">
                                <h1>
                                    Example {{ $i }}
                                </h1>
                                <h1>
                                    3
                                </h1>
                                <h1>
                                    12300
                                </h1>
                            </div>
                        @endfor
                    </div>

                    <div class="mt-24 w-full flex justify-end">
                        <h1 class="">Prepared By:</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
