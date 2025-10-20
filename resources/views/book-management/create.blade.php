@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>➕ Cadastrar Novo Livro</h2>

    <form action="{{ route('books.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="author_id" class="form-label">Autor</label>
            <select name="author_id" id="author_id" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->description }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoria</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="language_id" class="form-label">Idioma</label>
            <select name="language_id" id="language_id" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach($languages as $language)
                    <option value="{{ $language->id }}">{{ $language->description }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Quantidade em Estoque</label>
            <input type="number" name="amount" id="amount" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
