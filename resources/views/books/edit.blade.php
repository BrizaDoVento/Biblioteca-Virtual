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
    </form>
</div>
@endsection
