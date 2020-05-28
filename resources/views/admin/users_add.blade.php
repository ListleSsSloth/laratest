@extends('layouts.app')

@section('content')
<form action="" method="POST">
@csrf
<br>
    <div class="container">
        <div class="card" style="width: 50%; margin: 0 auto">
            <div class="card-body">
                <h5 class="card-title">Пользователь</h5>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" class="form-control" name="login" id="login" aria-describedby="emailHelp" placeholder="Login" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="ldap" name="ldap">
                    <label class="form-check-label" for="ldap">Аунтификация LDAP</label>
                </div>
            </div>
        </div>
        <br>
        <div class="card" style="width: 50%; margin: 0 auto;">
            <div class="card-body">
                <h5 class="card-title">Доступные роли</h5>
                @foreach ($roles as $role)
                    <div class="form-group form-check">
                        <input type="checkbox" name="roles[]" value="{{ $role['id'] }}">
                        <label class="form-check-label">{{ $role['description'] }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <br>
        <div align="center" style="margin: 0 auto;">
            <button type="submit" class="btn btn-primary" 
            onclick="return confirm('Добавить нового пользователя ?')">
                Добавить пользователя
            </button>
            <a href="{{ route('users') }}" class="btn btn-secondary">Назад</a>
        </div>
    </div>
</form>
@endsection
