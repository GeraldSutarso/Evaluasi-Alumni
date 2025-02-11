@extends('layout.main')

@section('content')
<style>
    .tab-button {
        padding: 10px 20px;
        background-color: #7b1c1c; /* Default red-900 */
        color: white;
        border-radius: 5px;
        transition: background 0.2s ease-in-out;
        margin: 0 5px;
    }

    .tab-button:hover {
        background-color: #5a1313; /* Hover effect */
    }

    .active-tab {
        background-color: #b91c1c; /* Brighter red to indicate active tab */
        font-weight: bold;
    }
</style>
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

        {{-- <form action="{{ route('tracer.study.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Import Data</button>
        </form> --}}


                <!-- Cards Section -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 mb-16 mt-8">
            <!-- Tracer Study Card -->
            <div class="w-full sm:w-[300px] md:w-[300px] lg:w-[300px] h-[275px] bg-white bg-opacity-90 rounded-3xl shadow-lg p-8 transition-transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Tracer Study</h2>
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/analysis.png') }}" alt="Tracer Study Icon" class="w-16 h-16 mb-1">
                </div>
                <div class="flex justify-center">
                    <button 
                        onclick="showModal('tracerStudyModal')" 
                        class="mt-2 px-6 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232] transition-colors">
                        Cek Survey
                    </button>
                </div>
            </div>

            <!-- Evaluasi Layanan Card -->
            <div class="w-full sm:w-[300px] md:w-[300px] lg:w-[300px] h-[275px] bg-white bg-opacity-90 rounded-3xl shadow-lg p-8 transition-transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Evaluasi Layanan</h2>
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/check-list.png') }}" alt="Evaluasi Layanan Icon" class="w-16 h-16 mb-1">
                </div>
                <div class="flex justify-center">
                    <button 
                        onclick="showModal('evaluasiLayananModal')" 
                        class="mt-2 px-6 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232] transition-colors">
                        Cek Survey
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
                <a href="{{ route('tracer.questions.index') }}" 
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
                    <a href="{{ route('layanan.questions.index') }}" 
                    class="px-4 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232]">
                        Lanjutkan
                    </a>
                </div>
            </div>
        </div>


        

    <!-- Chart Carousel Section -->
    <div class="relative z-10 container mx-auto px-4 py-8">
        <h1 class="text-4xl font-semibold font-mono text-center text-white mb-8">Hasil Survey Oleh Alumni</h1>
    
        <!-- Carousel start -->
        <div class="mx-auto bg-gray-100 bg-opacity-80 shadow-lg rounded-lg p-6 w-full h-[700px] relative overflow-hidden">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-2">Pilih Survey</h2>
    
            <!-- Tabs for LayananAlumni and TracerStudy -->
            <div class="flex justify-center mb-4">
                <button id="layananAlumniTab" class="tab-button active-tab">Layanan Alumni</button>
                <button id="tracerStudyTab" class="tab-button">Tracer Study</button>
            </div>
    
            <!-- LayananAlumni Carousel -->
            <div id="layananAlumniCarousel" class="swiper-container h-90">
                <div class="swiper-wrapper">
                    @foreach ($chartData['layananAlumni']->chunk(1) as $chunk)
                    <div class="swiper-slide flex flex-col justify-between px-4">
                        <!-- Row for Questions -->
                        <div class="flex flex-wrap justify-around items-center w-full mb-6">
                            @foreach ($chunk as $chart)
                            <div class="w-[800px] h-[100px] md:w-[600px] md:h-[100px] sm:w-[300px] sm:h-[100px] text-center text-md font-sans font-semibold text-gray-800 mb-8">
                                {{ $chart['question'] }}
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Row for Charts -->
                        <div class="flex flex-wrap justify-around items-center w-full mb-8">
                            @foreach ($chunk as $index => $chart)
                            <div class="w-[800px] h-[300px] md:w-[600px] md:h-[300px] sm:w-[300px] sm:h-[300px] flex items-center justify-center bg-gray-100 rounded-lg p-4 shadow-md mb-8">
                                <canvas id="layananAlumniChart{{ $index }}" class="w-full h-full"></canvas>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="swiper-prev absolute top-1/2 left-[10px] transform -translate-y-1/2 text-xl px-4 py-2 bg-red-900 text-white rounded-full hover:bg-red-950 z-20">&lt;</button>
                <button class="swiper-next absolute top-1/2 right-[10px] transform -translate-y-1/2 text-xl px-4 py-2 bg-red-900 text-white rounded-full hover:bg-red-950 z-20">&gt;</button>
                <!-- Pagination -->
                <div class="swiper-pagination mt-4 mb-2"></div>
            </div>
    
            <!-- TracerStudy Carousel -->
            <div id="tracerStudyCarousel" class="swiper-container h-90 hidden">
                <div class="swiper-wrapper">
                    @foreach ($chartData['tracerStudy']->chunk(1) as $chunk)
                    <div class="swiper-slide flex flex-col justify-between px-4">
                        <!-- Row for Questions -->
                        <div class="flex flex-wrap justify-around items-center w-full mb-8">
                            @foreach ($chunk as $chart)
                            <div class="w-[800px] h-[100px] md:w-[600px] md:h-[100px] sm:w-[300px] sm:h-[100px] text-center text-md font-sans font-semibold text-gray-800 mb-8">
                                {{ $chart['question'] }}
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Row for Charts -->
                        <div class="flex flex-wrap justify-around items-center w-full mb-8">
                            @foreach ($chunk as $index => $chart)
                            <div class="w-[800px] h-[300px] md:w-[600px] md:h-[300px] sm:w-[300px] sm:h-[300px] flex items-center justify-center bg-gray-100 rounded-lg p-4 shadow-md mb-8">
                                <canvas id="tracerStudyChart{{ $index }}" class="w-full h-full"></canvas>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="swiper-prev absolute top-1/2 left-[10px] transform -translate-y-1/2 text-xl px-4 py-2 bg-red-900 text-white rounded-full hover:bg-red-950 z-20">&lt;</button>
                <button class="swiper-next absolute top-1/2 right-[10px] transform -translate-y-1/2 text-xl px-4 py-2 bg-red-900 text-white rounded-full hover:bg-red-950 z-20">&gt;</button>
                <!-- Pagination -->
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>
    </div>
    <!-- Tracer Study Pie Chart Section -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-semibold font-mono text-center text-white mb-8">Tracing Alumni</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($chartData['tracerPie'] as $index => $chart)
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 text-center mb-4">{{ $chart['question'] }}</h2>
                <div class="w-full h-64">
                    <canvas id="tracerPieChart{{ $index }}"></canvas>
                </div>
            </div>
            @endforeach
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
    // Initialize Swiper for LayananAlumni
    const layananAlumniSwiper = new Swiper('#layananAlumniCarousel', {
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
    });

    // Initialize Swiper for TracerStudy
    const tracerStudySwiper = new Swiper('#tracerStudyCarousel', {
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
    });

    // Render LayananAlumni charts
    const layananAlumniChartData = @json($chartData['layananAlumni']);
    layananAlumniChartData.forEach((chart, index) => {
        const ctx = document.getElementById(`layananAlumniChart${index}`).getContext('2d');
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

    // Render TracerStudy charts
    const tracerStudyChartData = @json($chartData['tracerStudy']);
    tracerStudyChartData.forEach((chart, index) => {
        const ctx = document.getElementById(`tracerStudyChart${index}`).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chart.labels,
                datasets: [{
                    label: 'Jumlah Responden',
                    data: chart.data,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
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

    // Tab switching logic
    document.getElementById('layananAlumniTab').addEventListener('click', function() {
        document.getElementById("layananAlumniCarousel").classList.remove("hidden");
        document.getElementById("tracerStudyCarousel").classList.add("hidden");

        // Add active class to selected tab, remove from other
        document.getElementById("layananAlumniTab").classList.add("active-tab");
        document.getElementById("tracerStudyTab").classList.remove("active-tab");
    });

    document.getElementById('tracerStudyTab').addEventListener('click', function() {
        document.getElementById("tracerStudyCarousel").classList.remove("hidden");
        document.getElementById("layananAlumniCarousel").classList.add("hidden");

        // Add active class to selected tab, remove from other
        document.getElementById("tracerStudyTab").classList.add("active-tab");
        document.getElementById("layananAlumniTab").classList.remove("active-tab");
    });
});
document.addEventListener("DOMContentLoaded", function () {
        const tracerPieChartData = @json($chartData['tracerPie']);

        tracerPieChartData.forEach((chart, index) => {
            const ctx = document.getElementById(`tracerPieChart${index}`).getContext("2d");
            new Chart(ctx, {
                type: "pie",
                data: {
                    labels: chart.labels,
                    datasets: [{
                        data: chart.data,
                        backgroundColor: [
                            "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            });
        });
    });
</script>
@endsection