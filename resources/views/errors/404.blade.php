<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Genesis CRM+</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Inspinia -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body class="gray-bg">


<div class="middle-box text-center animated fadeInDown">
    <h1>404</h1>
    <h3 class="font-bold">Page Not Found</h3>

    <div class="error-desc">
        Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
        <form class="form-inline m-t" role="form">
            <a href="{{ url('/opportunities') }}" class="btn btn-warning"><span class="fa fa-chevron-circle-left"></span> Back to Dashboard</a>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- HRS -->
<script src="{{ asset('js/hrs.js') }}"></script>

</body>



</html>
