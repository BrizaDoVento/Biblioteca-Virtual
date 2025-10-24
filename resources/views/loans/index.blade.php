@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Empréstimos Atuais</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
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
            @foreach($emprestimos as $emprestimo)
                <tr>
                    <td>{{ $emprestimo->book->title }}</td>
                    <td>{{ $emprestimo->status->description }}</td>
                    <td>{{ $emprestimo->start_date }}</td>
                    <td>{{ $emprestimo->end_date }}</td>
                    <td>
                        @if($emprestimo->status->description == 'Emprestado')
                            <form action="{{ route('loans.return', $emprestimo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Devolver</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('loans.create') }}" class="btn btn-primary">Novo Empréstimo</a>
</div>
@endsection
