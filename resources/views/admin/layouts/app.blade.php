<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Notification Styles */
        .alert-position {
            position: fixed;
            top: 80px;
            right: 20px;
            min-width: 250px;
            max-width: 350px;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideIn 0.3s ease-out forwards;
            border-left: 4px solid;
        }

        .alert-position.alert-success {
            background-color: #e8f5e9;
            border-left-color: #4caf50;
            color: #2e7d32;
        }

        .alert-position.alert-danger {
            background-color: #ffebee;
            border-left-color: #f44336;
            color: #d32f2f;
        }

        .alert-position .close {
            padding: 0;
            background: transparent;
            border: none;
            font-size: 1.2rem;
            line-height: 1;
            opacity: 0.7;
            cursor: pointer;
            margin-left: 15px;
        }

        .alert-position .close:hover {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .alert-position.fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }

        :root {
            --primary: #393D72;
            --secondary:  rgba(254, 56, 115, 0.3);
            --accent:#1A1C2E ;
            --dark:   #ff2f6e;
            --light: #F8F9FA;
            --sidebar-width: 250px;
            --navbar-height: 60px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Navbar Styles */
        .navbar {
            height: var(--navbar-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 999;
            padding: 0 20px;
            transition: all 0.3s;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--dark);
        }
        
        .user-profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(400deg, var(--secondary), var(--dark));
            min-height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }
        
        .sidebar-header {
            height: var(--navbar-height);
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }
        
        .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(77, 101, 249, 0.4);
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 20px;
            min-height: calc(100vh - var(--navbar-height));
            transition: all 0.3s;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        .btn-show {
            background-color: #4a4e8a !important;
            border-color: #2a2d55 !important;
            color: #fff;
        }

        .btn-edit {
            background-color: #3442fb !important;
            border-color: #ffffff !important;
            color: #fff;
        }

        .btn-delet {
            background-color: rgba(254, 56, 115, 0.6);
            color: #fff;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        /* Mobile Menu Button */
        .sidebar-toggler {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--dark);
            cursor: pointer;
        }

        /* Backdrop for mobile sidebar */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        /* Responsive Styles */
        @media (max-width: 1199.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .navbar {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggler {
                display: block;
            }

            .sidebar-backdrop.active {
                display: block;
            }
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 15px;
            }

            .alert-position {
                max-width: calc(100% - 40px);
                right: 20px;
                left: 20px;
            }
        }

        @media (max-width: 575.98px) {
            :root {
                --navbar-height: 56px;
            }

            .sidebar-header h3 {
                font-size: 1.1rem;
            }

            .nav-link {
                padding: 10px 15px;
                margin: 3px 10px;
                font-size: 0.9rem;
            }

            .main-content {
                padding: 10px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Backdrop (Mobile) -->
    <div class="sidebar-backdrop"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Admin Panel</h3>
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.courses.index') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                    <i class="fas fa-list"></i> Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.course-sessions.index') ? 'active' : '' }}" href="{{ route('admin.course-sessions.index') }}">
                    <i class="fas fa-calendar"></i> Sessions
                </a>
            </li>        
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.private-sessions.index') ? 'active' : '' }}" href="{{ route('admin.private-sessions.index') }}">
                    <i class="fas fa-calendar-day"></i> Private Sessions
                </a>
            </li>
            
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.events.index') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                    <i class="fas fa-calendar-alt"></i> Events
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i>
                    Bookings
                </a>
            </li>
        
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">
                    <i class="fas fa-ticket-alt"></i> Coupons
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-credit-card"></i> Payments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.reviews.index') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.contact.index') }}" class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope me-2"></i>
                    Contact Messages
                </a>
            </li>
        </ul>
    </div>

   <!-- Navbar -->
<nav class="navbar navbar-expand navbar-light">
    <button class="sidebar-toggler mr-3">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-header d-lg-none">
        <h3>Admin Panel</h3>
    </div>        
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                <div class="user-profile">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <!-- Home Button -->
                <a class="dropdown-item" href="{{ route('home') }}">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
        
                <!-- Profile Link -->
                <a class="dropdown-item" href="{{ route('admin.user.profile') }}">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
        
                <div class="dropdown-divider"></div>
        
                <!-- Logout -->
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        
    </ul>
</nav>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
        <div class="alert alert-success alert-position fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" onclick="this.parentElement.classList.add('fade-out'); setTimeout(() => this.parentElement.remove(), 300)">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    
        @if(session('error'))
        <div class="alert alert-danger alert-position fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" onclick="this.parentElement.classList.add('fade-out'); setTimeout(() => this.parentElement.remove(), 300)">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        $(document).ready(function() {
            $('.sidebar-toggler').click(function() {
                $('.sidebar').toggleClass('active');
                $('.sidebar-backdrop').toggleClass('active');
            });

            // Close sidebar when clicking on backdrop
            $('.sidebar-backdrop').click(function() {
                $('.sidebar').removeClass('active');
                $('.sidebar-backdrop').removeClass('active');
            });

            // Auto-close alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Close alert when clicking close button
            $('.alert .close').click(function() {
                $(this).parent().remove();
            });
        });

        // Adjust main content height on resize
        $(window).resize(function() {
            adjustMainContentHeight();
        });

        function adjustMainContentHeight() {
            var navbarHeight = $('.navbar').outerHeight();
            $('.main-content').css('margin-top', navbarHeight + 'px');
        }
    </script>
    @stack('scripts')
</body>
</html>