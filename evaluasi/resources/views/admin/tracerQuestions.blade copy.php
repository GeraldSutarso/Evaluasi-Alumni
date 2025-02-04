@extends('layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manage Questions</h1>

    <!-- Filter -->
    <div class="mb-4">
        <label for="filterType" class="form-label">Filter by Type:</label>
        <select id="filterType" class="form-select">
            <option value="">All</option>
            <option value="User">User</option>
            <option value="Tracer">Tracer</option>
            <option value="Survey">Survey</option>
            <option value="Feedback">Feedback</option>
            {{-- @foreach ($types as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
            @endforeach --}}
        </select>
    </div>
    
    <div class="mt-2 mb-2">
    <button class="btn btn-primary" id="openAddModal" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add New Question</button>
    </div>

    <!-- Table and Pagination -->
    <div id="questionsContainer">
        @include('admin.partials.questions', ['questions' => $questions])
        @include('admin.partials.pagination', ['questions' => $questions])
    </div>
</div>


<!-- Add New Question Modal -->
<div id="addQuestionModal" class="modal fade" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModalLabel">Add New Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addQuestionFormModal">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="textModal" class="form-label">Question Text</label>
                        <input type="text" id="textModal" name="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="typeModal" class="form-label">Question Type</label>
                        <select id="typeModal" name="type" class="form-select" required>
                            <option value="User">User</option>
                            <option value="Tracer">Tracer</option>
                            <option value="Survey">Survey</option>
                            <option value="Feedback">Feedback</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">Add Question</button>
                    <button id="cancelAddModal" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<<!-- Edit Question Modal -->
<div id="editQuestionModal" class="modal fade hidden" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuestionModalLabel">Edit Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editQuestionFormModal">
                <input type="hidden" id="editQuestionId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTextModal" class="form-label">Question Text</label>
                        <input type="text" id="editTextModal" name="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTypeModal" class="form-label">Question Type</label>
                        <select id="editTypeModal" name="type" class="form-select" required>
                            <option value="User">User</option>
                            <option value="Tracer">Tracer</option>
                            <option value="Survey">Survey</option>
                            <option value="Feedback">Feedback</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button id="cancelEditModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addQuestionFormModal = document.getElementById('addQuestionFormModal');
    const editQuestionFormModal = document.getElementById('editQuestionFormModal');
    const addQuestionModal = document.getElementById('addQuestionModal');
    const editQuestionModal = document.getElementById('editQuestionModal');
    const messages = document.getElementById('messages');
    const questionsTable = document.getElementById('questionsTable');
    const filterType = document.getElementById('filterType');
    const questionsContainer = document.getElementById('questionsContainer');

    const routes = {
        store: "{{ route('tracer.questions.store') }}",
        edit: "{{ route('tracer.questions.edit', ':id') }}",
        update: "{{ route('tracer.questions.update', ':id') }}",
        destroy: "{{ route('tracer.questions.destroy', ':id') }}",
    };

    // Fetch filtered or paginated data
    function fetchQuestions(url) {
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.json())
            .then(data => {
                questionsContainer.innerHTML = data.questions + data.pagination;
            })
            .catch(error => {
                console.error('Error fetching questions:', error);
                alert('Failed to fetch data. Please try again.');
            });
    }

    // Handle filter change
    filterType.addEventListener('change', function () {
        const type = this.value;
        const url = new URL('/admin/tracer-study/questions', window.location.origin);
        if (type) {
            url.searchParams.set('type', type);
        }
        fetchQuestions(url.toString());
    });

    // Handle pagination clicks
    document.addEventListener('click', function (e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('.pagination a').getAttribute('href');
            fetchQuestions(url);
        }
    });



    function showMessage(type, text) {
        messages.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
        messages.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
        messages.textContent = text;
    }

    document.getElementById('openAddModal').addEventListener('click', function () {
        addQuestionModal.classList.remove('hidden');
    });

    document.getElementById('cancelAddModal').addEventListener('click', function () {
        addQuestionModal.classList.add('hidden');
    });

    addQuestionFormModal.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(addQuestionFormModal);

        fetch(routes.store, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errors => {
                        let errorMessages = Object.values(errors).flat().join('\n');
                        showMessage('error', errorMessages);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showMessage('success', 'Question added successfully.');
                    const newRow = `
                        <tr data-id="${data.question.id}">
                            <td class="border p-2">${data.question.id}</td>
                            <td class="border p-2">${data.question.text}</td>
                            <td class="border p-2">${data.question.type}</td>
                            <td class="border p-2">
                                <button class="edit-btn bg-yellow-500 text-white px-2 py-1 rounded-md">Edit</button>
                                <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded-md">Delete</button>
                            </td>
                        </tr>`;
                    questionsTable.insertAdjacentHTML('beforeend', newRow);
                    addQuestionFormModal.reset();
                    addQuestionModal.classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error occurred:', error);
                showMessage('error', 'An unexpected error occurred.');
            });
    });

    questionsTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {
            const row = e.target.closest('tr');
            const questionId = row.getAttribute('data-id');

            fetch(routes.edit.replace(':id', questionId))
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

    document.getElementById('cancelEditModal').addEventListener('click', function () {
        editQuestionModal.classList.add('hidden');
    });

    editQuestionFormModal.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(editQuestionFormModal);
        formData.append('_method', 'PUT');
        const questionId = document.getElementById('editQuestionId').value;

        fetch(routes.update.replace(':id', questionId), {
            method: 'POST',
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
                }
            });
    });

    questionsTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-btn')) {
            const row = e.target.closest('tr');
            const questionId = row.getAttribute('data-id');

            if (confirm('Are you sure you want to delete this question?')) {
                fetch(routes.destroy.replace(':id', questionId), {
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