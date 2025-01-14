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
        <!-- Cards Section -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 mb-16 mt-8">
            <!-- Tracer Study Card -->
            <div class="w-full md:w-1/3 bg-white bg-opacity-90 rounded-3xl shadow-lg p-8 transition-transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Tracer Study</h2>
                <div class="flex justify-center">
                    <a href="/tracer-study" class="mt-4 px-6 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232] transition-colors">
                        Mulai Survey
                    </a>
                </div>
            </div>

            <!-- Evaluasi Layanan Card -->
            <div class="w-full md:w-1/3 bg-white bg-opacity-90 rounded-3xl shadow-lg p-8 transition-transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Evaluasi Layanan</h2>
                <div class="flex justify-center">
                    <a href="{{ route('layanan-alumni') }}" class="mt-4 px-6 py-2 bg-[#992424] text-white rounded-lg hover:bg-[#b93232] transition-colors">
                        Mulai Survey
                    </a>
                </div>
            </div>
        </div>

        <div class="relative z-10 container mx-auto px-4 py-8">
            <h1 class="text-4xl font-semibold font-mono text-center text-white mb-8">Survey Layanan AKTI</h1>
        
            <!-- Carousel Section -->
            <div class="mx-auto bg-gray-100 bg-opacity-80 shadow-lg rounded-lg p-6 w-[90%] h-[600px]">
                <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">Survey Results</h2>
                
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($chartData->chunk(3) as $chunk)
                        <div class="swiper-slide flex justify-around items-center">
                            @foreach ($chunk as $index => $chart)
                            <div class="w-[300px] h-[300px] bg-gray-100 rounded-lg p-4 shadow-md">
                                <h3 class="text-sm font-sans font-semibold text-gray-800 text-center mb-2">{{ $chart['question'] }}</h3>
                                <canvas id="chart{{ $index }}"></canvas>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
        
                    <!-- Navigation -->
                    <div class="flex justify-between items-center mt-4">
                        <button class="swiper-prev text-xl px-4 py-2 bg-gray-800 text-white rounded-full hover:bg-gray-700">&lt;</button>
                        <button class="swiper-next text-xl px-4 py-2 bg-gray-800 text-white rounded-full hover:bg-gray-700">&gt;</button>
                    </div>
        
                    <!-- Pagination -->
                    <div class="swiper-pagination mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiper-container', {
        loop: false,
        slidesPerView: 1, // Show one slide (with 3 charts) at a time
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
    });

    const chartData = @json($chartData);

    chartData.forEach((chart, index) => {
        const ctx = document.getElementById(`chart${index}`).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chart.labels,
                datasets: [{
                    label: 'Number of Participants',
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
                            text: 'Response Value',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count',
                        },
                    },
                },
            },
        });
    });
});

</script>
@endsection