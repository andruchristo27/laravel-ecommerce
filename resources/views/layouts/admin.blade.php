<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-flex flex-column flex-shrink-0 p-3 bg-light ">
                <div class="sidebar-sticky">
                    <a href="/dashboard" class="d-flex align-items-center mb-3 mb-md-2 me-md-auto text-black text-decoration-none">
                    <img src="{{ asset('assets/logo.svg') }}" alt="Dashboard" style="width: 25px; height: 25px; margin-right: 10px;">
                    <span class="fs-4">Admin Panel</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center text-black {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.dashboard') }}">
                            <img src="{{ asset('assets/dashboard.svg') }}" alt="Dashboard" style="width: 20px; height: 20px; margin-right: 5px;">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center text-black {{ request()->routeIs('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <img src="{{ asset('assets/category.svg') }}" alt="Dashboard" style="width: 20px; height: 20px; margin-right: 5px;">
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center text-black {{ request()->routeIs('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <img src="{{ asset('assets/product.svg') }}" alt="Dashboard" style="width: 20px; height: 20px; margin-right: 5px;">
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center text-black {{ request()->routeIs('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <img src="{{ asset('assets/user.svg') }}" alt="Dashboard" style="width: 20px; height: 20px; margin-right: 5px;">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center text-black {{ request()->routeIs('order*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                            <img src="{{ asset('assets/order.svg') }}" alt="Dashboard" style="width: 20px; height: 20px; margin-right: 5px;">
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center text-black {{ request()->routeIs('logout*') ? 'active' : '' }}" href="#" onclick="event.preventDefault(); if(confirm('Apakah anda yakin ingin logout?')) { document.getElementById('logout-form').submit(); }">
                            <img src="{{ asset('assets/logout.svg') }}" alt="Dashboard" style="width: 20px; height: 20px; margin-right: 5px;">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
