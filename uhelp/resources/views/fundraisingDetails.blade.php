<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')
    <link href="{{ mix('/css/layout.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ mix('/css/landing.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>

<div id="app">
    <fundraising-details
        :user="{{ $user }}"
        :fundraising="{{ $fundraising }}"
        :images="{{ $images }}"
        :volunteer="{{ $volunteer }}"
    />
</div>
</body>
</html>
