<td>{{ $author->surname }}</td>
<td style="display: table-cell">{{ $author->name }}</td>
<td>{{ $author->patronymic }}</td>
<td>
    <button type="button" class="btn btn-primary editBtn" data-id="{{ $author->id }}">Edit</button>
</td>
<td>
    <button type="button" class="btn btn-danger deleteBtn" data-id="{{ $author->id }}">Delete</button>
</td>
