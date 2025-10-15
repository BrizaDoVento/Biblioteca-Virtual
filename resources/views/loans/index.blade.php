@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>📚 Empréstimos de Livros</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Status</th>
                <th>Início</th>
                <th>Devolução</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td>{{ $loan->user->name ?? 'Desconhecido' }}</td>
                    <td>{{ $loan->book->title ?? 'Indefinido' }}</td>
                    <td>{{ $loan->status->description ?? '-' }}</td>
                    <td>{{ $loan->start_date }}</td>
                    <td>{{ $loan->end_date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum empréstimo registrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
