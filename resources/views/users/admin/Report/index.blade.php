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
            <div class="panel min-h-screen">
                <h1 class="page-title">
                    Report
                </h1>

                <div class="w-full">

                </div>

                <div class="mt-24 w-full flex justify-end">
                    <h1 class="">Prepared By:</h1>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
