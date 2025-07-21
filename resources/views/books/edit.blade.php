<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit_book" method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>

                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $book->title }}">
                        <div id="error-title" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $book->description }}</textarea>
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="cover">Select cover (max size 2mb)</label>
                        <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
                        <div id="error-cover" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <select id="authors" class="form-select" size="3" name="authors[]" multiple>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ $book->authors->contains($author->id) ? "selected" : '' }}>
                                    {{ "$author->surname $author->name $author->patronymic" }}
                                </option>
                            @endforeach
                        </select>
                        <div id="error-authors" class="invalid-feedback"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#edit_book').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        const fields = ['title', 'cover', 'authors'];
        $.ajax({
            url: '{{ route('books.update', $book) }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#edit_book')[0].reset();
                fields.forEach(function (field) {
                    $('#error-' + field).html('');
                    $('#' + field).removeClass('is-invalid');
                });
                $('#edit_modal').modal('hide');
                update({{ $book->id }}, response.book);
            },
            error: function (e) {
                if (e.status === 422) {
                    fields.forEach(function (field) {
                        $('#error-' + field).html('');
                        $('#' + field).removeClass('is-invalid');
                    });

                    let errors = e.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        $('#error-' + field).html(messages[0]);
                        $('#' + field).addClass('is-invalid');
                    });
                }
            }
        });
    });
</script>
