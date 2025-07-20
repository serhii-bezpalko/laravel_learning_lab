<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books</title>
    <link rel="stylesheet" href="{{ asset("assets/css/main.css") }}">
</head>
<body>
<button onclick="location.href='{{ route('index') }}'" type="button">Index</button>
<button onclick="location.href='{{ route('authors.index') }}'" type="button">Authors</button>
<button onclick="location.href='{{ route('books.index') }}'" type="button">Books</button>
<button onclick="location.href='{{ route('books.create') }}'" type="button">Add book</button>
<button onclick="location.href='{{ route('books.index', ["sort" => $orderBy === "asc" ? "desc" : "asc", "title" => $title, "author" => $author]) }}'" type="button">
    {{ $orderBy === "asc" ? "Z-A" : "A-Z" }}
</button>
<form method="GET" action="{{ route("books.index") }}">
    <label for="title">Title:</label>
    <input type="text" name="title" value="{{ $title }}">
    <label for="author">Author:</label>
    <input type="text" name="author" value="{{ $author }}">
    <button type="submit">Search</button>
</form>
<div class="books">
    @foreach($books as $book)
        <div id="{{ "book_" . $book->id }}" class="book">
            <img src="{{ asset("/storage/images/" . $book->cover) }}" alt="book cover">
            <h1>{{ $book->title }}</h1>
            <p>{{ $book->description }}</p>
            <p>Authors:</p>
            <ul>
                @foreach($book->authors as $author)
                    <li>{{ $author->surname . " " . $author->name }}</li>
                @endforeach
            </ul>
            <form method="GET" action="{{ route('books.edit', $book) }}">
                <button type="submit">Edit</button>
            </form>
            <form method="POST" action="{{ route('books.destroy', $book) }}">
                @method('DELETE')
                @csrf
                <button type="submit">Delete</button>
            </form>
        </div>
    @endforeach
</div>
{{ $books->links("vendor.pagination.default") }}
</body>
</html>
