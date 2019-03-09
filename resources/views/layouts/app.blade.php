<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gene suggest</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
<div id="app">

    <div class="col-md-12">
        <hr/>
    </div>

    <div class="col-md-12">
        <div class="col-md-8 offset-md-2">
            <h2 class="text-left">Gene Suggest UI Application</h2>
            <a href="{{route('welcome')}}" class="text-right"> Back to home page</a>
        </div>
    </div>

    @yield('content')

    <div class="container">
        <div class="col-md-12">
            <hr/>
        </div>

        <div class="col-md-12" style="margin-bottom: 20px;">
            <div class="text-center">
                the testing task️ by <a href="https://github.com/jackxavier">Evgenii Petrov</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

</body>
</html>
