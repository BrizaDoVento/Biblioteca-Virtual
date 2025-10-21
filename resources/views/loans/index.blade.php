@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>📚 Meus Empréstimos</h2>

    <a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">Novo Empréstimo</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Livro</th>
                <th>Status</th>
                <th>Início</th>
                <th>Devolução</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->book->title }}</td>
                <td>{{ $loan->status->description }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->start_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->end_date)->format('d/m/Y') }}</td>
                <td>
                    @if($loan->status->description === 'Emprestado')
                        <form action="{{ route('loans.return', $loan->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm">Devolver</button>
                        </form>
                    @else
                        <span class="text-muted">Devolvido</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
