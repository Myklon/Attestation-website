@extends('layouts.main', ['title' => "Тест: $test->title"])
@section('content')
    <div class="container mt-5">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                {{ \Session::get('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <h1>{{$test->title}}</h1>
                <h2>Прохождений теста: {{$test->results->count() ?? 0}}.</h2>
                <p class="lead">Категория: <a href="{{route('category.show', $test->category->id)}}">{{$test->category->title}}</a></p>
                <p>Тест создан: <strong>{{$test->created_at->format('d-m-Y H:i')}}</strong></p>
                @if($test->created_at != $test->updated_at)
                    <p>Тест изменён: <strong>{{$test->updated_at->format('d-m-Y H:i')}}</strong></p>
                @endif

                <img src="{{ asset("storage/$test->cover") }}" class="img-fluid my-3" width="100%"
                     style="max-height: 340px; object-fit: contain;">
                <article class="main px-3 mt-3">
                <p class="lead">{{$test->short_description}}</p>
                <p class="description">{{$test->description}}</p>
                </article>
            </div>
            <div class="col-md-4">
                <h2>Создатель: <a href="{{route('profile.show', $test->user->id)}}">{{$test->user->login}}</a></h2>
                @can('edit', $test)
                <div class="d-inline m-3">
                    <h3>Администрирование теста</h3>
                    <div class="row mt-2">
                        <a class="btn btn-warning" href="{{route('test.results', $test->id)}}" role="button">Посмотреть историю прохождений</a>
                    </div>
                    <div class="row mt-2">
                    <a class="btn btn-primary" href="{{route('test.edit', $test->id)}}" role="button">Изменить информацию</a>
                    </div>
                    <div class="row mt-2">
                    <a class="btn btn-primary" href="{{route('test.construct', $test->id)}}" role="button">Управление вопросами</a>
                    </div>
                    <form class="mt-2" action="{{route('test.remove', $test->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <div class="row">
                        <button class="btn btn-danger" type="submit">Удалить</button>
                        </div>
                    </form>
                </div>
                    <hr>
                @endcan
                    <div class="row m3">
                        <h3>Действия</h3>
                        <a class="btn btn-success" href="{{route('test.testing', $test->id)}}" role="button">Пройти тестирование</a>
                    </div>
            </div>
            <hr>
        </div>
    </div>
@endsection
