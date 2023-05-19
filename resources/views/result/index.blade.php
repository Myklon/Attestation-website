@extends('layouts.main')
@section('content')
    <div class="album py-5 bg-light">
        <h2 class="text-center mb-4">Результат тестирования пользователя {{$result->user->login}}</h2>
        @php
            $createdAt = \Carbon\Carbon::parse($result->created_at);
        @endphp
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="mb-0">Тест: {{$result->test->title}}</h3>
                                    <p>📅 {{$createdAt->format('Y-m-d')}} | ⌚ {{$createdAt->format('H:i')}}</p>
                                </div>
                                <div class="mb-4">
                                    <p><strong>Всего вопросов:</strong> {{$result->count_answers}}</p>
                                    <p><strong>✅ Правильных ответов:</strong> {{$result->right_answers}}</p>
                                    <p><strong>❌ Неправильных ответов:</strong> {{$result->count_answers - $result->right_answers}}</p>
                                    <h4><strong>Результат:</strong> {{$result->score}}%</h4>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{($result->right_answers / $result->count_answers) * 100}}%" aria-valuenow="{{$result->right_answers}}" aria-valuemin="0" aria-valuemax="{{$result->count_answers}}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const totalQuestions = {{$result->count_answers}};
        const correctAnswers = {{$result->right_answers}};
        const incorrectAnswers = totalQuestions - correctAnswers;

        const chart = new CanvasJS.Chart("chartContainer", {
            theme: "light1",
            animationEnabled: true,
            data: [
                {
                    type: "doughnut",
                    startAngle: 60,
                    indexLabelFontSize: 18,
                    indexLabel: "{label}: {y}",
                    toolTipContent: "{label}: {y} - #percent%",
                    dataPoints: [
                        { y: correctAnswers, label: "Правильных ответов" },
                        { y: incorrectAnswers, label: "Неправильных ответов" },
                    ]
                }
            ]
        });

        chart.render();
    });
</script>
@endsection
