@extends('layouts.main', ['title' => "Пользователь $user->login"])
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        {{ \Session::get('success') }}
                    </div>
                @endif

                <h2 class="mb-4">Профиль пользователя {{$user->login}}</h2>
                <p class="mb-1"><strong>Почта:</strong> {{$user->email}}</p>
                <p class="mb-1"><strong>Имя:</strong> {{$user->firstname}}</p>
                    <p class="mb-1"><strong>Фамилия:</strong> {{$user->lastname}}</p>
                <p class="mb-4"><strong>Номер телефона:</strong> {{$user->phone}}</p>

                    @can('seeResults', $user)
                        <div class="row mt-5">
                        <a href="{{route('profile.results', $user->id)}}" class="btn btn-success">Посмотреть историю пройденых тестов</a>
                        </div>
                    @endcan

{{--                    </div>--}}
                    @can('edit', $user)
                        <div class="row mt-3">
                <a href="{{route('profile.edit', $user->id)}}" class="btn btn-primary">Обновить данные</a>
                        </div>
                    @endcan
                    <hr>
                    @can('seeResults', $user)
                        <div class="row mt-3">
                            <a href="{{route('profile.show', $user->id)}}" class="btn btn-primary">Просмотреть созданные тесты</a>
                        </div>
                    @endcan
                @include('profile.partials.user_tests', ['header' => 'Скрытые тестирования'])
            </div>
        </div>
    </div>
@endsection
