@extends('layouts.app')

@section('title', 'Editar Livro')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Editar Livro</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
        </div>
        <div class="mb-3">
            @if ($book->cover_image)
    <div class="mb-3">
        <p><strong>Capa atual:</strong></p>
        <img src="{{ asset('storage/' . $book->cover_image) }}" width="150" class="rounded mb-2">

        <div class="form-check">
            <input type="checkbox" name="remove_image" value="1" class="form-check-input">
            <label class="form-check-label">Remover imagem</label>
        </div>
    </div>
@endif

<div class="mb-3 mt-3">
    <label class="form-label">Nova capa (opcional)</label>
    <input type="file" name="cover_image" class="form-control">
</div>
            <label>Autor</label>
            <input type="text" name="author" class="form-control" value="{{ $book->author }}">
        </div>
        <div class="mb-3">
            <label>Categoria</label>
            <input type="text" name="category" class="form-control" value="{{ $book->category }}">
        </div>
        <div class="mb-3">
            <label>Linguagem</label>
            <input type="text" name="language" class="form-control" value="{{ $book->language }}">
        </div>
        <div class="mb-3">
            <label>Descrição</label>
            <textarea name="description" class="form-control">{{ $book->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
        <div class="form-group mt-3">
    <label for="amount">Quantidade disponível:</label>
    <input
        type="number"
        name="amount"
        id="amount"
        class="form-control"
        value="{{ old('amount', $book->amount) }}"
        min="0"
        required
    >
</div>
    </form>
</div>
@endsection
