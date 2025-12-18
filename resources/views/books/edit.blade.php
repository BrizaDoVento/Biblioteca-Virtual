@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Livro</h2>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $book->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Autor</label>
            <input type="text" name="author" class="form-control"
                   value="{{ old('author', $book->author) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <input type="text" name="category" class="form-control"
                   value="{{ old('category', $book->category) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Idioma</label>
            <input type="text" name="language" class="form-control"
                   value="{{ old('language', $book->language) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $book->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantidade Disponível</label>
            <input type="number" name="amount" class="form-control" min="1"
                   value="{{ old('amount', $book->amount) }}" required>
        </div>

        {{-- CAPA ATUAL --}}
        @if($book->image)
            <div class="mb-3">
                <label class="form-label">Capa Atual</label><br>
                <img src="{{ asset('storage/' . $book->image) }}"
                     class="img-thumbnail mb-2"
                     style="max-width: 200px;">

                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_image" value="1">
                    <label class="form-check-label">Remover capa</label>
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Nova Capa (opcional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
