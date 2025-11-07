<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1> EVENTOS </h1>
<a href="{{ route('events.create') }}">Criar Novo Evento</a>
<br><br>
<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    @foreach($events as $event)
        <tr>
            <td>{{ $event->id }}</td>
            <td>{{ $event->name }}</td>
            <td>{{ $event->date }}</td>
            <td>
                <a href="{{ route('events.show', $event->id) }}">Ver</a>
                <a href="{{ route('events.edit', $event->id) }}">Editar</a>
                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Deletar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html> 