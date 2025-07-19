<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="POST" action="{{ route('authors.update', $author) }}">
    @method('PUT')
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ $author->name }}">
    <label for="surname">Surname</label>
    <input type="text" name="surname" value="{{ $author->surname }}">
    <label for="patronymic">Patronymic</label>
    <input type="text" name="patronymic" value="{{ $author->patronymic }}">
    <button>Save</button>
</form>
</body>
</html>
