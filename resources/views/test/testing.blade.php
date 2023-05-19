@extends('layouts.main', ['title' => "Прохождение тестирования"])
@section('content')
    <div class="row mt-4 justify-content-center">
        <h3 class="text-center">Прохождение тестирования</h3>
        <p class="text-center">{{$test->short_description}}</p>
        <div class="col-md-6">
            <form method="POST" action="{{route('test.calc_results', $test->id)}}" enctype="multipart/form-data">
                @csrf
                @include("test.partials.testing_form", ['button' => 'Закончить тестирование'])
            </form>
        </div>
    </div>
@endsection
