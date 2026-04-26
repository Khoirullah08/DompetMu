<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SakuPintar v3 - Personal Finance')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />
    <style>
        :root {
            --brand: #0b6b5b;
            --brand-dark: #085347;
            --surface: #f7faf8;
            --text-main: #22313f;
        }

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(11, 107, 91, 0.08), transparent 24%),
                linear-gradient(180deg, #fbfdfc 0%, #f3f7f5 100%);
            color: var(--text-main);
        }

        .card-shadow { box-shadow: 0 12px 35px rgba(15, 23, 42, 0.07); }
        .dropdown-menu { display: none; }
        .dropdown-menu.show { display: block; animation: slideDown 0.2s ease-out; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('styles')
</head>
<body class="flex min-h-screen">

    @include('layouts._sidebar')

    <div class="flex-1 ml-0 min-h-screen md:ml-20 lg:ml-64">

        @include('layouts._navbar')

        @yield('content')

    </div>

    <script>
        const btn = document.getElementById('profileBtn');
        const menu = document.getElementById('profileDropdown');

        if (btn && menu) {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('show');
            });

            document.addEventListener('click', () => menu.classList.remove('show'));
        }
    </script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
    @yield('scripts')
</body>
</html>
