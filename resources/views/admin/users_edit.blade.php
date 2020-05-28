@extends('layouts.app')

@section('content')
<form action="" method="POST">
@csrf
<br>
    <div class="container">
        <div class="card" style="width: 75%; margin: 0 auto">
            <div class="card-body">
                <h5 class="card-title">Пользователь {{ $user['login'] }}</h5>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Новый пароль">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="change_password" name="change_password">
                    <label class="form-check-label" for="change_password">Изменить пароль</label>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="ldap" {{ $user['ldap'] ? 'checked' : '' }}>
                    <label class="form-check-label" for="ldap">Аунтификация LDAP</label>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="active" {{ $user['active'] ? 'checked' : '' }}>
                    <label class="form-check-label" for="ldap">Активен</label>
                </div>
            </div>
        </div>
        <br>
        <div class="card" style="width: 75%; margin: 0 auto;">
            <div class="card-body">
                <h5 class="card-title">Доступные роли</h5>
                @foreach ($user['roles'] as $role)
                    <div class="form-group form-check">
                        <input type="checkbox" name="roles[]" value="{{ $role['id'] }}" {{ $role['has'] ? 'checked' : '' }}>
                        <label class="form-check-label">
                            {{ $role['description'] }}
                            {{ $role['has'] ? '(' . $role['added_string'] . ')' : '' }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <br>
        <div align="center" style="margin: 0 auto;">
            <button type="submit" class="btn btn-primary" name="update">
                Сохранить
            </button>
            <a href="{{ route('users') }}" class="btn btn-secondary">Назад</a>
            @can('delete-users')
                <button class="btn btn-danger" type="submit"
                onclick="return confirm('Удалить пользователя {{ $user['login'] }} ?')"
                name="delete">
                    Удалить
                </button> 
            @endcan
        </div>
    </div>
</form>
@endsection
