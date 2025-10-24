@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Emprestar Livro</h2>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="book_id">Selecione um Livro</label>
            <select name="book_id" id="book_id" class="form-control" required>
                <option value="">-- Escolha --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->amount }} disponíveis)</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary mt-3">Emprestar</button>
    </form>
</div>
@endsection
