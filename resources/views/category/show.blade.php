@extends('layouts.main', ['title' => "Категория: $category->title"])
@section('content')
    <div class="album py-5 bg-light">
        <h2 class="text-center">Категория: {{$category->title}}</h2>
        @auth()
            <div class="d-grid gap-2 mb-4 col-6 mx-auto">
                <a href="{{route('test.create')}}" class="btn btn-primary">Создать тестирование</a>
            </div>
        @endauth
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 d-flex align-items-stretch">
            @foreach($tests as $test)
                @include('partials.test_card')
            @endforeach
        </div>
        <div class="mt-3">
            {{ $tests->links() }}
        </div>
    </div>
@endsection
