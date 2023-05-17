@extends('layouts.main', ['title' => "Изменить товар"])
@section('content')
    <div class="row mt-4 justify-content-center">
        <h3 class="text-center">Изменение тестирования</h3>
        <div class="col-md-6">
            <form method="POST" action="{{route('test.update', $test->id)}}" enctype="multipart/form-data">
                @csrf
                @include("test.partials.form", ['button' => 'Изменить тестирование'])
            </form>
        </div>
    </div>
@endsection
