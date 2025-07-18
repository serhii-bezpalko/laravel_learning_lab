<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authors</title>
</head>
<body>
<button onclick="location.href='{{ route('authors.create') }}'" type="button">Add author</button>
<div id="table">
    <div id="table-head">
        <div>Surname</div>
        <div>Name</div>
        <div>Patronymic</div>
    </div>
    <div id="table-body">
        @foreach($authors as $author)
            <div>{{ $author->surname }}</div>
            <div>{{ $author->name }}</div>
            <div>{{ $author->patronymic }}</div>
            <form method="POST" action="{{ route('authors.destroy', $author) }}">
                @csrf
                @method('DELETE')
                <button>delete</button>
            </form>
        @endforeach
    </div>
</div>
</body>
</html>
