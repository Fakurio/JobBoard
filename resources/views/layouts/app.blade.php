<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>ITJobsBoard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap"
            rel="stylesheet"
        />

        <link href="{{ asset('css/home.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/addPostForm.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/editPostPage.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/myApplications.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/myOfferts.css') }}" rel="stylesheet" />
        <!-- Scripts -->

        @vite(['resources/css/app.css','resources/js/app.js']) @stack("scripts")
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <header class="main-header">@yield('header')</header>
            <main>@yield('content')</main>
        </div>
    </body>
</html>
