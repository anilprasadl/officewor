<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DevOps Tool') }}</title>
    <link rel="icon" href="{{asset('/img/devops.png')}}" style=""type="image/x-icon">
    <!-- Styles -->

    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- Full calendar -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
   <!-- angular -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
    
    
    
    
    <!-- Date Time Picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.js"></script>
    <script src="https://cdn.rawgit.com/indrimuska/angular-moment-picker/master/dist/angular-moment-picker.min.js"></script>
    <link href="https://cdn.rawgit.com/indrimuska/angular-moment-picker/master/dist/angular-moment-picker.min.css" rel="stylesheet">
    

    <style type="text/css">
        .dropdown-menu>.active>a,
        .dropdown-menu>.active>a:focus,
        .dropdown-menu>.active>a:hover {
            background: white !important;
            color: #333 !important;
        }
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                display: none !important;
            }
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            .bg_load {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                background: #000;
                opacity:0.6;
                z-index:9999;
            }
            .close {
                color: #fff !important; 
                opacity: 1 !important;                
            }
            .dataTables_wrapper .dataTables_processing {
                    position: absolute;
                    top: 30%;
                    left: 50%;
                    width: 30%;
                    height: 40px;
                    margin-left: -20%;
                    margin-top: -25px;
                    padding-top: 20px;
                    text-align: center;
                    font-size: 1.2em;
                    background:none;
              }
              .modal-header {
                    padding:9px 15px;
                    border-bottom:1px solid #eee;
                    background-color: #084e63;
                    color:#ecf0f1;
                    -webkit-border-top-left-radius: 5px;
                    -webkit-border-top-right-radius: 5px;
                    -moz-border-radius-topleft: 5px;
                    -moz-border-radius-topright: 5px;
                    border-top-left-radius: 5px;
                    border-top-right-radius: 5px;
                    font-family:raleway;
                    font-weight: bold;
                    font-size:15px;

            }
            body {
                font:15px raleway;
                font-weight: 10px;
            }
            
            .navbar-nav>li>a:hover{
                color:#ecf0f1;
                background-color:#3498db;
                font-family:raleway;
                font-weight: bold;
                transition: .5s;


                /* opacity:0.5 !important; */
            }
            .navbar-brand {
            ￼    float: left;
            ￼    height: 50px !important;
            ￼    padding: 15px 15px !important;
            ￼    font-size: 18px !important;
            ￼    line-height: 52px !important;
            }
            .navbar-nav>li>a{
                color:#ecf0f1;
                font-weight: bold; 
                transition: .5s;                
            }
            .dropdown-menu{
                font-family:raleway;
                font-weight: bold;
                background-color: #084e63 !important;
                color:#ecf0f1 !important;
                transition: .5s;                
            }
            .dropdown-toggle:hover{
                background-color: #3498db !important;
                color:#ecf0f1 !important;
            }
            .dropdown-menu>li>a{
                background-color: #084e63 !important;
                color:#ecf0f1 !important;
                transition: .5s;
            }
            .dropdown-menu>li>a:hover{
                background-color: #3498db !important;
                color:#ecf0f1 !important;
            }
            .btn-primary:hover{
                background-color:#3498db;
                border:1px solid #3498db;
                transition: .5s;

            }
            .panel-heading{
                background-color: #084e63 !important;
                color:#ecf0f1 !important;
                font-family:raleway;
                font-weight: bold;
                font-size:19px;


            }
            .nav .open>a, .nav .open>a:focus, .nav .open>a:hover{
                background-color: #337ab7 !important;
                font-family:15 px raleway;
                font-weight: bold;
                transition: .5s;


            }
            .navbar-toggle {
                background-color: #337ab7 !important;
                color:#ecf0f1 !important;
                font-family:raleway;
                font-weight: bold;

            }
            .dropdown-toggle{
                background-color:  #084e63 !important;
                color:#ecf0f1 !important;
                font-family:raleway;
                font-weight: bold;

            }
            .navbar-brand{
                background-color: #084e63 !important;
                color:#ecf0f1 !important;
                font-family:raleway !important;
                font-weight: bold;
                transition: .5s;


            }
            
            .navbar-brand:hover{
                background-color: #3498db !important;


            }
            .bg-primary {
                color: #fff;
                background-color: #084e63 !important;
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
                    <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#app-navbar-collapse"
                     aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('login') }}" style="padding:0px;" >
                       <span >{{ config('app.name', 'DevOps Tool') }}</span>
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
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle"
                                data-toggle="dropdown" role="button"
                                aria-expanded="false" aria-haspopup="true" v-pre>
                                  <i class="fa fa-user"></i>  {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
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

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.1/angular-sanitize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <!-- Full calendar Script -->
    <script src="{{asset('js/fullcalendar/moment.js')}}"></script>
    <script src="{{asset('js/fullcalendar/jquery.js')}}"></script>
    <script src="{{asset('js/fullcalendar/jquery-ui.custom.js')}}"></script>
    <script src="{{asset('js/fullcalendar/fullcalendar.js')}}"></script>

    @yield('pageScript')

    @stack('scripts')


</body>
</html>
