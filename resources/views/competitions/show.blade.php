<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>{{ $competition['name'] }}</title>
</head>
<body>
<h1>{{ $competition['name'] }}</h1>

<h2>Tabela</h2>
@php
    $table = $standings[0]['table'] ?? [];
@endphp

<table border="1" cellpadding="6">
    <thead>
    <tr>
        <th>#</th>
        <th>Tim</th>
        <th>Bodovi</th>
        <th>Odigrano</th>
    </tr>
    </thead>
    <tbody>
    @foreach($table as $row)
        <tr>
            <td>{{ $row['position'] }}</td>
            <td>{{ $row['team']['name'] }}</td>
            <td>{{ $row['points'] }}</td>
            <td>{{ $row['playedGames'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Utakmice</h2>
<table border="1" cellpadding="6">
    <thead>
    <tr>
        <th>Datum</th>
        <th>Domaćin</th>
        <th>Gost</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($matches as $match)
        <tr>
            <td>{{ $match['utcDate'] }}</td>
            <td>{{ $match['homeTeam']['name'] ?? '-' }}</td>
            <td>{{ $match['awayTeam']['name'] ?? '-' }}</td>
            <td>{{ $match['status'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
