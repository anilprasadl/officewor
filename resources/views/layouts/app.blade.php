<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DevOps Release Calendar') }}</title>
    <link rel="icon" href="{{asset('/img/devops.png')}}" style=""type="image/x-icon">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />

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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"> -->
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
            
            .bg_load {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                background: #000;
                opacity:0.8;
                z-index:9999;
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
                    color:#ecf0f1;
                    font-family:raleway;
                    font-weight: bold;
                    font-size:15px;

            }
            body {
                font:15px raleway !important;
                font-weight: 10px;

            }
            
            .navbar-nav>li>a:hover{
                color:#ecf0f1;
                background-color:#54a0ff;
                font-family:raleway;
                font-weight: bold;
                transition: .5s;


                /* opacity:0.5 !important; */
            }
           
            .navbar-nav>li>a{
                color:#ecf0f1;
                font-weight: bold; 
                transition: .5s;                
            }
            .dropdown-menu{
                font-family:raleway;
                font-weight: bold;
                background-color: #2e86de !important;
                color:#ecf0f1 !important;
                transition: .5s;                
            }
            .dropdown-toggle:hover{
                background-color: #54a0ff!important;
                color:#ecf0f1 !important;
            }
            .dropdown-menu>li>a{
                background-color: #2e86de !important;
                color:#ecf0f1 !important;
                transition: .5s;
            }
            .dropdown-menu>li>a:hover{
                background-color: #54a0ff!important;
                color:#ecf0f1 !important;
            }
            .btn-primary:hover{
                background-color:#54a0ff;
                border:1px solid #54a0ff;
                transition: .5s;

            }
            .btn-primary{
                background-color:#2e86de;
                border:1px solid #2e86de;
                transition: .5s;
            }
            .panel-heading{
                background-color: #2e86de !important;
                color:#ecf0f1 !important;
                font-family:raleway;
                font-weight: bold;
                font-size:19px;


            }
            .nav .open>a, .nav .open>a:focus, .nav .open>a:hover{
                background-color: #54a0ff!important;
                font-family:15 px raleway;
                font-weight: bold;
                transition: .5s;


            }
            .navbar-toggle {
                background-color: #54a0ff!important;
                color:#ecf0f1 !important;
                font-family:raleway;
                font-weight: bold;

            }
            .dropdown-toggle{
                background-color:  #2e86de !important;
                color:#ecf0f1 !important;
                font-family:raleway;
                font-weight: bold;

            }
            .navbar-brand{
                background-color: #2e86de !important;
                color:#ecf0f1 !important;
                font-family:raleway !important;
                font-weight: bold;
                transition: .5s;


            }
            
            .navbar-brand:hover{
                background-color: #54a0ff!important;


            }
            .bg-primary {
                color: #fff;
                background-color: #2e86de !important;
            }
            .brand, .heading{
        
                display: inline-block;
                margin: 10px 10px 0 0;
                padding: 5px 10px
            }
            .card-header{
                font:bold !important;
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
                        <span class="fas fa-bars"></span>
                      
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('login') }}" style="padding:0px;" >
                    

                       <span class="brand" >{{ config('app.name', 'DevOps Release Calendar') }}</span>
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
                                
                            @endif
                        @else
                        @if(Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="users"> Users </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="slots"> Booked Slots </a>
                        </li>
                                
                        @endif
                        <li class="nav-item">
                                    <a class="nav-link" href="events"> Calendar </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="myevents">My Calendar Events</a>
                                </li>
                       
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

    @yield('pageScript')

    @stack('scripts')


</body>
</html>
