<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <style>
        .bg-slate {
            background-color: #708090; /* Slate color */
        }
    </style>
    <title>@yield('title')</title>
</head>
<body>
    <header class="bg-slate text-white">
        <div class="d-flex justify-content-between align-items-center p-3">
            <h3>Country Selector</h3>
            <ul class="list-unstyled d-flex gap-3 mb-0">
                @if (Auth::check())
                    <li><a href="{{route('logout')}}" class="text-decoration-none text-white">Logout</a></li>
                @else
                    <li><a href="{{route('register.page')}}" class="text-decoration-none text-white">Register</a></li>
                    <li><a href="{{route('login.page')}}" class="text-decoration-none text-white">Login</a></li>
                @endif
            </ul>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('country.create')}}">
                                Country
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('state.create')}}">
                                State
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('city.create')}}">
                                City
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
    @yield('custom-js')
</body>
</html>
