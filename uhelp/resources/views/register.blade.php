<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')
    <link href="{{ mix('/css/login.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>

<div id="app">
    <register :types="{{ $accountTypes }}"/>
</div>
</body>
</html>
