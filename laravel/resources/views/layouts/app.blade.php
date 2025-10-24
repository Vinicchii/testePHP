<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Pedidos')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" >

</head>
<body>
    <nav class="navbar navbar-dark bg-secondary mb-4">
        <div class="container justify-content-center">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="navbar-brand nav-link {{ Request::is('/') ? 'active' : '' }}"
                    href="{{ url('/') }}"><i class="bi bi-house-fill fs-4 me-2"></i>Home</a>
                </li>

                <li class="nav-item">
                    <a class="navbar-brand nav-link {{ Request::is('clientes') ? 'active' : '' }}"
                    href="{{ url('/clientes') }}"><i class="bi bi-person-fill fs-4 me-2"></i>Clientes</a>
                </li>

                <li class="nav-item">
                    <a class="navbar-brand nav-link {{ Request::is('produtos') ? 'active' : '' }}"
                    href="{{ url('/produtos') }}"><i class="bi bi-box-seam-fill fs-4 me-2"></i>Produtos</a>
                </li>

                <li class="nav-item">
                    <a class="navbar-brand nav-link {{ Request::is('pedidos') ? 'active' : '' }}"
                    href="{{ url('/pedidos') }}"><i class="bi bi-bag-fill fs-4 me-2"></i>Pedidos</a>
                </li>

            </ul>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
