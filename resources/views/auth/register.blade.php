@extends('layouts.main', ['title' => 'Регистрация'])
@section('content')
    <div class="row mt-4 justify-content-center">
        <h2 class="text-center">Регистрация</h2>
        <div class="col-md-6">
            <form action="{{route('register')}}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label for="login">Имя пользователя:</label>
                    <input type="text" name="login" class="form-control" id="login" placeholder="Введите имя пользователя" value="{{old('login')}}">
                    @error('login')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Введите email" value="{{old('email')}}">
                    @error('email')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="firstname">Имя:</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Введите имя" value="{{old('firstname')}}">
                    @error('firstname')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="lastname">Фамилия:</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Введите фамилию" value="{{old('lastname')}}">
                    @error('lastname')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="phone">Номер телефона:</label>
                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Введите свой номер телефона" value="">
                    @error('phone')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password">Пароль:</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Введите пароль">
                    @error('password')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password">Повторите пароль:</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="Повторите пароль">
                    @error('password_confirmation')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>
        </div>
    </div>
@endsection
