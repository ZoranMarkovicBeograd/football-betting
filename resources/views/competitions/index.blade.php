<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Takmičenja</title>
</head>
<body>
<h1>Lista takmičenja</h1>

<ul>
    @foreach($competitions as $competition)
        <li>
            <a href="{{ route('competitions.show', $competition['code']) }}">
                {{ $competition['name'] }}
            </a>
        </li>
    @endforeach
</ul>
</body>
</html>
