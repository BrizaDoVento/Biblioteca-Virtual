@extends('layout')

@section('title', 'Livros')

@section('content')
<h1>Lista de Livros</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Idioma</th>
            <th>Estoque</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->description }}</td>
            <td>{{ $book->category->description }}</td>
            <td>{{ $book->language->description }}</td>
            <td>{{ $book->amount }}</td>
            <td>
                @if($book->amount > 0)
                    <form action="{{ route('loans.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-sm btn-primary">Emprestar</button>
                    </form>
                @else
                    <span class="text-danger">Indisponível</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
