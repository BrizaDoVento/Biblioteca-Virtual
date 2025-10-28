@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Empréstimos Atrasados</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($overdueLoans->isEmpty())
        <p>Não há livros atrasados.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Livro</th>
                    <th>Data limite</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overdueLoans as $loan)
                    <tr>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($loan->end_date)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
