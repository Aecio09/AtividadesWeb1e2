<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1> CRIAR TICKET </h1>

<form action="{{route('tickets.store')}}" method="POST">
    <label for="event_id">evento</label>
    <select name="event_id" id="event_id">
        foreach($events as $event)
            <option value="{{ $event->id }}">{{ $event->name }}</option>
        endforeach
    </select>
    <br>

    <label for="ticket_name">nome do ticket</label>
    <input type="text" name="ticket_name" id="ticket_name">
    <br>
</body>
</html>