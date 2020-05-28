@extends('layouts.app')

@section('content')
<form action="" method="POST">
@csrf
    <div class="container">
        <br>
        <table style="width: 100%">
            <th style="width: 100%">
                <h4>Роли</h4>
            </th>
            <th >
                <a href="{{ route('roles') }}/add" class="btn btn-primary btn-sm">Добавить</a>
            </th>
        </table>   
        <table class="table table-hover">
            <thead class="thead-dark">
                <th scope="col" style="width: 15%">Имя</th>
                <th scope="col" style="width: 70%">Описание</th>
                <th scope="col" ></th>
            </thead>
            <tbody id="maintable">
                @foreach ($roles as $role)
                    <tr>
                        <th scope="row" style="vertical-align: middle">
                            {{ $role['name'] }}
                        </th>
                        <td scope="row" style="vertical-align: middle">
                            {{ $role['description'] . ' (' . $role['users'] . ')' }}
                        </td>
                        <td align="right" style="vertical-align: middle">
                            @if (!$role['protected'])
                                <a href="{{ route('roles') }}/edit/{{ $role['id'] }}" class="btn btn-outline-secondary btn-sm">Редактировать</a>
                            @else
                                Role protected
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>
@endsection
