@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>📚 Gerenciamento de Livros</h2>

    <a href="{{ route('book-management.create') }}" class="btn btn-primary mb-3">➕ Adicionar Livro</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoria</th>
                <th>Idioma</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->description ?? '—' }}</td>
                    <td>{{ $book->category->description ?? '—' }}</td>
                    <td>{{ $book->language->description ?? '—' }}</td>
                    <td>{{ $book->amount }}</td>
                    <td>
                        <a href="{{ route('book-management.edit', $book) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('book-management.destroy', $book) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Deseja excluir este livro?')" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Nenhum livro cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
