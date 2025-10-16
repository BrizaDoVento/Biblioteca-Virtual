@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>✏️ Editar Livro</h2>

    <form action="{{ route('book-management.update', $book) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Autor</label>
            <select name="author_id" class="form-select" required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                        {{ $author->description }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->description }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Idioma</label>
            <select name="language_id" class="form-select" required>
                @foreach($languages as $language)
                    <option value="{{ $language->id }}" {{ $book->language_id == $language->id ? 'selected' : '' }}>
                        {{ $language->description }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantidade</label>
            <input type="number" name="amount" class="form-control" value="{{ $book->amount }}" required min="1">
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('book-management.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
