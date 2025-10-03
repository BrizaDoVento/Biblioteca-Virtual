<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends ('layout')

    @section('title', 'Meus Empréstimos')

    @section('content')
    <h1>Meus Empréstimos</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Livro</th>
                <th>Status</th>
                <th>Início</th>
                <th>Devolução</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
            <tr>
                <td>{{ @loan->book->title }}</td>
                <td>{{ @loan->status->description }}</td>
                <td>{{ @loan->start_date }}</td>
                <td>{{ @loan->end_date }}</td>
                <td>
                    @if($loan->status_id == \App\Models\UsersBooksStatus::EMPRESTADO)
                    <form action="{{ route('loans.return', $loans->id) }}" method="POST">
                        @csrf<button type="submit" class="btn btn-sm btn-success">Devolver</button>
                    </form>
                    @else
                    <span class="text-secondary">Devolvido</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
</body>
</html>
