<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('title')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <!-- Styles -->
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    @yield('styles')


</head>
<body class="has-navbar-fixed-top">
    <div id="app">
        <header style="z-index: 100000;">
            <div class="navbar shadow-sm fixed-top navbar-expand-lg alert-light">
                <div class="container-fluid px-3" >
                  <a class="navbar-brand" href="/"><img src="/img/airshop__logo.png" class="img-fluid" style="height: 40px;" /></a>
    
                    <div class="dropdown" >
                        <button class="btn btn-none dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="iconify" data-icon="emojione-v1:flag-for-united-kingdom"></span> <span class="windows">
                                    GBP
                                </span> 
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li >
                                <form action="/updateCountry" method="post">
                                    <input type="text" name="country" value="US" hidden>
                                    <button class="dropdown-item " type="submit">
                                        <span class="iconify" data-icon="twemoji:flag-for-flag-united-states"></span> <span class="windows">US</span> 
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="/updateCountry" method="post">
                                    @csrf
                                    <input type="text" name="country" value="GB" hidden>
                                    <button class="dropdown-item" type="submit"><span class="iconify" data-icon="emojione-v1:flag-for-united-kingdom"></span> <span class="windows">GBP</span> </button>
                                </form>
                            </li>
                            <li>
                                <form action="/updateCountry" method="post">
                                    @csrf
                                    <input type="text" name="country" value="NGN" hidden>
                                    <button class="dropdown-item" type="submit">
                                        <span class="iconify" data-icon="twemoji:flag-for-flag-nigeria"></span> <span class="windows">NGN</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                  <button class="navbar-toggler text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                      <li class="nav-item">
                        <a class="nav-link" id="air" aria-current="page" href="/">Air</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="whatsnew" href="/whatsnew">Whats New</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="pricing" href="/pricing"> Pricing</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="support" href="/support"> Support</a>
                      </li>

                      @if (auth()->user()) 
                      <li class="nav-item">
                        <a class="btn btn-info text-white fw-normal nav-link" href="/"> Dashboard</a>
                      </li>
                      @else
                      <li class="nav-item">
                        <a class="btn btn-info text-white fw-normal nav-link" href="/account/join"> Get Started</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/account/login"> Login</a>
                      </li>
                      @endif
                      
                    </ul>
                  </div>
                </div>
            </div>
        </header>
        <main class="py-4">
            @yield('content')
        </main>

        <footer class="bg-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="h6">Links</h6>
                        <ul>
                            <li>
                                @if (auth()->user()) 
                                <a href="/dashboard">My Account</a>
                                @else
                                <a href="/account/login">My Account</a>
                                @endif
                            </li>
                            <li>
                                @if (auth()->user()) 
                                <a href="/dashboard/shop-details">My Store</a>
                                @else
                                <a href="/account/login">My Store</a>
                                @endif
                            </li>
                            <li>
                                <a href="/account/login">Get Started</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="h6">Useful</h6>
                        <ul>
                            <li>
                                <a href="/">Air</a>
                            </li>
                            <li>
                                <a href="/whats-new">Whats New</a>
                            </li>
                            <li>
                                <a href="/pricing">Pricing</a>
                            </li>
                            <li>
                                <a href="/support">Support</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="h6">Contacts</h6>
                        <ul>
                            <li>
                                <a href=""> 
                                    <span class="iconify" data-icon="whh:circlefacebook" data-inline="false" style="color: #3b5998;"></span>
                                     </span> <span>Air Shop 247</span></a>
                            </li>
                            
                            <li>
                                <a href="">
                                    <span class="iconify" data-icon="entypo-social:instagram-with-circle" data-inline="false" style="color: rgb(64, 93, 230);"></span>
                                    <span>Air Shop 247</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ mix('js/app.js') }}" ></script>

</body>
</html>
