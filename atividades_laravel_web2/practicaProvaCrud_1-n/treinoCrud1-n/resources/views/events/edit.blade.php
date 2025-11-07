<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1> EDITAR EVENTO </h1>

<form action="{{ route('events.update', $event->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">nome do evento</label>
    <input type="text" name="name" id="name" value="{{ $event->name }}">
    <br>

    <label for="date">data do evento</label>
    <input type="date" name="date" id="date" value="{{ $event->date }}">
    <br>

    <button type="submit">Atualizar Evento</button>
</form>
</body>
</html> 