
<!-- Modal -->
<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="create_book" method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>

                        <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                        <div id="error-title" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="cover">Select cover (max size 2mb)</label>
                        <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
                        <div id="error-cover" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <select id="authors" class="form-select" size="3" name="authors[]" multiple>
                            @foreach($authors as $author)
                                <option
                                    value="{{ $author->id }}">{{ "$author->surname $author->name $author->patronymic" }}</option>
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
    $('#create_book').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        const fields = ['title', 'cover', 'authors'];
        $.ajax({
            url: '{{ route('books.store') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                $('#create_book')[0].reset();
                fields.forEach(function (field) {
                    $('#error-' + field).html('');
                    $('#' + field).removeClass('is-invalid');
                });
                $('#create_modal').modal('hide');
                fetch();
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
