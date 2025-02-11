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

<div id="addOptionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Add Option</h2>
        <form id="addOptionFormModal">
            <div class="mb-4">
                <label for="optionValue" class="block text-gray-700">Option Text</label>
                <input type="text" id="optionValue" name="text" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Option</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelAddOptionModal">Cancel</button>
        </form>
    </div>
</div>


<div id="editOptionModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Edit Option</h2>
        <form id="editOptionFormModal">
            <input type="hidden" id="editOptionId" name="id">
            <div class="mb-4">
                <label for="editOptionValue" class="block text-gray-700">Option Text</label>
                <input type="text" id="editOptionValue" name="text" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Changes</button>
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mt-2" id="cancelEditOptionModal">Cancel</button>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script>
// document.addEventListener('DOMContentLoaded', function () {
//     // Option modal elements
//     const addOptionModal = document.getElementById('addOptionModal');
//     const editOptionModal = document.getElementById('editOptionModal');
//     const addOptionFormModal = document.getElementById('addOptionFormModal');
//     const editOptionFormModal = document.getElementById('editOptionFormModal');

//     // Utility functions to show/hide modals manually (if not using Bootstrap)
//     function showModal(modal) {
//         modal.classList.remove('hidden');
//         document.body.classList.add('overflow-hidden');
//     }
//     function hideModal(modal) {
//         modal.classList.add('hidden');
//         document.body.classList.remove('overflow-hidden');
//     }

//     // Listen for "Add Option" button clicks (delegated)
//     document.addEventListener('click', function(e) {
//         if (e.target.closest('.add-option-btn')) {
//             const btn = e.target.closest('.add-option-btn');
//             const questionId = btn.getAttribute('data-question-id');
//             // Store questionId in a data attribute on the addOptionForm
//             addOptionFormModal.setAttribute('data-question-id', questionId);
//             showModal(addOptionModal);
//         }
//     });

//     // Cancel add option
//     document.getElementById('cancelAddOptionModal').addEventListener('click', function() {
//         hideModal(addOptionModal);
//     });

//     // Add Option Form submission
//     addOptionFormModal.addEventListener('submit', function(e) {
//         e.preventDefault();
//         const formData = new FormData(addOptionFormModal);
//         // Note: Ensure the input field name is "value" in your form.
//         const questionId = addOptionFormModal.getAttribute('data-question-id');

//         // Build the URL dynamically
//         const url = `{{ route('layanan.questions.options.store', ':questionId') }}`.replace(':questionId', questionId);

//         fetch(url, {
//             method: 'POST',
//             headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
//             body: formData,
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 // Find the corresponding question row by data-id
//                 const questionRow = document.querySelector(`tr[data-id="${questionId}"]`);
//                 // Assume the options column is the 4th <td> (adjust if necessary)
//                 const optionsCell = questionRow.querySelector('td:nth-child(4)');

//                 // Check if an unordered list exists; if not, create it
//                 let optionsList = optionsCell.querySelector('ul.list-unstyled');
//                 if (!optionsList) {
//                     optionsList = document.createElement('ul');
//                     optionsList.className = 'list-unstyled mb-0';
//                     optionsCell.innerHTML = ''; // Clear any "No options" text
//                     optionsCell.appendChild(optionsList);
//                 }
                
//                 // Create a new <li> element for the added option, using 'value'
//                 const li = document.createElement('li');
//                 li.setAttribute('data-option-id', data.option.id);
//                 li.innerHTML = `<span class="option-text">${data.option.value}</span>
//                                 <button class="btn btn-sm btn-warning edit-option-btn">Edit</button>
//                                 <button class="btn btn-sm btn-danger delete-option-btn">Delete</button>`;
                
//                 // Append the new option to the list
//                 optionsList.appendChild(li);
                
//                 // Clear the form and hide the modal dynamically without reloading the page
//                 addOptionFormModal.reset();
//                 hideModal(addOptionModal); // Assumes you have a hideModal() function
//             } else {
//                 alert('Failed to add option');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             alert('An unexpected error occurred.');
//         });
//     });

