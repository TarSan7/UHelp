<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
{{-- Main content --}}
{{--@yield('content')--}}

{{--@include('Core::layouts.footer.footer')--}}
<div id="app">
    <landing />
</div>
</body>
</html>
