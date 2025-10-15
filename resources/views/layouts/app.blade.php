<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>

    {{-- Bootstrap CSS (opcional, mas recomendado) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Estilo personalizado opcional --}}
    <style>
        body {
            background-color: #f8f9fa;
        }
        nav.navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    {{-- Navbar simples --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('books.index') }}">📚 Biblioteca Virtual</a>
            <div>
                <a href="{{ route('books.index') }}" class="btn btn-outline-light btn-sm me-2">Livros</a>
                <a href="{{ route('loans.index') }}" class="btn btn-outline-light btn-sm me-2">Empréstimos</a>
                <a href="{{ route('loans.overdue') }}" class="btn btn-outline-warning btn-sm">Atrasados</a>
            </div>
        </div>
    </nav>

    {{-- Conteúdo dinâmico --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
