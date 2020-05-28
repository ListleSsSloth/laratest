@extends('layouts.app')

@section('content')
<form action="" method="POST">
@csrf
<br>
    <div class="container">
        <div class="card" style="width: 75%; margin: 0 auto">
            <div class="card-body">
                <h5 class="card-title">Роль "{{ $role['name'] }}"</h5>
                <input class="form-control" type="text" name="description" value="{{ $role['description'] }}"/>
            </div>
        </div>
        <br>
        <div class="card" style="width: 75%; margin: 0 auto;">
            <div class="card-body">
                <h5 class="card-title">Пользователи</h5>
                @foreach ($role['users'] as $user)
                [ <a href="{{ '/admin/users/edit/' . $user['id'] }}">{{ $user['name'] }}</a> ]
                @endforeach
            </div>
        </div>
        <br>
        <div align="center" style="margin: 0 auto;">
            <button type="submit" class="btn btn-primary" name="update"
            onclick="return confirm('Сохранить изменения ?')">
                Сохранить
            </button>
            <a href="{{ route('roles') }}" class="btn btn-secondary">Назад</a>
            @can('delete-roles')
                <button class="btn btn-danger" type="submit"
                onclick="return confirm('Удалить роль {{ $role['name'] }} ?')"
                name="delete">
                    Удалить
                </button> 
            @endcan
        </div>
    </div>
</form>
@endsection
