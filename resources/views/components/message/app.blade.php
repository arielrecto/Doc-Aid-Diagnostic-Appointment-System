<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>

    </style>
</head>
<style>
    .min-h-screen{
        min-height: 100vh;
    }
    .w-full {
        width: 100%;
    }

    .flex {
        display: flex;
    }

    .flex-col {
        flex-direction: column;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .text-3xl {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }
    .font-semibold {
        font-weight: 600;
    }
    .p-2{
        padding: 0.5rem;
    }
    .text-center {
        text-align: center;
    }
    .bg-gray-100 {
        background-color: #dcd6d6;
    }
</style>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <main>
            {{ $slot }}
        </main>

    </div>
</body>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@stack('js')

</html>
