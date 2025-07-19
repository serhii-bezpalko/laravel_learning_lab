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
<button onclick="location.href='{{ route('books.create') }}'" type="button">Add book</button>
<div class="books">
    @foreach($books as $book)
        <div id="{{ "book_" . $book->id }}" class="book">
            <h1>{{ $book->title }}</h1>
            <p>{{ $book->description }}</p>
            <p>Authors:</p>
            <ul>
                @foreach($book->authors as $author)
                    <li>{{ $author->surname }}</li>
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

</body>
</html>
