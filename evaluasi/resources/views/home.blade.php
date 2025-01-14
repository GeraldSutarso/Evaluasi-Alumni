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

        <!-- Chart Carousel Section -->
        <div class="swiper-container">
          <div class="swiper-wrapper">
              @foreach ($chartData as $index => $chart)
              <div class="swiper-slide">
                  <div class="bg-white bg-opacity-90 rounded-lg p-4 h-64">
                      <h3 class="text-lg font-semibold text-gray-800 text-center mb-2">{{ $chart['question'] }}</h3>
                      <canvas id="chart{{ $index }}"></canvas>
                  </div>
              </div>
              @endforeach
          </div>
          <!-- Carousel Navigation -->
          <div class="flex justify-center mt-4 gap-2">
              @foreach ($chartData as $index => $chart)
              <span class="w-3 h-3 bg-white rounded-full cursor-pointer"></span>
              @endforeach
          </div>
      </div>
      
    </div>
</div>
<script>
new Swiper('.swiper-container', {
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

document.addEventListener('DOMContentLoaded', function () {
  const chartData = @json($chartData);

  chartData.forEach((chart, index) => {
      const ctx = document.getElementById(`chart${index}`).getContext('2d');
      new Chart(ctx, {
          type: 'bar', // You can use 'bar', 'pie', 'doughnut', etc.
          data: {
              labels: chart.labels,
              datasets: [{
                  label: 'Responses',
                  data: chart.data,
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1,
              }],
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                  y: {
                      beginAtZero: true,
                  },
              },
          },
      });
  });
});
</script>
@endsection