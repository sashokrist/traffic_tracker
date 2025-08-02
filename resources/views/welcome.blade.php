<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracker for Web Traffic</title>

    <!-- Fonts & Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.bunny.net/css?family=Figtree:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <style>
        body {
            margin: 0;
            background-color: #000;
            color: white;
            font-family: 'Figtree', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 100px;
        }

        .button-container {
            border: 4px solid black;
            background: white;
            color: black;
            padding: 40px 80px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            display: inline-block;
            margin: 10px;
        }

        .button-container:hover {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Tracker for Web Traffic') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- Right -->
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container text-center mt-5">
    <h1>Welcome to the Tracker for Web Traffic</h1>
    <a href="http://web-tracker.test/site/spare-part.php" class="button-container" target="_blank" rel="noopener noreferrer">Spare part</a>
    <a href="{{ url('/dashboard') }}" class="button-container">Go to Dashboard</a>
</div>

<!-- Optional: Toggle View/Theme JS -->
<script>
    const toggleViewBtn = document.getElementById('toggle-view');
    const toggleThemeBtn = document.getElementById('toggle-theme');
    const uniqueTable = document.getElementById('unique-table-view');
    const uniqueBox = document.getElementById('unique-box-view');
    const allTable = document.getElementById('all-table-view');
    const allBox = document.getElementById('all-box-view');
    const container = document.getElementById('theme-container');

    if (toggleViewBtn) {
        toggleViewBtn.addEventListener('click', () => {
            uniqueTable?.classList.toggle('d-none');
            uniqueBox?.classList.toggle('d-none');
            allTable?.classList.toggle('d-none');
            allBox?.classList.toggle('d-none');
        });
    }

    if (toggleThemeBtn) {
        toggleThemeBtn.addEventListener('click', () => {
            container?.classList.toggle('bg-dark');
            container?.classList.toggle('text-light');
        });
    }
</script>
</body>
</html>
