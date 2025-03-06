@extends('layouts.company')
@section('content')
    <div class="my-4 mt-6 mr-8 flex items-center gap-2">
        <img src="{{ asset('assets/img/com.png') }}" width="150">
        <div>
            <h4 class="text-right text-xl font-bold">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h4>
            <p>{{ \Illuminate\Support\Facades\Auth::user()->company->description }}</p>
        </div>
    </div>

    <div class="ml-20 mr-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 rounded">
            <div class="flex flex-col text-right">
                <div class="card-box text-white px-10 h-40 rounded-lg flex flex-col justify-center items-start" style="background-color:rgb(0, 118, 223);">
                    <h3 class="text-xl font-bold mb-3 ">عدد الفرص المتاحة</h3>
                    <h4 class="text-xl">{{$internshipsCount}} فرصة</h4>
                </div>
            </div>
            <div class="flex flex-col text-right">
                <div class="card-box text-white px-10 h-40 rounded-lg flex flex-col justify-center items-start" style="background-color:rgb(25, 135, 84);">
                    <h3 class="text-xl font-bold mb-3 ">عدد الطلبات المستلمة</h3>
                    <h4 class="text-xl">{{$applicationCount}} طلب</h4>
                </div>
            </div>
            <div class="flex flex-col text-right">
                <div class="card-box text-white px-10 h-40 rounded-lg flex flex-col justify-center items-start" style="background-color:rgb(225, 60, 95);">
                    <h3 class="text-xl font-bold mb-3 ">طلبات قيد الانتظار</h3>
                    <h4 class="text-xl">{{$applicationPendingCount}} طلب</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="my-4 mt-6 mr-8 ml-8 mb-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
            <div class="card p-3 border border-e-black border-opacity-15 py-8 px-5 rounded mb-5 flex flex-col items-center justify-center" style="height: 400px;"> <!-- تحديد ارتفاع ثابت -->
                <h2 class="text-center text-2xl font-bold mb-2">نسبة الحضور والغياب</h2>
                <canvas class="p-3" id="attendanceChart" width="300" height="300"></canvas>
            </div>
            <div class="card p-3 border border-e-black border-opacity-15 py-8 px-5 rounded mb-5 flex flex-col items-center justify-center" style="height: 400px;"> <!-- إضافة flexbox -->
                <h2 class="text-center text-2xl font-bold mb-2 ">عدد الطلبة في كل فرصة تدريبية</h2>
                <canvas class="p-4" id="studentsChart" width="500" height="300"></canvas>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        var ctx1 = document.getElementById('studentsChart').getContext('2d');

        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.8)`;
        }

        var backgroundColors = @json($labels).map(() => getRandomColor());

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($studentCounts),
                    backgroundColor: backgroundColors
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });


    var ctx2 = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['حضور', 'غياب'],
                datasets: [{
                    data: [{{ $attendanceCounts['حاضر'] }}, {{ $attendanceCounts['غائب'] }}],
                    backgroundColor: ['green', 'red'],
                    borderWidth: 0,
                    radius: '65%',
                }]
            },
            options: {
                responsive: true,
                cutout: '60%'
            }
        });
    </script>

@endsection
