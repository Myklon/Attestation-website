@extends('layouts.main', ['title' => "История пользователя $user->login"])
@section('content')

    <div class="container mt-5">
        <h2 class="mb-4">История пользователя {{$user->login}}</h2>

        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th>Название тестирования</th>
                <th>Дата прохождения</th>
                <th>Время прохождения</th>
                <th>Оценка</th>
                <th>Просмотреть</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
                <tr>
                    <td><a href="{{route('test.show',$result->test->id)}}">{{$result->test->title}}</a></td>
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
