@extends('layouts.main', ['title' => "Изменить тестирование"])
@section('content')
    <div class="row mt-4 justify-content-center">
        <h3 class="text-center">Управление вопросами</h3>
        <div class="col-md-6">
            <form method="POST" action="{{route('test.compose', $test->id)}}" enctype="multipart/form-data">
                @csrf
                @include("test.partials.construct_form", ['button' => 'Сохранить'])
            </form>
        </div>
    </div>
@endsection
