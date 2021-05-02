<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') | {{ env('app_name') }}</title>
    <meta name="description" content="">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/main/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/main/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/main/css/style.css') }}">

    @stack('css')
</head>
<body >
<!--Full width header Start-->
<div class="full-width-header header-style">
    <!--Header Start-->
    <header id="header" class="header">
        <!-- Menu Start -->
        <div class="menu-area">
            <div class="container">
                <div class="row middle">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="{{ route('home') }}" class="row pt-4">
                                <img src="{{ asset('assets/main/images/logo.png') }}" alt="logo">
                                <h2 class="ml-1">ExamPal</h2>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="menu-area justify-content-center">
                            <div class="main-menu">
                                <nav class="menu">
                                    <ul class="nav-menu">
                                        <li class="@if(Route::is('home')) current-menu-item @endif">
                                            <a href="{{ route('home') }}" style="font-size:18px;font-weight: 700">Home <i class="fa fa-home ml-1"></i> </a>
                                        </li>

                                        @if(auth()->check())
                                            <li class="@if(Route::is('exams*')) current-menu-item @endif">
                                                <a href="{{ route('exams.index') }}" style="font-size:18px;font-weight: 700">Exams <i class="fa fa-pencil ml-1"></i></a>
                                            </li>

                                            @if(auth()->user()->isTeacher())
                                                <li class="@if(Route::is('students*')) current-menu-item @endif">
                                                    <a href="{{ route('students.index') }}" style="font-size:18px;font-weight: 700">Students <i class="fa fa-users ml-1"></i></a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-size:18px;font-weight: 700">Logout <i class="fa fa-user-times ml-1"></i></a>
                                                <form action="{{ route('logout') }}" method="post" id="logout-form">
                                                    @csrf
                                                </form>
                                            </li>
                                        @else
                                            <li class="@if(Route::is('login')) current-menu-item @endif">
                                                <a href="{{ route('login')  }}" style="font-size:18px;font-weight: 700">Login<i class="fa fa-user ml-2"></i> </a>
                                            </li>

                                            <li class="@if(Route::is('register')) current-menu-item @endif">
                                                <a href="{{ route('register') }}" style="font-size:18px;font-weight: 700">Register<i class="fa fa-user-plus ml-2"></i> </a>
                                            </li>
                                        @endif
                                    </ul> <!-- //.nav-menu -->
                                </nav>
                            </div> <!-- //.main-menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu End -->

    </header>
    <!--Header End-->
</div>
<!--Full width header End-->

<!-- Main content Start -->
<div class="main-content">
    @include('layouts.message')
    @yield('content')
</div>
<!-- Main content End -->

<!-- Footer Start -->
<footer class="fixed-bottom" style="background: #0c8b51 !important;">
    <div class="container">
        <div class="text-white text-center">
            Made  with  <span class="text-danger">❤</span>  in  RU Hacks
        </div>
    </div>

</footer>
<!-- Footer End -->


<!-- jQuery -->
<script src="{{ asset('assets/main/js/jquery.min.js') }}"></script>
<!-- Bootstrap  -->
<script src="{{ asset('assets/main/js/bootstrap.min.js') }}"></script>

@stack('js')
</body>
</html>