@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Livros</h2>
        <a href="{{ route('books.create') }}" class="btn btn-success">+ Novo Livro</a>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Capa</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoria</th>
                <th>Idioma</th>
                <th>Qtd</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($books as $book)
                <tr>
                    <td style="width: 90px; text-align: center;">
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}"
                                 class="img-thumbnail"
                                 style="width: 60px;">
                        @else
                            <span class="text-muted">Sem capa</span>
                        @endif
                    </td>

                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category }}</td>
                    <td>{{ $book->language }}</td>
                    <td>{{ $book->amount }}</td>

                    <td>
                        <a href="{{ route('books.edit', $book->id) }}"
                           class="btn btn-sm btn-primary">Editar</a>

                        <form action="{{ route('books.destroy', $book->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Excluir este livro?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Nenhum livro cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
