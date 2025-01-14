@extends('layout.main')

@section('content')
<div class="container mx-auto mt-4">
        <h2 class="mb-4 text-2xl font-bold text-gray-800 font-sans">Evaluasi Layanan AKTI</h2>
        <!-- Rating Scale Illustration -->
    <div class="block w-full p-4 mb-6 border-5 border-solid border-blue rounded-lg bg-gray-50 shadow-lg">
        <h5 class="mb-3 text-lg font-semibold text-center">Scaling Angka</h5>
        <div class="relative flex items-center h-8 bg-gradient-to-r from-red-400 via-yellow-400 to-green-400 rounded-md">
            <span class="absolute left-0 pl-2 text-white font-semibold">1 - Tidak Setuju</span>
            <span class="absolute left-1/4 text-white font-semibold">2 - Kurang Setuju</span>
            <span class="absolute left-1/2 text-white font-semibold">3 - Cukup Setuju</span>
            <span class="absolute right-0 pr-2 text-white font-semibold">4 - Sangat Setuju</span>
        </div>
        <p class="mt-3 text-sm text-center text-gray-600">Skor yang lebih tinggi menunjukkan evaluasi yang lebih baik. Harap pilih penilaian Anda dengan hati-hati.</p>
    </div>

    <!-- Multi-Step Form -->
    <form id="layananForm" action="{{ route('layanan.submit') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Steps Container -->
        <div id="stepsContainer">
            @php $stepIndex = 0; @endphp
            @foreach ($groupedQuestions as $type => $questions)
                <div class="step space-y-6" data-step-index="{{ $stepIndex }}" style="display: {{ $stepIndex === 0 ? 'block' : 'none' }};">
                    <h3 class="text-xl font-semibold text-gray-700">{{ $type }}</h3>
                    @php $questionNumber = 1; @endphp
                    @foreach ($questions as $question)
                        <div class="mb-4">
                            <label class="block mb-2 text-lg font-medium text-gray-800">
                                {{ $questionNumber }}. {{ $question->text }}
                            </label>
                            @if ($question->type === 'Feedback')
                                <!-- Textarea for feedback questions -->
                                <textarea name="responses[{{ $question->id }}]" 
                                          class="block w-full p-3 border border-solid border-black-700 rounded-lg focus:ring focus:ring-blue-300 shadow-lg" 
                                          rows="3" 
                                          required></textarea>
                            @elseif ($question->type === 'User' || $question->type === 'Survey')
                                <!-- Render options dynamically if they exist -->
                                @if (isset($options[$question->id]) && $options[$question->id]->isNotEmpty())
                                    <div class="space-y-2">
                                        @foreach ($options[$question->id] as $option)
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" 
                                                       name="responses[{{ $question->id }}]" 
                                                       value="{{ $option->value }}" 
                                                       class="w-4 h-4 text-blue-500 border-black-700 focus:ring-blue-500 shadow-lg" 
                                                       required>
                                                <span class="text-gray-700">{{ $option->value }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Fallback to text input for missing options -->
                                    <input type="text" 
                                           name="responses[{{ $question->id }}]" 
                                           class="block w-full p-4 border-1 border-solid border-black rounded-lg focus:border-blue-600 focus:ring focus:ring-blue-300 shadow-lg bg-white-200"
                                           required>
                                @endif
                            @else
                                <!-- Fallback to text input for other types -->
                                <input type="text" 
                                       name="responses[{{ $question->id }}]" 
                                       class="block w-full p-3 border-3 border-solid border-black rounded-lg focus:ring focus:ring-blue-300 shadow-lg" 
                                       required>
                            @endif
                        </div>
                        @php $questionNumber++; @endphp
                    @endforeach
                </div>
                @php $stepIndex++; @endphp
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-6 flex justify-between">
            <button type="button" id="prevButton" 
                    class="hidden px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Sebelumnya
            </button>
            <button type="button" id="nextButton" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Lanjut
            </button>
            <button type="submit" id="submitButton" 
                    class="hidden px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                Kumpul
            </button>
        </div>
    </form>
</div>


<script>
    let currentStep = 0; // Initialize step index
    const steps = document.querySelectorAll('.step');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const submitButton = document.getElementById('submitButton');
    
    // Function to navigate between steps
    function navigateSteps(direction) {
        if (direction === 1 && !validateCurrentStep()) {
            alert('Please answer all required questions before proceeding.');
            return;
        }

        // Hide current step
        steps[currentStep].style.display = 'none';

        // Update the current step index
        currentStep += direction;

        // Ensure the index stays within bounds
        currentStep = Math.max(0, Math.min(currentStep, steps.length - 1));

        // Show the new step
        steps[currentStep].style.display = 'block';

        // Update button visibility based on the current step
        updateButtonVisibility();
    }

    // Function to validate the current step
    function validateCurrentStep() {
        const currentStepInputs = steps[currentStep].querySelectorAll('input[required], textarea[required]');
        for (const input of currentStepInputs) {
            if (input.type === 'radio') {
                const group = document.querySelectorAll(`input[name="${input.name}"]`);
                if (!Array.from(group).some(radio => radio.checked)) {
                    return false;
                }
            } else if (!input.value.trim()) {
                return false;
            }
        }
        return true;
    }

    // Function to update button visibility based on the current step
    function updateButtonVisibility() {
        prevButton.style.display = currentStep > 0 ? 'inline-block' : 'none'; // Show Back if not on the first step
        nextButton.style.display = currentStep < steps.length - 1 ? 'inline-block' : 'none'; // Show Next if not on the last step
        submitButton.style.display = currentStep === steps.length - 1 ? 'inline-block' : 'none'; // Show Submit only on the last step
    }

    // Attach navigation handlers
    prevButton.addEventListener('click', function () {
        navigateSteps(-1);
    });

    nextButton.addEventListener('click', function () {
        navigateSteps(1);
    });

    // Initialize button visibility
    updateButtonVisibility();
</script>
@endsection
