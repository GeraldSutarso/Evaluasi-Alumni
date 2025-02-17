@extends('layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <img src="{{ asset('img/check-list.png') }}" alt="Evaluasi Layanan Icon" class="w-16 h-16 mb-1">
    <h1 class="text-2xl font-bold mb-6">Modifikasi Survey Layanan AKTI Oleh Alumni</h1>

    <!-- Success/Error Messages -->
    <div id="messages" class="hidden mb-4 p-4 rounded-lg"></div>
    <div class="mb-4">
        <label for="filterType" class="form-label">Filter dari Tipe:</label>
        <select id="filterType" class="form-select">
            <option value="">Semua</option>
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
    <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-6">Tambah Pertanyaan</button>

    <!-- Table and Pagination -->
    <div id="questionsContainer">
        @include('admin.partials.questions', ['questions' => $questions])
        @include('admin.partials.pagination', ['questions' => $questions])
    </div>
</div>

<!-- Add New Question Modal -->
<div id="addQuestionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Tambah Pertanyaan</h2>
        <form id="addQuestionFormModal">
            <div class="mb-4">
                <label for="textModal" class="block text-gray-700">Teks Pertanyaan</label>
                <input type="text" id="textModal" name="text" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="typeModal" class="block text-gray-700">Tipe Pertanyaan</label>
                <select id="typeModal" name="type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="User">User</option>
                    <option value="Survey">Survey</option>
                    <option value="Feedback">Feedback</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tambah</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelAddModal">Cancel</button>
        </form>
    </div>
</div>

<!-- Edit Question Modal -->
<div id="editQuestionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Edit Pertanyaan</h2>
        <form id="editQuestionFormModal">
            <input type="hidden" id="editQuestionId" name="id">
            <div class="mb-4">
                <label for="editTextModal" class="block text-gray-700">Text Pertanyaan</label>
                <input type="text" id="editTextModal" name="text" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="editTypeModal" class="block text-gray-700">Tipe Pertanyaan</label>
                <select id="editTypeModal" name="type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="User">User</option>
                    <option value="Survey">Survey</option>
                    <option value="Feedback">Feedback</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelEditModal">Cancel</button>
        </form>
    </div>
</div>

<div id="addOptionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Tambah Opsi</h2>
        <form id="addOptionFormModal">
            <div class="mb-4">
                <label for="optionValue" class="block text-gray-700">Teks Opsi</label>
                <input type="text" id="optionValue" name="value" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tambah</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelAddOptionModal">Cancel</button>
        </form>
    </div>
</div>


<div id="editOptionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Edit Opsi</h2>
        <form id="editOptionFormModal">
            <input type="hidden" id="editOptionId" name="id">
            <div class="mb-4">
                <label for="editOptionValue" class="block text-gray-700">Teks Opsi</label>
                <input type="text" id="editOptionValue" name="value" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelEditOptionModal">Cancel</button>
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success', 'Question added successfully.');
                // Build the new row
                const newRow = `
                    <tr data-id="${data.question.id}">
                        <td>${data.question.id}</td>
                        <td>${data.question.text}</td>
                        <td>${data.question.type}</td>
                        <td>
                            <span class="text-muted">Tidak ada opsi</span>
                            <button class="btn btn-sm btn-primary add-option-btn" data-question-id="${data.question.id}">+</button>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg></button>
                            <button class="btn btn-danger btn-sm delete-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg></button>
                        </td>
                    </tr>`;
                questionsTable.insertAdjacentHTML('beforeend', newRow);
                addQuestionFormModal.reset();
                addQuestionModal.classList.add('hidden');
            } else {
                showMessage('error', 'Failed to add question.');
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
    // Add Option Functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-option-btn')) {
        const questionId = e.target.dataset.questionId;
        document.getElementById('addOptionModal').dataset.questionId = questionId;
        document.getElementById('addOptionModal').classList.remove('hidden');
    }
});

document.getElementById('cancelAddOptionModal').addEventListener('click', function() {
    document.getElementById('addOptionModal').classList.add('hidden');
});

