@extends('layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manage Questions</h1>

    <!-- Success/Error Messages -->
    <div id="messages" class="hidden mb-4 p-4 rounded-lg"></div>
    <div class="mb-4">
        <label for="filterType" class="form-label">Filter by Type:</label>
        <select id="filterType" class="form-select">
            <option value="">All</option>
            <option value="User">User</option>
            <option value="Survey">Survey</option>
            <option value="Feedback">Feedback</option>
            {{-- @foreach ($types as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
            @endforeach --}}
        </select>
    </div>

    <!-- Add New Question Button -->
    <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-6">Add New Question</button>

    <!-- Table and Pagination -->
    <div id="questionsContainer">
        @include('admin.partials.questions', ['questions' => $questions])
        @include('admin.partials.pagination', ['questions' => $questions])
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
    const filterType = document.getElementById('filterType');
    const questionsContainer = document.getElementById('questionsContainer');

    const routes = {
        store: "{{ route('layanan.questions.store') }}",
        edit: "{{ route('layanan.questions.edit', ':id') }}",
        update: "{{ route('layanan.questions.update', ':id') }}",
        destroy: "{{ route('layanan.questions.destroy', ':id') }}",
    };
    editQuestionFormModal.addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(editQuestionFormModal);
    formData.append('_method', 'PUT');
    const questionId = document.getElementById('editQuestionId').value;
    const currentUrl = window.location.href; // Get current page URL

    fetch(routes.update.replace(':id', questionId), {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('success', 'Question updated successfully.');
            // Refresh the current page's data
            fetchQuestions(currentUrl);
            editQuestionModal.classList.add('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('error', 'Failed to update question.');
    });
});
    // Modified event listeners for dynamic content
    document.addEventListener('click', function (e) {
        // Handle Edit button clicks
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn) {
            const row = editBtn.closest('tr');
            const questionId = row.dataset.id;

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

        // Handle Delete button clicks
        const deleteBtn = e.target.closest('.delete-btn');
        if (deleteBtn) {
            const row = deleteBtn.closest('tr');
            const questionId = row.dataset.id;

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

        // Handle Pagination clicks
        const paginationLink = e.target.closest('.pagination a');
        if (paginationLink) {
            e.preventDefault();
            fetchQuestions(paginationLink.href);
        }
    });

    // Fetch filtered or paginated data
    function fetchQuestions(url) {
    // Update browser history without reloading
    window.history.pushState({}, '', url);
    
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => response.json())
        .then(data => {
            questionsContainer.innerHTML = data.questions + data.pagination;
        })
        .catch(error => {
            console.error('Error fetching questions:', error);
            showMessage('error', 'Failed to refresh data');
        });
    }

    // Handle filter change
    filterType.addEventListener('change', function () {
        const type = this.value;
        const url = new URL('/admin/layanan-alumni/questions', window.location.origin);
        if (type) {
            url.searchParams.set('type', type);
        }
        fetchQuestions(url.toString());
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
});
window.addEventListener('popstate', function() {
    fetchQuestions(window.location.href);
});
    // questionsTable.addEventListener('click', function (e) {
    //     if (e.target.classList.contains('delete-btn')) {
    //         const row = e.target.closest('tr');
    //         const questionId = row.getAttribute('data-id');

    //         if (confirm('Are you sure you want to delete this question?')) {
    //             fetch(routes.destroy.replace(':id', questionId), {
    //                 method: 'DELETE',
    //                 headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    //             })
    //                 .then(response => response.json())
    //                 .then(data => {
    //                     if (data.success) {
    //                         showMessage('success', 'Question deleted successfully.');
    //                         row.remove();
    //                     } else {
    //                         showMessage('error', 'Failed to delete question.');
    //                     }
    //                 });
    //         }
    //     }
    // });
</script>
@endsection
