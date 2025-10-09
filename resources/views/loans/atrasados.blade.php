@extends('layout')

@section('title', 'Livros Atrasados')

@section('content')
<h1>Livros Atrasados</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Data de Devolução</th>
        </tr>
    </thead>
    <tbody>
        @forelse($atrasados as $loan)
        <tr>
            <td>{{ $loan->user->name }}</td>
            <td>{{ $loan->book->title }}</td>
            <td class="text-danger">{{ $loan->end_date }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Nenhum livro atrasado no momento.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
