@foreach($authors as $author)
    <tr  id="{{ "author_" . $author->id }}">
    @include('authors._author')
    </tr>
@endforeach
