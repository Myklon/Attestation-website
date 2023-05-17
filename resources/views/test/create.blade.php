@extends('layouts.main', ['title' => "Создание теста"])
@section('content')
    <div class="row mt-4 justify-content-center">
        <h3 class="text-center">Создание тестирования</h3>
        <div class="col-md-6">
            <form method="POST" action="{{route('test.store')}}" enctype="multipart/form-data">
                @csrf
                @include("test.partials.form", ['button' => 'Добавить тестирование'])
            </form>
        </div>
    </div>
@endsection
