<div class="card h-100">
        <img class="card-img-top h-100" src="{{ asset("/storage/images/" . $book->cover) }}"
             alt="book cover">
        <div class="card-body">

            <h5 class="card-title">{{ $book->title }}</h5>
            <p class="card-text">{{ $book->description }}</p>
            <p class="card-text">Authors:</p>
            <ul>
                @foreach($book->authors as $author)
                    <li>{{ $author->surname . " " . $author->name }}</li>
                @endforeach
            </ul>
            <div class="d-grid gap-2 d-md-block">
                <button type="button" class="btn btn-primary editBtn" data-id="{{ $book->id }}">
                    Edit
                </button>
                <button type="button" class="btn btn-danger deleteBtn" data-id="{{ $book->id }}">Delete</button>
            </div>
        </div>
    </div>
