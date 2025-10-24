<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Estilos personalizados --}}
    <style>
        body {
            background-color: #f8f9fa;
        }
        nav.navbar {
            margin-bottom: 20px;
        }
        footer {
            text-align: center;
            padding: 15px 0;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('book-management.index') }}">📚 Biblioteca Virtual</a>

            <div class="d-flex">
                <a href="{{ route('book-management.index') }}" class="btn btn-outline-light btn-sm me-2">Livros</a>
                <a href="{{ route('loans.index') }}" class="btn btn-outline-light btn-sm me-2">Empréstimos</a>
                <a href="{{ route('loans.overdue') }}" class="btn btn-outline-warning btn-sm">Atrasados</a>
            </div>
        </div>
    </nav>

    {{-- Conteúdo principal --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- Rodapé --}}
    <footer>
        <small>Biblioteca Virtual © {{ date('Y') }} - Desenvolvido com Laravel</small>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
