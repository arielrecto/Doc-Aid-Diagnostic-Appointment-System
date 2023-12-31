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
            <div class="panel min-h-screen overflow-y-auto" x-data="printReport">
                <div class="flex items-center justify-between">
                    <h1 class="page-title">
                        Report
                    </h1>
                    <button class="btn-generic" @click="printElement"><i class="fi fi-rr-print"></i></button>
                </div>

                <div x-ref="printElem">
                    <div class="w-full h-auto border-2 border-gray-100 p-2 flex flex-col gap-2">
                        <div class="w-full bg-gray-100 rounded-lg p-2 flex justify-center">
                            <div class="w-auto flex flex-col">
                                <div class="flex items-center gap-5">
                                    <img src="{{ asset('image/logo.png') }}"
                                        class="object object-center h-10 w-10 rounded-full">
                                    <h1>
                                        DOC AID Diagnostic Center & Medical Clinic
                                    </h1>
                                </div>
                                <p class="text-center text-xs text-gray-500">GF, Lagman-Garcia Bldg., Bacoor</p>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <h1 class="font-bold">Weekly Reports</h1>
                            <h1>Date : {{ now()->format('F d, Y') }}</h1>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row bg-gray-50 p-2">
                            <h1>
                                Days
                            </h1>
                            <h1>
                                Appointments No.
                            </h1>
                            <h1>
                                Total
                            </h1>
                        </div>


                        @foreach ($weeklySales as $sale)
                            <div class="grid grid-cols-3 grid-flow-row py-1 text-xs">
                                <h1>
                                    {{ $sale['name'] }}
                                </h1>
                                <h1>
                                    {{$sale['total_appointments']}}
                                </h1>
                                <h1>
                                    ₱ {{$sale['total_sales']}}
                                </h1>
                            </div>
                        @endforeach

                    </div>

                    <div class="mt-24 w-full flex justify-end p-2">
                        <h1 class="font-bold text-lg">Prepared By: <span>{{ Auth::user()->name }}</span></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
