@extends('layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manage Questions</h1>

    <!-- Success/Error Messages -->
    <div id="messages" class="hidden mb-4 p-4 rounded-lg"></div>

    <!-- Add New Question Button -->
    <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-6">Add New Question</button>

    <!-- Questions Table -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">All Questions</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Text</th>
                    <th class="border p-2">Type</th>
                    <th class="border p-2">Options</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="questionsTable">
                @foreach ($questions as $question)
                <tr data-id="{{ $question->id }}">
                    <td class="border p-2">{{ $question->id }}</td>
                    <td class="border p-2">{{ $question->text }}</td>
                    <td class="border p-2">{{ $question->type }}</td>
                    <td class="border p-2">
                        @if ($question->options->count())
                        <ul>
                            @foreach ($question->options as $option)
                            <li>{{ $option->value }}</li>
                            @endforeach
                        </ul>
                        @else
                        No options available.
                        @endif
                    </td>
                    <td class="border p-2">
                        <button class="edit-btn bg-yellow-500 text-white px-2 py-1 rounded-md">Edit</button>
                        <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded-md">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $questions->links() }}
        </div>
    </div>
</div>

<!-- Add New Question Modal -->
<div id="addQuestionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Add New Question</h2>
        <form id="addQuestionFormModal">
            <div class="mb-4">
                <label for="textModal" class="block text-gray-700">Question Text</label>
                <input type="text" id="textModal" name="text" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="typeModal" class="block text-gray-700">Question Type</label>
                <select id="typeModal" name="type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="User">User</option>
                    <option value="Tracer">Tracer</option>
                    <option value="Survey">Survey</option>
                    <option value="Feedback">Feedback</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Question</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelAddModal">Cancel</button>
        </form>
    </div>
</div>

<!-- Edit Question Modal -->
<div id="editQuestionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Edit Question</h2>
        <form id="editQuestionFormModal">
            <input type="hidden" id="editQuestionId" name="id">
            <div class="mb-4">
                <label for="editTextModal" class="block text-gray-700">Question Text</label>
                <input type="text" id="editTextModal" name="text" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="editTypeModal" class="block text-gray-700">Question Type</label>
                <select id="editTypeModal" name="type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="User">User</option>
                    <option value="Tracer">Tracer</option>
                    <option value="Survey">Survey</option>
                    <option value="Feedback">Feedback</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Changes</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelEditModal">Cancel</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addQuestionFormModal = document.getElementById('addQuestionFormModal');
    const editQuestionFormModal = document.getElementById('editQuestionFormModal');
    const addQuestionModal = document.getElementById('addQuestionModal');
    const editQuestionModal = document.getElementById('editQuestionModal');
    const messages = document.getElementById('messages');
    const questionsTable = document.getElementById('questionsTable');
    
    // Show message
    function showMessage(type, text) {
        messages.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
        messages.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
        messages.textContent = text;
    }

    // Open add modal
    document.getElementById('openAddModal').addEventListener('click', function() {
        addQuestionModal.classList.remove('hidden');
    });

    // Close add modal
    document.getElementById('cancelAddModal').addEventListener('click', function() {
        addQuestionModal.classList.add('hidden');
    });

    // Add new question via AJAX
    addQuestionFormModal.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(addQuestionFormModal);

        fetch('{{ route("layanan.questions.store") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success', 'Question added successfully.');
                const newRow = `
                    <tr data-id="${data.question.id}">
                        <td class="border p-2">${data.question.id}</td>
                        <td class="border p-2">${data.question.text}</td>
                        <td class="border p-2">${data.question.type}</td>
                        <td class="border p-2">No options available.</td>
                        <td class="border p-2">
                            <button class="edit-btn bg-yellow-500 text-white px-2 py-1 rounded-md">Edit</button>
                            <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded-md">Delete</button>
                        </td>
                    </tr>`;
                questionsTable.insertAdjacentHTML('beforeend', newRow);
                addQuestionFormModal.reset();
                addQuestionModal.classList.add('hidden');
            } else {
                showMessage('error', 'Failed to add question.');
            }
        });
    });

    // Open edit modal and populate the form
    questionsTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {
            const row = e.target.closest('tr');
            const questionId = row.getAttribute('data-id');
            
            // Get question data and fill the form
            fetch(`/admin/layanan-alumni/questions/${questionId}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editQuestionId').value = data.question.id;
                    document.getElementById('editTextModal').value = data.question.text;
                    document.getElementById('editTypeModal').value = data.question.type;
                    editQuestionModal.classList.remove('hidden');
                }
            });
        }
    });

    // Close edit modal
    document.getElementById('cancelEditModal').addEventListener('click', function() {
        editQuestionModal.classList.add('hidden');
    });

    // Edit question via AJAX
    editQuestionFormModal.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(editQuestionFormModal);

        const questionId = document.getElementById('editQuestionId').value;

        fetch(`/admin/layanan-alumni/questions/${questionId}`, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success', 'Question updated successfully.');
                const row = questionsTable.querySelector(`tr[data-id="${data.question.id}"]`);
                row.cells[1].textContent = data.question.text;
                row.cells[2].textContent = data.question.type;
                editQuestionModal.classList.add('hidden');
            } else {
                showMessage('error', 'Failed to update question.');
            }
        });
    });

    // Delete question via AJAX
    questionsTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-btn')) {
            const row = e.target.closest('tr');
            const questionId = row.getAttribute('data-id');

            if (confirm('Are you sure you want to delete this question?')) {
                fetch(`/admin/layanan-alumni/questions/${questionId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('success', 'Question deleted successfully.');
                        row.remove();
                    } else {
                        showMessage('error', 'Failed to delete question.');
                    }
                });
            }
        }
    });
});
</script>
@endsection
