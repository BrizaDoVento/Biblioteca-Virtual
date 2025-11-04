@extends('layouts.app')

@section('title', 'Adicionar Livro')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Adicionar Novo Livro</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Título</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Autor</label>
                {{-- <select class="form-control" name="" id="">
                    @foreach ($autor as $item)
                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                    @endforeach
                </select> --}}
                <input type="text" name="author" class="form-control">
            </div>
            <div class="mb-3">
                <label>Categoria</label>
                <input type="text" name="category" class="form-control">
            </div>
            <div class="mb-3">
                <label>Linguagem</label>
                <input type="text" name="language" class="form-control">
            </div>
            <div class="mb-3">
                <label>Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
            <div class="form-group mt-3">
                <label for="amount">Quantidade disponível:</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount', 1) }}"
                    min="0" required>
            </div>
        </form>
    </div>
@endsection
