@extends('layout')

@section('title', 'Livros')

@section('content')
<h1>Lista de Livros</h1>

@if($books->isEmpty())
    <p class="text-muted">Nenhum livro cadastrado ainda.</p>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Idioma</th>
            <th>Estoque</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->description ?? '—' }}</td>
            <td>{{ $book->category->description ?? '—' }}</td>
            <td>{{ $book->language->description ?? '—' }}</td>
            <td>{{ $book->amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
