<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layout')

    @section('title','Livros')

    @section('content')
    <h1>Lista de Livros</h1>

    <table class="table table=bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoria</th>
                <th>Idioma</th>
                <th>Estoque</th>
                <th>Ação</th>
            </tr>
</body>
</html>
