@extends('layouts.app')

@section('title', 'Empréstimos de Livros')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">📚 Empréstimos de Livros</h1>

    {{-- Mensagens de sucesso/erro --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Formulário de novo empréstimo --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Novo Empréstimo
        </div>
        <div class="card-body">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf

                {{-- Usuário --}}
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuário</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Selecione o usuário --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Livro --}}
                <div class="mb-3">
                    <label for="book_id" class="form-label">Livro</label>
                    <select name="book_id" id="book_id" class="form-select" required>
                        <option value="">-- Selecione o livro --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">
                                {{ $book->title }} — {{ $book->author }}
                                ({{ $book->amount }} disponíveis)
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">📖 Emprestar Livro</button>
            </form>
        </div>
    </div>

    {{-- Listagem de empréstimos --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            Lista de Empréstimos Atuais
        </div>
        <div class="card-body">
            @if($loans->isEmpty())
                <p class="text-muted">Nenhum empréstimo registrado.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Livro</th>
                            <th>Início</th>
                            <th>Devolução</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr @if(isset($loan->end_date) && $loan->end_date < now() && $loan->getStatus?->description === 'Emprestado') class="table-danger" @endif>
                                <td>{{ $loan->user->name ?? '—' }}</td>
                                <td>{{ $loan->book->title ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->start_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->end_date)->format('d/m/Y') }}</td>
                                <td>{{ $loan->getStatus->description ?? 'Desconhecido' }}</td>
                                <td>
                                    @if($loan->getStatus && $loan->getStatus === 'Emprestado')
                                        <form action="{{ route('loans.return', $loan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">Devolver</button>
                                        </form>
                                    @else
                                        <span class="text-success">✔ Devolvido</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
