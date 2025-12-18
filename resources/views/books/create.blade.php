@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Novo Livro</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Autor</label>
            <input type="text" name="author" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Idioma</label>
            <input type="text" name="language" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantidade Disponível</label>
            <input type="number" name="amount" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Capa do Livro</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
