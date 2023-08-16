<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - Omni Hotelier</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

    <div class="wrapper">
        @include('layouts.components.navs.sidebar')

        <div class="main">
            @include('layouts.components.navs.header')

            <main class="content">
                @yield('content')
            </main>

            @include('layouts.components.footer')
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
