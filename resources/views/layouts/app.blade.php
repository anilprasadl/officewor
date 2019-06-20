<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DevOps Release Calendar') }}</title>
    <link rel="icon" href="{{asset('/img/devops.png')}}" style="" type="image/x-icon">
    <!-- Styles -->
    <!-- <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" /> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <!-- angular -->

    <!-- Date Time Picker -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.js"></script>
    <script src="https://cdn.rawgit.com/indrimuska/angular-moment-picker/master/dist/angular-moment-picker.min.js"></script>
    <link href="https://cdn.rawgit.com/indrimuska/angular-moment-picker/master/dist/angular-moment-picker.min.css" rel="stylesheet">

    <!-- Full calendar -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />

    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"> -->
    <style type="text/css">
        #timeline {
            list-style: none;
            position: relative;
        }
        
        #timeline:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 2px;
            background-color: #4997cd;
            left: 50%;
            margin-left: -1.5px;
        }
        
        #timeline .clearFix {
            clear: both;
            height: 0;
        }
        
        #timeline .timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            font-size: 1.2em;
            text-align: center;
            position: absolute;
            top: 20px;
            left: 50%;
            margin-left: -25px;
            background-color: #4997cd;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }
        
        #timeline .timeline-badge span.timeline-balloon-date-day {
            font-size: 0.4em;
        }
        
        #timeline .timeline-badge span.timeline-balloon-date-month {
            font-size: .7em;
            position: relative;
            top: -10px;
        }
        
        #timeline .timeline-badge.timeline-filter-movement {
            background-color: #ffffff;
            font-size: 1.7em;
            height: 35px;
            margin-left: -18px;
            width: 35px;
            top: 40px;
        }
        
        #timeline .timeline-badge.timeline-filter-movement a span {
            color: #4997cd;
            font-size: 1.3em;
            top: -1px;
        }
        
        #timeline .timeline-badge.timeline-future-movement {
            background-color: #ffffff;
            height: 35px;
            width: 35px;
            font-size: 1.7em;
            top: -16px;
            margin-left: -18px;
        }
        
        #timeline .timeline-badge.timeline-future-movement a span {
            color: #4997cd;
            font-size: .9em;
            top: 2px;
            left: 1px;
        }
        
        #timeline .timeline-movement {
            border-bottom: dashed 1px #4997cd;
            position: relative;
        }
        
        #timeline .timeline-movement.timeline-movement-top {
            height: 60px;
        }
        
        #timeline .timeline-movement .timeline-item {
            padding: 20px 0;
        }
        
        #timeline .timeline-movement .timeline-item .timeline-panel {
            border: 1px solid #d4d4d4;
            border-radius: 3px;
            background-color: #FFFFFF;
            color: #666;
            padding: 10px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }
        
        #timeline .timeline-movement .timeline-item .timeline-panel .timeline-panel-ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        #timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul {
            text-align: right;
        }
        
        #timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul li {
            color: #666;
        }
        
        #timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul li span.importo {
            color: #468c1f;
            font-size: 1.3em;
        }
        
        #timeline .timeline-movement .timeline-item .timeline-panel.debits .timeline-panel-ul {
            text-align: left;
        }
        
        #timeline .timeline-movement .timeline-item .timeline-panel.debits .timeline-panel-ul span.importo {
            color: #e2001a;
            font-size: 1.3em;
        }
        
        .dropdown-menu>.active>a,
        .dropdown-menu>.active>a:focus,
        .dropdown-menu>.active>a:hover {
            background: white !important;
            color: #333 !important;
        }
        
        [ng\:cloak],
        [ng-cloak],
        [data-ng-cloak],
        [x-ng-cloak],
        .ng-cloak,
        .x-ng-cloak {
            display: none !important;
        }
        
        .bg_load {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background: #000;
            opacity: 0.8;
            z-index: 9999;
        }
        
        .close {
            color: #636e72 !important;
            opacity: 1 !important;
        }
        
        .close:hover {
            color: #fff !important;
            opacity: 1 !important;
        }
        
        .modal-header {
            background-color: #2e86de;
            color: #ecf0f1;
            font-family: raleway;
            font-weight: bold;
            font-size: 15px;
        }
        
        body {
            font: 15px raleway !important;
            font-weight: 10px;
        }
        
        #assigned_user {
            text-transform: lowercase !important;
        }
        
        #assigned_user::first-letter {
            text-transform: uppercase !important;
        }
        
        #status {
            text-transform: lowercase !important;
        }
        
        #status::first-letter {
            font-size: 50px;
        }
        
        .navbar-nav>li>a:hover {
            color: #ecf0f1;
            background-color: #54a0ff;
            font-family: raleway;
            font-weight: bold;
            transition: .5s;
            /* opacity:0.5 !important; */
        }
        
        .navbar-nav>li>a {
            color: #ecf0f1;
            font-weight: bold;
            transition: .5s;
        }
        
        .dropdown-menu {
            font-family: raleway;
            font-weight: bold;
            background-color: #2e86de !important;
            color: #ecf0f1 !important;
            transition: .5s;
        }
        
        .dropdown-toggle:hover {
            background-color: #54a0ff!important;
            color: #ecf0f1 !important;
        }
        
        .dropdown-menu>li>a {
            background-color: #2e86de !important;
            color: #ecf0f1 !important;
            transition: .5s;
        }
        
        .dropdown-menu>li>a:hover {
            background-color: #54a0ff!important;
            color: #ecf0f1 !important;
        }
        
        .btn-primary:hover {
            background-color: #54a0ff;
            border: 1px solid #54a0ff;
            transition: .5s;
        }
        
        .btn-primary {
            background-color: #2e86de;
            border: 1px solid #2e86de;
            transition: .5s;
        }
        
        .panel-heading {
            background-color: #2e86de !important;
            color: #ecf0f1 !important;
            font-family: raleway;
            font-weight: bold;
            font-size: 19px;
        }
        
        .nav .open>a,
        .nav .open>a:focus,
        .nav .open>a:hover {
            background-color: #54a0ff!important;
            font-family: 15 px raleway;
            font-weight: bold;
            transition: .5s;
        }
        
        .navbar-toggle {
            background-color: #54a0ff!important;
            color: #ecf0f1 !important;
            font-family: raleway;
            font-weight: bold;
        }
        
        .dropdown-toggle {
            background-color: #2e86de !important;
            color: #ecf0f1 !important;
            font-family: raleway;
            font-weight: bold;
        }
        
        .navbar-brand {
            background-color: #2e86de !important;
            color: #ecf0f1 !important;
            font-family: raleway !important;
            font-weight: bold;
            transition: .5s;
        }
        
        .navbar-brand:hover {
            background-color: #54a0ff!important;
        }
        
        .bg-primary {
            color: #fff;
            background-color: #2e86de !important;
        }
        
        .brand,
        .heading {
            display: inline-block;
            margin: 10px 10px 0 0;
            padding: 5px 10px
        }
        
        .card-header {
            font: bold !important;
        }
        
        @import "compass/css3";
        #timeline {
            text-align: center;
        }
        
        .timeline {
            list-style: none;
            padding: 20px 0 20px;
            position: relative;
        }
        
        .timeline:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 3px;
            background-color: #cccccc;
            left: 50%;
            margin-left: -1.5px;
        }
        
        .timeline > li {
            margin-bottom: 20px;
            position: relative;
        }
        
        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }
        
        .timeline > li:after {
            clear: both;
        }
        
        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }
        
        .timeline > li:after {
            clear: both;
        }
        
        .timeline > li > .timeline-panel {
            width: 50%;
            float: left;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            background-color: #ffffff;
            padding: 20px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }
        
        .timeline > li.timeline-inverted + li:not(.timeline-inverted),
        .timeline > li:not(.timeline-inverted) + li.timeline-inverted {
            margin-top: -60px;
        }
        
        .timeline > li:not(.timeline-inverted) {
            padding-right: 90px;
        }
        
        .timeline > li.timeline-inverted {
            padding-left: 90px;
        }
        
        .timeline > li > .timeline-panel:before {
            position: absolute;
            top: 26px;
            right: -15px;
            display: inline-block;
            border-top: 15px solid transparent;
            border-left: 15px solid #ccc;
            border-right: 0 solid #ccc;
            border-bottom: 15px solid transparent;
            content: " ";
        }
        
        .timeline > li > .timeline-panel:after {
            position: absolute;
            top: 27px;
            right: -14px;
            display: inline-block;
            border-top: 14px solid transparent;
            border-left: 14px solid #fff;
            border-right: 0 solid #fff;
            border-bottom: 14px solid transparent;
            content: " ";
        }
        
        .timeline > li > .timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 1.4em;
            text-align: center;
            position: absolute;
            top: 16px;
            left: 50%;
            margin-left: -25px;
            background-color: #999999;
            z-index: 2;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }
        
        .timeline > li.timeline-inverted > .timeline-panel {
            float: right;
        }
        
        .timeline > li.timeline-inverted > .timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }
        
        .timeline > li.timeline-inverted > .timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
        
        .timeline-badge.primary {
            background-color: #2e6da4 !important;
        }
        
        .timeline-badge.extra {
            background-color: #454545 !important;
        }
        
        .timeline-badge.work {
            background-color: #E76B0E !important;
        }
        
        .timeline-badge.study {
            background-color: #EB2690 !important;
        }
        
        .timeline-badge.life {
            background-color: #5bc0de !important;
        }
        
        .timeline-title {
            margin-top: 0;
            color: inherit;
        }
        
        .timeline-body > p,
        .timeline-body > ul {
            margin-bottom: 0;
        }
        
        .timeline-body > p + p {
            margin-top: 5px;
        }
        /* Sorry, header */
        
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        
        body {
            background: #ebe7e4;
            color: #6d6b6a;
            font-size: 13px;
            font-family: helvetica, arial, sans-serif;
            overflow-y: scroll;
        }
        
        body > header {
            width: 100%;
            position: fixed;
            z-index: 30;
            background: #E0DCD9;
            border-bottom: 1px solid #d5d1cf;
            box-shadow: 0 1px 1px white;
            top: 0;
            left: 0;
        }
        
        body > header nav {
            width: 960px;
            margin: 0 auto;
            overflow: hidden;
        }
        
        body > header nav ul {
            margin: 0 0 0 -65px;
            padding: 0;
            text-align: center;
            font-size: 0em;
            letter-spacing: 0px;
            word-spacing: 0px;
        }
        
        body > header nav li {
            display: inline-block;
            cursor: pointer;
            border-left: 1px solid #ebe7e4;
            border-top: 1px solid #E0DCD9;
            box-shadow: -1px 0px 1px #d5d1cf;
            padding: 1.2em;
            font-size: 18px;
        }
        
        body > header nav li:hover {
            background: #d5d1cf;
        }
        
        body > header nav li:first-child {
            border-left: 1px solid #E0DCD9;
            box-shadow: -1px 0px 1px #E0DCD9;
            text-shadow: 1px 1px 1px #fff;
        }
        
        body > header nav li:active,
        body > header nav li.active {
            color: white;
        }
        
        body > header nav li.all:active,
        body > header nav li.all.active {
            text-shadow: 1px 1px 1px #444;
        }
        
        body > header nav li.icon-address:active,
        body > header nav li.icon-address.active {
            background: #5bc0de;
            border-left: 1px solid #0cb4c6;
            border-top: 1px solid #0cb4c6;
            box-shadow: none;
        }
        
        body > header nav li.icon-graduation-cap:active,
        body > header nav li.icon-graduation-cap.active {
            background: #EB2690;
            border-left: 1px solid #bf1f75;
            border-top: 1px solid #bf1f75;
            box-shadow: none;
        }
        
        body > header nav li.icon-briefcase:active,
        body > header nav li.icon-briefcase.active {
            background: #E76B0E;
            border-left: 1px solid #B85307;
            border-top: 1px solid #B85307;
            box-shadow: none;
        }
        
        body > header nav li.icon-star-1:active,
        body > header nav li.icon-star-1.active {
            background: #5E6297;
            border-left: 1px solid #333;
            border-top: 1px solid #333;
            box-shadow: none;
        }
        
        body > header nav li.icon-user:active,
        body > header nav li.icon-user.active {
            background: #454545;
            border-left: 1px solid #333;
            border-top: 1px solid #333;
            box-shadow: none;
        }
        
        body > header nav ul#nav_ctrl {
            position: absolute;
            top: 0;
            right: 0;
        }
        
        div#timeline_container {
            margin: 60px auto;
            position: relative;
            width: 960px;
        }
    </style>
    @yield('pageStyle')

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-sm bg-primary ">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="fas fa-bars"></span>

                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('login') }}" style="padding:0px;">

                        <span class="brand">{{ config('app.name', 'DevOps Release Calendar') }}</span>
                    </a>

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        @if (Route::has('register'))
                        <!-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li> -->
                        <!-- <li class="nav-item">
                                    <a class="nav-link" href="myevents">My Calendar Events</a>
                                </li> -->

                        @endif @else @if(Auth::user()->is_admin) @if(Auth::user()->is_super_user)
                        <li class="nav-item">
                            <a class="nav-link" href="users"> Users </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="slots"> My Tasks </a>
                        </li>

                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="task-track"> Timeline </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="events"> Calendar </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="myevents">Schedule Task</a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                <i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="/changePassword">Change Password</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                            </ul>
                        </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.1/angular-sanitize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <!-- Full calendar Script -->
    <script src="{{asset('js/fullcalendar/moment.js')}}"></script>
    <!-- <script src="{{asset('js/fullcalendar/jquery.js')}}"></script> -->
    <script src="{{asset('js/fullcalendar/jquery-ui.custom.js')}}"></script>
    <script src="{{asset('js/fullcalendar/fullcalendar.js')}}"></script>

    @yield('pageScript') @stack('scripts')

</body>

</html>