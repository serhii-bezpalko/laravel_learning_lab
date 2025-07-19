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
<table>
    <thead>
    <tr>
        <th scope="col">Surname</th>
        <th scope="col">Name</th>
        <th scope="col">Patronymic</th>
    </tr>
    </thead>
    <tbody>
    @foreach($authors as $author)
        <tr>
            <td>{{ $author->surname }}</td>
            <td style="display: table-cell">{{ $author->name }}</td>
            <td>{{ $author->patronymic }}</td>
            <td>
                <form method="GET" action="{{ route('authors.edit', $author) }}">
                    <button type="submit">Edit</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('authors.destroy', $author) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
