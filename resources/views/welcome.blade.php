<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Genesis CRM+</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #16a085;
            color: #ffffff;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .nav {
            background: #1abc9c;
            border-radius: 2px;
            color: #ffffff !important;
            padding: 10px !important;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #f1c40f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        /*Particle Ground*/
        #particles {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #intro {
            position: absolute;
            left: 0;
            top: 50%;
            padding: 0 20px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="particles">
    <div id="intro">
        <div class="title">
            Genesis CRM+
        </div>
        <div class="m-b-md">
            <small>Project Genesis Customer Relationship Mananagement Solution</small>
        </div>
        <div class="links m-b-md">
            <a href="/">www.projectgenesis.com</a>
        </div>
        @if (Route::has('login'))
            <div class="links">
                @if (Auth::check())
                    <a class="nav" href="{{ url('/opportunities') }}">Back to Dashboard</a>
                @else
                    <a class="nav" href="{{ url('/login') }}">Login</a>
                    <a class="nav" href="{{ url('/register') }}">Register</a>
                @endif
            </div>
        @endif


    </div>
</div>

<!-- Particle Ground -->
<script src="{{ asset('js/jquery.particleground.js') }}"></script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		particleground(document.getElementById('particles'), {
			dotColor : '#1abc9c',
			lineColor: '#1abc9c'
		});
		var intro = document.getElementById('intro');
		intro.style.marginTop = -intro.offsetHeight / 2 + 'px';
	}, false);

</script>
</body>
</html>
