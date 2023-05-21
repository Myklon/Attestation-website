@extends('layouts.main', ['title' => "История прохождений теста $test->title"])
@section('content')

    <div class="container mt-5">
        <h2 class="mb-4">История прохождений теста <a href="{{route('test.show',$test->id)}}">{{$test->title}}</a></h2>

        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th>Логин пользователя</th>
                <th>Дата прохождения</th>
                <th>Время прохождения</th>
                <th>Оценка</th>
                <th>Просмотреть</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
                <tr>
                    <td><a href="{{route('profile.show',$result->user_id)}}">{{$result->user->login}}</a></td>
                    <td>{{ $result->created_at->format('d.m.Y') }}</td>
                    <td>{{ $result->created_at->format('h.i') }}</td>
                    <td><strong>{{ $result->score }}%</strong></td>
                    <td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('result.index', $result->id) }}">👁️️</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
