<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Grow Wise</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Montserrat:wght@200;400;600&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cheakout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    {{-- <div class="container-fluid border-bottom bg-light wow fadeIn" data-wow-delay="0.1s" style="width: 100%;"> --}}
        {{-- <div class="container-fluid border-bottom bg-light" style="width: 100%;">
        <div class="container topbar bg-primary d-none d-lg-block py-2" style="border-radius: 0 20px">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm px-3 rounded">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3 rounded">Register</a>
                    @endguest
                </div>

                @auth
                <div class="dropdown pe-2">
                    <a class="btn btn-primary btn-sm dropdown-toggle d-flex align-items-center px-3 rounded" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="User Image" class="rounded-circle me-2" width="30" height="30">
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm rounded-3" aria-labelledby="userDropdown" style="min-width: 180px;">
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('user.profile') }}">
                                <i class="fas fa-user text-primary me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div> --}}

        <div class="container px-0">
            <nav class="navbar navbar-light navbar-expand-xl py-3">
                <a href="{{ route('home') }}" class="navbar-brand">
                    <h1 class="text-primary display-6">Grow<span class="text-secondary">Wise</span></h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <!-- روابط التنقل -->
                        <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                        <a href="{{ route('service') }}" class="nav-item nav-link {{ request()->routeIs('service') ? 'active' : '' }}">Services</a>
                        <a href="{{ route('courses.index') }}" class="nav-item nav-link {{ request()->routeIs('courses.index') ? 'active' : '' }}">Courses</a>
                        <a href="{{ route('private-sessions.index') }}" class="nav-item nav-link {{ request()->routeIs('private-sessions.*') ? 'active' : '' }}">Private Sessions</a>
                        <a href="{{ route('events.index') }}" class="nav-item nav-link {{ request()->routeIs('events.index') ? 'active' : '' }}">Events</a>
                        <a href="{{ route('team') }}" class="nav-item nav-link {{ request()->routeIs('team') ? 'active' : '' }}">Our Team</a>
                        <a href="{{ route('contact.index') }}" class="nav-item nav-link {{ request()->routeIs('contact.index') ? 'active' : '' }}">Contact Us</a>
                    </div>
                
                    @guest
                        <div class="d-flex align-items-center gap-2 ms-auto">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3 rounded">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3 rounded">Register</a>
                        </div>
                    @endguest
                
                    @auth
                    <div class="dropdown ms-auto">
                        <a class="btn btn-outline-primary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 rounded-pill" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('storage/profile_images/' . Auth::user()->image) }}" alt="User Image" class="rounded-circle" width="26" height="26">
                            <span class="fw-semibold small">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm rounded-3" aria-labelledby="userDropdown" style="min-width: 180px;">
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-primary small" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-primary small" href="{{ route('chat.index') }}">
                                    <i class="fas fa-comments me-2"></i> Messages
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger small">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                        
                    </div>
                    @endauth
                    
                </div>
                
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