//     // Listen for "Edit Option" button clicks (delegated)
//     document.addEventListener('click', function(e) {
//     if (e.target.closest('.edit-option-btn')) {
//         const li = e.target.closest('li');
//         const optionId = li.getAttribute('data-option-id');
//         // Get the option text from the span
//         const currentTextElement = li.querySelector('.option-text');
//         const currentText = currentTextElement ? currentTextElement.textContent.trim() : '';
//         document.getElementById('editOptionId').value = optionId;
//         document.getElementById('editOptionValue').value = currentText;
//         showModal(editOptionModal);
//     }
// });


//     // Cancel edit option
//     document.getElementById('cancelEditOptionModal').addEventListener('click', function() {
//         hideModal(editOptionModal);
//     });

//     // Edit Option Form submission
//     editOptionFormModal.addEventListener('submit', function(e) {
//         e.preventDefault();
//         const formData = new FormData(editOptionFormModal);
//         const optionId = document.getElementById('editOptionId').value;

//         fetch(`{{ route('layanan.questions.options.update', ':optionId') }}`.replace(':optionId', optionId), {
//             method: 'POST',
//             headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
//             body: formData,
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 hideModal(editOptionModal);
//                 location.reload(); // Or update the option text on the page dynamically.
//             } else {
//                 alert('Failed to update option');
//             }
//         });
//     });

//     // Listen for "Delete Option" button clicks (delegated)
//     document.addEventListener('click', function(e) {
//         if (e.target.closest('.delete-option-btn')) {
//             const li = e.target.closest('li');
//             const optionId = li.getAttribute('data-option-id');
//             if (confirm('Are you sure you want to delete this option?')) {
//                 fetch(`{{ route('layanan.questions.options.destroy', ':optionId') }}`.replace(':optionId', optionId), {
//                     method: 'DELETE',
//                     headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
//                 })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         li.remove();
//                         // Optionally, if after deletion, the question has no options,
//                         // you might choose to remove the entire question row.
//                     } else {
//                         alert('Failed to delete option');
//                     }
//                 });
//             }
//         }
//     });

// });



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
    const formData = new FormData(this);
    
    fetch(`/questions/${questionId}/options`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ value: formData.get('text') })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const optionsList = document.querySelector(`tr[data-id="${questionId}"] ul`);
            const newOption = document.createElement('li');
            newOption.dataset.optionId = data.option.id;
            newOption.innerHTML = `
                <span class="option-text">• ${data.option.value}</span>
                <button class="btn btn-sm btn-warning edit-option-btn">Edit</button>
                <button class="btn btn-sm btn-danger delete-option-btn">Delete</button>
            `;
            
            if (optionsList) {
                optionsList.appendChild(newOption);
            } else {
                const td = document.querySelector(`tr[data-id="${questionId}"] td:nth-child(4)`);
                const ul = document.createElement('ul');
                ul.className = 'list-unstyled mb-0';
                ul.appendChild(newOption);
                td.innerHTML = '';
                td.appendChild(ul);
                td.appendChild(document.querySelector(`tr[data-id="${questionId}"] .add-option-btn`));
            }
            
            document.getElementById('addOptionModal').classList.add('hidden');
            this.reset();
        }
    });
});

// Edit Option Functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-option-btn')) {
        const optionItem = e.target.closest('li');
        const optionId = optionItem.dataset.optionId;
        const optionText = optionItem.querySelector('.option-text').textContent.replace('• ', '');
        
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
    const optionId = document.getElementById('editOptionId').value;
    const formData = new FormData(this);
    
    fetch(`/options/${optionId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ value: formData.get('text') })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const optionItem = document.querySelector(`li[data-option-id="${optionId}"]`);
            optionItem.querySelector('.option-text').textContent = `• ${data.option.value}`;
            document.getElementById('editOptionModal').classList.add('hidden');
            this.reset();
        }
    });
});

// Delete Option Functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-option-btn')) {
        const optionItem = e.target.closest('li');
        const optionId = optionItem.dataset.optionId;
        
        if (confirm('Are you sure you want to delete this option?')) {
            fetch(`/options/${optionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const optionsList = optionItem.parentElement;
                    optionItem.remove();
                    
                    // Remove entire list if no options left
                    if (optionsList.children.length === 0) {
                        const td = optionsList.parentElement;
                        td.innerHTML = '<span class="text-muted">No options</span>';
                        td.appendChild(document.querySelector(`tr[data-id="${td.parentElement.dataset.id}"] .add-option-btn`));
                    }
                }
            });
        }
    }
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