document.getElementById('addOptionFormModal').addEventListener('submit', function(e) {
    e.preventDefault();
    const questionId = document.getElementById('addOptionModal').dataset.questionId;
    const formData = new FormData(this); // This formData now has a field named "value"
    
    fetch(`/admin/layanan-alumni/questions/${questionId}/options`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
            // Do not set Content-Type manually when sending FormData
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the DOM dynamically
            // Save a reference to the "Add Option" button before modifying the cell
            const questionRow = document.querySelector(`tr[data-id="${questionId}"]`);
            const td = questionRow.querySelector('td:nth-child(4)');
            const addOptionBtn = td.querySelector('.add-option-btn'); // Save the button reference

            // Check if there is already an unordered list for options
            let optionsList = td.querySelector('ul.list-unstyled');
            if (!optionsList) {
                // Create a new UL element and clear existing content (e.g., "No options" span)
                optionsList = document.createElement('ul');
                optionsList.className = 'list-unstyled mb-0';
                td.innerHTML = ''; // Clear all content in the cell
                td.appendChild(optionsList);
            }
            
            // Create a new <li> element for the new option
            const newOption = document.createElement('li');
            newOption.dataset.optionId = data.option.id;
            newOption.innerHTML = `
                <span class="option-text">• ${data.option.value}</span>
                <button class="btn btn-sm btn-warning edit-option-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                </button>
                <button class="btn btn-sm btn-danger delete-option-btn mt-1 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </button>
                <hr>
            `;

            // Append the new option
            optionsList.appendChild(newOption);
            
            // Append the "Add Option" button if it exists
            if (addOptionBtn) {
                td.appendChild(addOptionBtn);
            }
            
            // Hide the modal and reset the form
            document.getElementById('addOptionModal').classList.add('hidden');
            this.reset();
        } else {
            alert('Failed to add option');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    });
});

// Edit Option Functionality
// Edit Option Functionality using closest()
document.addEventListener('click', function(e) {
    const editBtn = e.target.closest('.edit-option-btn');
    if (editBtn) {
        const optionItem = editBtn.closest('li');
        const optionId = optionItem.dataset.optionId;
        // Retrieve only the text from the designated span (avoiding SVG text)
        const optionTextElement = optionItem.querySelector('.option-text');
        const optionText = optionTextElement ? optionTextElement.textContent.replace('• ', '') : '';
        
        document.getElementById('editOptionId').value = optionId;
        document.getElementById('editOptionValue').value = optionText;
        document.getElementById('editOptionModal').classList.remove('hidden');
    }
});

document.getElementById('cancelEditOptionModal').addEventListener('click', function() {
    document.getElementById('editOptionModal').classList.add('hidden');
});

document.getElementById('editOptionFormModal').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('_method', 'PUT'); // Spoof the PUT method
    const optionId = document.getElementById('editOptionId').value;
    
    fetch(`/admin/layanan-alumni/options/${optionId}`, {  // Make sure the URL is correct (including prefix if needed)
        method: 'POST', // Use POST with _method spoofing
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const optionItem = document.querySelector(`li[data-option-id="${optionId}"]`);
            optionItem.querySelector('.option-text').textContent = `• ${data.option.value}`;
            document.getElementById('editOptionModal').classList.add('hidden');
            this.reset();
        } else {
            alert('Failed to update option');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    });
});

// Delete Option Functionality using closest()
document.addEventListener('click', function(e) {
    const deleteBtn = e.target.closest('.delete-option-btn');
    if (deleteBtn) {
        const optionItem = deleteBtn.closest('li');
        const optionId = optionItem.dataset.optionId;
        
        if (confirm('Are you sure you want to delete this option?')) {
            fetch(`/admin/layanan-alumni/options/${optionId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Get the parent cell (td) that contains the options list and the add option button.
                    const td = optionItem.closest('td');
                    
                    // Save a reference to the "Add Option" button (if it exists)
                    const addOptionBtn = td.querySelector('.add-option-btn');
                    
                    // Remove the option item from the list.
                    optionItem.remove();
                    
                    // Check if the unordered list still exists and if it has any children.
                    const optionsList = td.querySelector('ul.list-unstyled');
                    if (!optionsList || optionsList.children.length === 0) {
                        // If no options remain, set the cell's inner HTML to a "No options" placeholder.
                        // Then, if an add option button exists, append it.
                        td.innerHTML = '<span class="text-muted">Tidak ada opsi</span>';
                        if (addOptionBtn) {
                            td.appendChild(addOptionBtn);
                        }
                    }
                } else {
                    alert('Failed to delete option');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred.');
            });
        }
    }
});

});
window.addEventListener('popstate', function() {
    fetchQuestions(window.location.href);
});
</script>
@endsection
