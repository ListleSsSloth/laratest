@extends('layouts.app')

@section('content')
<form action="" method="POST">
@csrf
<br>
    <div class="container">
        <div class="card" style="width: 50%; margin: 0 auto">
            <div class="card-body">
                <h5 class="card-title">Роль</h5>
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Имя" required>
                </div>
                <div class="form-group">
                    <label for="password">Описание(имя для отображения)</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Описание">
                </div>
            </div>
        </div>
        <br>
        <div align="center" style="margin: 0 auto;">
            <button type="submit" class="btn btn-primary" 
            onclick="return confirm('Добавить новую роль ?')">
                Добавить роль
            </button>
            <a href="{{ route('roles') }}" class="btn btn-secondary">Назад</a>
        </div>
    </div>
</form>
@endsection
