@foreach($books as $book)
    <div id="{{ "book_" . $book->id }}">
        @include('books._book', ['book' => $book])
    </div>
@endforeach
