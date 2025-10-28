@extends('layouts.app')

@section('title', 'Empréstimos')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">📚 Empréstimos</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Formulário para emprestar um livro -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Novo Empréstimo</h5>
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="book_id" class="form-label">Selecione o Livro</label>
                    <select name="book_id" id="book_id" class="form-select" required>
                        <option value="">-- Escolha um livro --</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->amount }} disponíveis)</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Emprestar</button>
            </form>
        </div>
    </div>

    <!-- Tabela de empréstimos -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Livros Emprestados</h5>

            @if ($loans->isEmpty())
                <p class="text-muted">Nenhum empréstimo registrado.</p>
            @else
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Livro</th>
                            <th>Status</th>
                            <th>Data do Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loan->user->name ?? 'Usuário desconhecido' }}</td>
                                <td>{{ $loan->book->title ?? 'Livro excluído' }}</td>
                                <td>
                                    @if ($loan->status == 'Emprestado')
                                        <span class="badge bg-warning text-dark">Emprestado</span>
                                    @else
                                        <span class="badge bg-success">Devolvido</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($loan->start_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->end_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($loan->status == 'Emprestado')
                                        <form action="{{ route('loans.return', $loan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Devolver</button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('loans.overdue') }}" class="btn btn-outline-danger">Ver Livros Atrasados</a>
    </div>
</div>
@endsection
