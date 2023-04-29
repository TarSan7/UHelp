<!DOCTYPE html>
<html lang="en">
<head>
{{--    @section('header')--}}
{{--        @include('/header/head.blade.php')--}}
{{--    @show--}}
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
{{-- Main content --}}
{{--@yield('content')--}}

{{--@include('Core::layouts.footer.footer')--}}
<div id="app">
    <example-component></example-component>
</div>
</body>
</html>
