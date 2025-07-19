<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create book</title>
</head>
<body>
<form method="POST" action="{{ route('books.store') }}">
    @csrf
    <label for="title">Title</label><br>
    <input name="title" type="text"><br>
    <label for="description">Description</label><br>
    <textarea name="description"></textarea><br>
    <select name="authors[]" multiple>
        @foreach($authors as $author)
            <option value="{{ $author->id }}">{{ "$author->surname $author->name $author->patronymic" }}</option>
        @endforeach
    </select>
    <button type="submit">Create</button>
</form>
</body>
</html>
