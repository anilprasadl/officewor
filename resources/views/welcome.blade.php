<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DevOps Release Calendar</title>
    <link rel="icon" href="{{asset('/img/devops.png')}}" style="" type="image/x-icon">

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'raleway';
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        
        .full-height {
            height: 100vh;
        }
        
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        
        .position-ref {
            position: relative;
        }
        
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        
        .content {
            text-align: center;
        }
        
        .title {
            font-size: 84px;
        }
        
        .links > a {
            padding: 0 25px;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
        }
        
        a:hover {
            /* background-color:#00a8ff !important; */
            padding-top: 10px;
            border-bottom-width: 10px;
            padding-bottom: 10px;
            text-decoration: underline;
            transition: .5s;
            opacity: .5;
        }
        
        .m-b-md {
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        body {
            /* background-color: #00AFF0; */
            background-color: #3498db;
            /* background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 200 200'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='100' y1='33' x2='100' y2='-3'%3E%3Cstop offset='0' stop-color='%23000' stop-opacity='0'/%3E%3Cstop offset='1' stop-color='%23000' stop-opacity='1'/%3E%3C/linearGradient%3E%3ClinearGradient id='b' gradientUnits='userSpaceOnUse' x1='100' y1='135' x2='100' y2='97'%3E%3Cstop offset='0' stop-color='%23000' stop-opacity='0'/%3E%3Cstop offset='1' stop-color='%23000' stop-opacity='1'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg fill='%230095cc' fill-opacity='0.6'%3E%3Crect x='100' width='100' height='100'/%3E%3Crect y='100' width='100' height='100'/%3E%3C/g%3E%3Cg fill-opacity='0.5'%3E%3Cpolygon fill='url(%23a)' points='100 30 0 0 200 0'/%3E%3Cpolygon fill='url(%23b)' points='100 100 0 130 0 100 200 100 200 130'/%3E%3C/g%3E%3C/svg%3E");                opacity:0.9; */
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/events') }}">Home</a> @else
            <a href="{{ route('login') }}">Login</a> @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a> @endif @endauth
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                DevOps Release Calendar
            </div>
            @if (Route::has('login')) @auth
            <div class="row"></div>
            <div class="links">
                <a href="myevents">My Calendar Events</a>
            </div>
            @endif @endauth
            <div class="links">
                <a href="events">Calendar</a>
            </div>

        </div>
    </div>
</body>

</html>