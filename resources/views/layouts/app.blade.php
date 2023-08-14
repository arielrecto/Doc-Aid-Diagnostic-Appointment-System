<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- full calendar css -->
    <script src="
        https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js
        "></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Transition -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- ICONS -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>


    <!-- Apex Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!--Day js-->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>


    <!-- quill editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<style>
    .fc-bg-event {
        background-color: '#04ABA3',
    }
</style>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Heading -->
        {{-- @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@stack('js')

</html>
