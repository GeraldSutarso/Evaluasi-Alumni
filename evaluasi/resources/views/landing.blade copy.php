@extends('layout.main')

@section('content')
<!-- Main container with overlay -->
<div class="relative min-h-screen">
    <!-- Background Banner -->
    <div class="absolute inset-0">
        <img src="{{ asset('img\Banner (1280x960).jpeg') }}" alt="Background Banner" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    
    <!-- Content Container -->
    <div class="relative z-10 container mx-auto px-4 py-8">
      <h1 class="text-4xl font-semibold font-mono text-center text-white mb-8">Survey Alumni</h1>
{{-- 
        <form action="{{ route('layanan.alumni.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Import Data</button>
        </form> --}}


        <!-- Cards Section -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 mb-16 mt-8">
            <!-- Tracer Study Card -->
            <div class="w-full md:w-1/3 bg-white bg-opacity-90 rounded-3xl shadow-lg p-8 transition-transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Tracer Study</h2>
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/analysis.png') }}" alt="Tracer Study Icon" class="w-16 h-16 mb-1">
                </div>
                <div class="flex justify-center">
                    <button 
                        onclick="showModal('tracerStudyModal')" 
                        class="mt-2 px-6 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232] transition-colors">
                        Mulai Survey
                    </button>
                </div>
            </div>

            <!-- Evaluasi Layanan Card -->
            <div class="w-full md:w-1/3 bg-white bg-opacity-90 rounded-3xl shadow-lg p-8 transition-transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Evaluasi Layanan</h2>
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/check-list.png') }}" alt="Evaluasi Layanan Icon" class="w-16 h-16 mb-1">
                </div>
                <div class="flex justify-center">
                    <button 
                        onclick="showModal('evaluasiLayananModal')" 
                        class="mt-2 px-6 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232] transition-colors">
                        Mulai Survey
                    </button>
                </div>
            </div>
        </div>

        <!-- Modals -->

        <!-- Tracer Study Modal -->
        <div id="tracerStudyModal" 
        class="hidden fixed inset-0 z-50 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-full max-w-2xl z-60">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Tracer Study</h2>
            <h4 class="text-2xl font-bold mb-4">Selamat datang di laman Tracer Study Akademi Komunitas Toyota Indonesia</h4>
            <p class="mb-4">Pada laman survey ini Anda akan mengisi beberapa pertanyaan seputar bidang keilmuan yang dipelajari di AKTI dan kesesuaiannya. Tracer study ini bertujuan untuk:</p>
            <ul class="list-disc list-inside mb-4">
                <li>Memetakan bidang kerja yang digeluti oleh alumni AKTI</li>
                <li>Mendapatkan masukan atau feedback dari alumni untuk penyusunan kurikulum AKTI</li>
                <li>Melengkapi data yang dibutuhkan untuk AKTI</li>
            </ul>
            <p class="mb-4">Jika Anda memiliki pertanyaan seputar tracer study ini, silakan hubungi tim kami di 
                <a href="mailto:muhammad.khamdani@toyota.co.id" class="text-blue-500 underline">muhammad.khamdani@toyota.co.id</a>
            </p>
            <p class="font-bold">Tim Tracer Study AKTI</p>
            <div class="flex justify-end space-x-4">
                <button 
                    onclick="hideModal('tracerStudyModal')" 
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Batal
                </button>
                <a href="{{ route('tracer.study') }}" 
                class="px-4 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232]">
                    Lanjutkan
                </a>
            </div>
        </div>
        </div>

        <!-- Evaluasi Layanan Modal -->
        <div id="evaluasiLayananModal" 
        class="hidden fixed inset-0 z-50 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-8 w-full max-w-3xl">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Evaluasi Layanan</h2>
                <h4 class="text-2xl font-bold mb-4">Survei Kepuasan Layanan Alumni</h4>
                <p class="mb-4">Dalam rangka meningkatkan kualitas pelayanan yang diberikan kepada alumni, kami akan melakukan survei kepuasan terhadap pelayanan yang ada di Akademi Komunitas Toyota Indonesia (AKTI). Survei ini bertujuan untuk memperoleh masukan dan umpan balik dari alumni guna meningkatkan kualitas pelayanan di AKTI.</p>
                <p class="mb-4">Partisipasi anda memberikan kontribusi yang berharga terhadap upaya kami dalam meningkatkan dan mengembangkan pelayanan yang lebih baik.</p>
                <div class="flex justify-end space-x-4">
                    <button 
                        onclick="hideModal('evaluasiLayananModal')" 
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Batal
                    </button>
                    <a href="{{ route('layanan-alumni') }}" 
                    class="px-4 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232]">
                        Lanjutkan
                    </a>
                </div>
            </div>
        </div>


        

        <!-- Chart Carousel Section -->
        <div class="relative z-10 container mx-auto px-4 py-8">
            <h1 class="text-4xl font-semibold font-mono text-center text-white mb-8">Evaluasi Layanan AKTI</h1>
        
            <!-- Carousel start -->
            <div class="mx-auto bg-gray-100 bg-opacity-80 shadow-lg rounded-lg p-6 w-[90%] h-[600px] relative overflow-hidden">
                <h2 class="text-2xl font-semibold text-gray-800 text-center mb-5">Isi Survey</h2>
            
                <div class="swiper-container h-90">
                    <div class="swiper-wrapper">
                        @foreach ($chartData->chunk(1) as $chunk)
                        <div class="swiper-slide flex flex-col justify-between  gap-y-2">
                            <!-- Row for Questions -->
                            <div class="flex flex-wrap justify-around items-center w-full">
                                @foreach ($chunk as $chart)
                                <div class="w-[800px] h-[100px] md:w-[600px] md:h-[100px] sm:w-[300px] sm:h-[100px] text-center text-md font-sans font-semibold text-gray-800">
                                    {{ $chart['question'] }}
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Row for Charts -->
                            <div class="flex flex-wrap justify-around items-center w-full">
                                @foreach ($chunk as $index => $chart)
                                <div class="w-[800px] h-[300px] md:w-[600px] md:h-[300px] sm:w-[300px] sm:h-[300px] flex items-center justify-center bg-gray-100 rounded-lg p-4 shadow-md">
                                    <canvas id="chart{{ $index }}" class="w-full h-full"></canvas>
                                </div>
                                @endforeach
                            </div>
                            
                        </div>
                        @endforeach
                    </div>
                </div>
                <button class="swiper-prev absolute top-1/2 left-[10px] transform -translate-y-1/2 text-xl px-4 py-2 bg-red-900 text-white rounded-full hover:bg-red-950 z-20">&lt;</button>
                <button class="swiper-next absolute top-1/2 right-[10px] transform -translate-y-1/2 text-xl px-4 py-2 bg-red-900 text-white rounded-full hover:bg-red-950 z-20">&gt;</button>
                <!-- Pagination -->
                <div class="swiper-pagination mt-4"></div>
            </div>
            <!-- Navigation Buttons Outside the Carousel -->
        </div>
    </div>
</div>      
<script>
// Show modal
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    const body = document.querySelector('body');

    // Show the modal
    modal.classList.remove('hidden');

    // Disable background scrolling
    body.classList.add('overflow-hidden');
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    const body = document.querySelector('body');

    // Hide the modal
    modal.classList.add('hidden');

    // Enable background scrolling
    body.classList.remove('overflow-hidden');
}

document.addEventListener('DOMContentLoaded', function () {

    // Initialize Swiper
    const swiper = new Swiper('.swiper-container', {
        loop: true, // Loop back to the first slide
        slidesPerView: 1, // Show 1 slide (with 3 charts) at a time
        autoplay: {
            delay: 10000, // Auto-slide every 10 seconds
            disableOnInteraction: false, // Continue autoplay after manual navigation
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true, // Allow pagination dots to be clickable
        },
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
    });

    // Render charts
    const chartData = @json($chartData);

    chartData.forEach((chart, index) => {
        const ctx = document.getElementById(`chart${index}`).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chart.labels,
                datasets: [{
                    label: 'Jumlah Responden',
                    data: chart.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Skor Respons',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah',
                        },
                    },
                },
            },
        });
    });
});
</script>
@endsection