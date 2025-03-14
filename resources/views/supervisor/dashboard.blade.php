@extends('layouts.supervisor')

@section('content')

    <div class="my-4 mt-6 mr-8 ml-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 border border-e-black border-opacity-15 py-8 px-5 rounded">
            <div class="card-box text-black p-6 rounded-lg" style="background-color: rgba(54, 255, 146, 0.27);">
                <div class="flex flex-col  justify-center text-right pt-4">
                    <i class="fas fa-users text-1xl text-blue-600 mb-2"></i>
                    <h2 class="text-2xl font-bold">{{$studentsCount}}</h2>
                    <h5 class="text-lg text-gray-700">إجمالي عدد الطلاب</h5>
                </div>
            </div>
            <div class="card-box text-black p-6 rounded-lg" style="background-color: #F1EEFF;">
                <div class="flex flex-col  justify-center text-right pt-4">
                    <i class="fas fa-user-graduate text-1xl text-blue-600 mb-2"></i>
                    <h2 class="text-2xl font-bold">{{$studentsStartedCount}}</h2>
                    <h5 class="text-lg text-gray-700">إجمالي الطلاب الذين بدأوا التدريب</h5>
                </div>
            </div>
            <div class="card-box text-black p-6 rounded-lg" style="background-color: #FFF2DC;">
                <div class="flex flex-col  justify-center text-right pt-4">
                    <i class="fas fa-tasks text-1xl text-blue-600 mb-2"></i>
                    <h2 class="text-2xl font-bold">{{$weeksCount}}</h2>
                    <h5 class="text-lg text-gray-700">تقارير التقدم</h5>
                </div>
            </div>
            <div class="card-box text-black p-6 rounded-lg" style="background-color: #FFEEF1;">
                <div class="flex flex-col  justify-center text-right pt-4">
                    <i class="fas fa-file-alt text-1xl text-blue-600 mb-2"></i>
                    <h2 class="text-2xl font-bold">{{$trainingBooks}}</h2>
                    <h5 class="text-lg text-gray-700">التقارير المكتملة</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="my-4 mt-6 mr-8 ml-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
            <div class="card p-3 text-center border border-e-black border-opacity-15 py-8 px-5 rounded mb-5">
                <h5>نسبة الطلاب حسب حالة التدريب</h5>
                <div class="flex justify-center">
                    <canvas id="progressChart" style="max-width: 250px; max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="card p-3 border border-e-black border-opacity-15 py-8 px-5 rounded mb-5">
                <h5>متوسط التقييمات الأسبوعية للطلاب</h5>
                <div class="flex justify-center">
                    <canvas id="chart" style="width: 500px; height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($weeks),
                datasets: [{
                    label: 'معدل التقييمات الأسبوعية',
                    data: @json($average),
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'الأسبوع'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'متوسط التقييمات'
                        }
                    }
                }
            }
        });


        var completedCount = @json($completedCount);
        var startedCount = @json($startedCount);
        var notStartedCount = @json($notStartedCount);

        var progressCtx = document.getElementById('progressChart').getContext('2d');
        new Chart(progressCtx, {
            type: 'doughnut',
            data: {
                labels: ['مكتمل', 'بدأ', 'لم يبدأ'],
                datasets: [{
                    data: [completedCount, startedCount, notStartedCount],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: false,
            }
        });
    </script>
@endsection
