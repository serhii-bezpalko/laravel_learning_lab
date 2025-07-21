@include('layouts.header', ['title' => "Books"])
<body>
<header class="p-3 text-bg-dark" data-bs-theme="dark">
    <div class="px-3 py-2 text-bg-dark border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li>
                        <a class="nav-link px-2 text-secondary" aria-current="page" href="#">Books</a>
                    </li>
                    <li>
                        <a class="nav-link px-2 text-white" href="{{ route('authors.index') }}">Authors</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary createBtn">
                    Add book
                </button>

                <button
                    onclick="location.href='{{ route('books.index', ["sort" => $orderBy === "asc" ? "desc" : "asc", "title" => $title, "author" => $author]) }}'"
                    type="button" class="btn btn-primary mx-1">
                    @if($orderBy === "desc")
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                            <path
                                d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                            <path
                                d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
                        </svg>
                    @endif
                    Sort by title
                </button>
            </div>

            <div class="text-end">
                <form class="d-flex" role="search" method="GET">
                    <input class="form-control me-2" type="search" name="title" placeholder="Title"
                           value="{{ $title }}"
                           aria-label="Search"/>
                    <input class="form-control me-2" type="search" name="author" placeholder="Author"
                           value="{{ $author }}"
                           aria-label="Search"/>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
<div id="modalContainer"></div>
</header>
<main>
    <div class="container py-4">
        <div class="row row-cols-2 row-cols-md-5 g-4" id="list">
            @include('books.list')
        </div>
        <div id="pagination" class="my-4">
            {{ $books->links() }}
        </div>
    </div>
</main>
<script>
    $(document).on('click', '.createBtn', function () {
        $.ajax({
            url: '/books/create',
            type: 'GET',
            success: function (html) {
                $('#modalContainer').html(html); // вставляем HTML с модалкой
                $('#create_modal').modal('show');
            },
            error: function () {
                alert('Ошибка при загрузке формы');
            }
        });
    });

    $(document).on('click', '.editBtn', function () {
        let bookId = $(this).data('id');
        $.ajax({
            url: '/books/' + bookId + '/edit',
            type: 'GET',
            success: function (html) {
                $('#modalContainer').html(html); // вставляем HTML с модалкой
                $('#edit_modal').modal('show');
            },
            error: function () {
                alert('Ошибка при загрузке формы');
            }
        });
    });

    $(document).on('click', '.deleteBtn', function () {
        let bookId = $(this).data('id');

        $.ajax({
            url: '/books/' + bookId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function () {
                fetch();
            }
        })
    });

    function fetch() {
        $.ajax({
            url: '/books',
            type: 'GET',
            success: function (html) {
                $('#list').html(html.list);
                $('#pagination').html(html.pagination);
            }
        });
    }

    function update(book_id, book) {
        $('#book_' + book_id).html(book);
    }
</script>
<footer class="py-3 my-4 border-top ">
    <p class="text-center text-body-secondary">© 2025 Company, Inc</p>
</footer>
</body>
</html>
