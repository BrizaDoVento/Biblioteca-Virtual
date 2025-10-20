@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>➕ Cadastrar Livro</h2>

    {{-- Exibe mensagens de erro, se houver --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('book-management.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Digite o título do livro" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Autor</label>
            <input type="text" name="author" id="author" class="form-control" placeholder="Digite o nome do autor" value="{{ old('author') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Categoria</label>
            <input type="text" name="category" id="category" class="form-control" placeholder="Digite a categoria" value="{{ old('category') }}" required>
        </div>

        <div class="mb-3">
            <label for="language" class="form-label">Idioma</label>
            <input type="text" name="language" id="language" class="form-control" placeholder="Digite o idioma" value="{{ old('language') }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Quantidade em Estoque</label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Digite a quantidade" value="{{ old('amount') }}" required min="1">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('book-management.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
