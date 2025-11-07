<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1> CRIAR EVENTO </h1>

<form action="{{route('events.store')}}" method="POST">
    @csrf
    <label for="name">nome do evento</label>
    <input type="text" name="name" id="name">
    <br>

    <label for="date">data do evento</label>
    <input type="date" name="date" id="date">
    <br>
    <label for="start_time">inicio</label>
    <input type="date" name="start_time" id="start_time">
    <br>
    <button type="submit">Criar Evento</button>
</form>
</body>
</html>