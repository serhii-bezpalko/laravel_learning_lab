<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit_author" method="POST" action="{{ route('authors.update', $author) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add author</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" value="{{ $author->surname }}">
                        <div id="error-surname" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $author->name }}">
                        <div id="error-name" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="patronymic" class="form-label">Patronymic</label>
                        <input type="text" class="form-control" id="patronymic" name="patronymic" placeholder="Patronymic" value="{{ $author->patronymic }}">
                        <div id="error-patronymic" class="invalid-feedback"></div>
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
    $('#edit_author').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        const fields = ['surname', 'name', 'patronymic'];
        $.ajax({
            url: '{{ route('authors.update', $author) }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#edit_author')[0].reset();
                fields.forEach(function (field) {
                    $('#error-' + field).html('');
                    $('#' + field).removeClass('is-invalid');
                });
                $('#edit_modal').modal('hide');
                update({{ $author->id }}, response.author);
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
