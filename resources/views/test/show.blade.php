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
                <h2>Прошло: {{$test->price ?? 0}} пользователей.</h2>
                <p class="lead">Категория: <a
                        href="{{route('category.show', $test->category->id)}}">{{$test->category->title}}</a></p>
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
                <div class="d-inline">
                    <a class="btn btn-primary" href="{{route('test.edit', $test->id)}}" role="button">Изменить информацию</a>
                    <a class="btn btn-primary" href="{{route('test.construct', $test->id)}}" role="button">Изменить вопросы</a>
                    <form class="mt-2" action="{{route('test.remove', $test->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit">Удалить</button>
                    </form>
                </div>
                @endcan
            </div>
            <hr>
{{--            <h3 class="mt-4">Рекомендации:</h3>--}}
{{--            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 d-flex align-items-stretch">--}}
{{--                @foreach($recommendations as $recommendation)--}}
{{--                    <div class="col">--}}
{{--                        <div class="card shadow-sm">--}}
{{--                            <img src="{{ asset("storage/$recommendation->cover") }}" alt="" width="100%"--}}
{{--                                 style="max-height: 250px; object-fit: contain;">--}}

{{--                            <div class="card-body">--}}
{{--                                <h3 class="card-title"><a--}}
{{--                                        href="{{route('product.show', $recommendation->id)}}">{{$recommendation->title}}</a></h3>--}}
{{--                                <p class="card-text"><a--}}
{{--                                        href="{{route('category.show', $recommendation->category->id)}}">{{$recommendation->category->title}}</a>--}}
{{--                                </p>--}}
{{--                                <p class="card-text">{{$recommendation->short_description}}</p>--}}
{{--                                <div class="d-flex justify-content-between align-items-center">--}}
{{--                                    <h5 class="text">{{$recommendation->price}} руб.</h5>--}}
{{--                                    <p class="card-text"><a--}}
{{--                                            href="{{route('profile.show', $recommendation->user->id)}}">{{$recommendation->user->login}}</a>--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
