<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jungle.css') }}" rel="stylesheet">

</head>
<body>
    <div class="col-sm-12" id="app">
        @include('inc.navbar')
        <div class="container">
            @include('inc.messages')
            @yield('content')
        </div>
    </div>
</body>




<script src="https://unpkg.com/vue@2.0.3/dist/vue.js"></script>

<script>

    var app = new Vue({
        el: '#app',
        data: {
            message: 'WOWOOWOWOW',
            intro: 'Welcome <h1>introduction</h1>',
            showz: false,
            zhow: false,
            panel: 'POSITION',

            logical: true,
            tooltip: 'boo ya!',
            todos: [
                {text:'learn vue', id: 1},
                {text:'write processes', id: 2},
                {text:'meditate', id: 3}
            ]
        }
    })
</script>
<!-- Scripts - at least for menus: what else ?-->
<script src="{{ asset('js/app.js') }}"></script>


</html>
