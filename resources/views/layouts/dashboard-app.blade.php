<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
    .div-row {
        padding: 0;
        margin: 0;
    }

    .no-padding {
        padding: 0;
    }

    .no-margin {
        margin: 0;
    }

    .div-sidebar {
        height: 100vh;
        top: 0;
        padding: 0;
        background-color: #006064;
    }

    .chart {
        width: 20rem !important;
        height: 20rem !important;
    }

    .sidebar-header {
        height: 150px;
    }
    </style>
</head>
<body>
    <div id="app">
        <div class="div-row row">
            <div id="sidebar-container" class="collapse navbar-collapse navbar-ex1-collapse sidebar-expanded div-sidebar col-2 d-none d-md-block text-dark">
                <nav class="navbar navbar-dark flex-column sidebar-header">
                    <div class="py-4" align="center">
                        <img src="{{ asset('images/user3.png') }}" height="50" width="50">
                        <h4 class="text-light py-4">{{ Auth::user()->name }}</h4>
                    </div>
                </nav>

                <nav class="nav flex-column py-4">
                    <div>
                        <a class="nav-link text-white" href="{{ url('/home') }}">Dashboard</a>
                    </div>
                    <div class="nav-link text-light">User Management</div>
                    <div class="px-4">
                        <nav class="nav flex-column">
                            <a class="nav-link text-light" href="{{ url('/role') }}">Roles</a>
                            <a class="nav-link text-light" href="{{ url('/user') }}">Users</a>
                        </nav>
                    </div>
                    <div class="nav-link text-light">Expense Management</div>
                    <div class="px-4">
                        <nav class="nav flex-column">
                            <a class="nav-link text-light" href="{{ url('/category') }}">Expense Categories</a>
                            <a class="nav-link text-light" href="{{ url('/expenses') }}">Expenses</a>
                        </nav>
                    </div>                
                </nav>

            </div>

            <div class="col-10 no-padding">
                <!-- MAIN -->
                <nav class="navbar navbar-light nav shadow-sm">
                    <a class="navbar-brand" href="#">&nbsp</a>

                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif

                    @else
                    <li class="nav-item ml-auto">
                        Welcome {{ Auth::user()->name }}
                    </li>
                    
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }} </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </nav>

                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.js"></script>
<script type="text/javascript">
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Category A', 'Category B'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                
            }
        }
    });
</script>