<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $book->title }}</title>
</head>
<body>
<form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <label for="title">Title</label><br>
    <input name="title" type="text" value="{{ $book->title }}"><br>
    <label for="cover">Select cover</label><br>
    <input type="file" name="cover" accept="image/*"/><br>
    <label for="description">Description</label><br>
    <textarea name="description">{{ $book->description }}</textarea><br>
    <select name="authors[]" multiple>
        @foreach($authors as $author)
            <option value="{{ $author->id }}" {{ $book->authors->contains($author->id) ? "selected" : '' }}>
                {{ "$author->surname $author->name $author->patronymic" }}
            </option>
        @endforeach
    </select>
    <button type="submit">Save</button>
</form>
</body>
</html>
