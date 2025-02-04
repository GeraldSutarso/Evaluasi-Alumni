<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Text</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="questionsTable">
        @foreach ($questions as $question)
            <tr data-id="{{ $question->id }}">
                <td>{{ $question->id }}</td>
                <td>{{ $question->text }}</td>
                <td>{{ $question->type }}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-btn">Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
