<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')
    <link href="{{ mix('/css/layout.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>

<div id="app">
    <create-edit-fundraising :user="{{ $user }}" :id="{{ $id }}"/>
</div>
</body>
</html>
