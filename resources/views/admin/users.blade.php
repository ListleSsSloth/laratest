@extends('layouts.app')

@section('head')
    <script>
        $(function() {
            $("#searchinput").on("keyup",
                function() {
                    var value = $(this).val().toLowerCase();
                    $("#maintable tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
        });

        function onkeypressed(evt, input) {
            var code = evt.charCode || evt.keyCode;
            if (code === 27) {
                input.value = '';
            }
        }
    </script>
@endsection

@section('content')
<form action="" method="POST">
@csrf
    <div class="container">
        <br>

        <table style="width: 100%">
            <th style="width: 35%">
                <h4>Пользователи</h4>
            </th>
            <th style="width: 80%">
                Режим отображения: 
                <span style="color: green">
                    {{ session('users.viewmode') == 'active' ? 'активные' : 'все' }}
                </span>
                <button class="btn btn-outline-info btn-sm" type="submit" name="changeviewmode">
                    {{ session('users.viewmode') == 'active' ? 'Показать всех' : 'Показать только активных' }}
                </button>
            </th>
            <th >
                <a href="{{ route('users') }}/add" class="btn btn-primary btn-sm">Добавить</a>
            </th>
        </table>   

        <table class="table table-hover">
            <thead class="thead-dark">
                <th scope="col" style="width: 15%">Логин</th>
                <th scope="col" style="width: 5%">LDAP</th>
                <th scope="col" style="width: 68%">Роли</th>
                <th scope="col">
                    <input type="text" id="searchinput" style="width: 200px" placeholder="Поиск...">
                </th>
            </thead>
            <tbody id="maintable">
                @foreach ($users as $user)
                    <tr class="{{ $user['active'] ? '' : 'table-secondary' }}">
                        <th scope="row" style="vertical-align: middle">
                            {{ $user['login'] }}
                        </th>
                        <td style="vertical-align: middle">
                            @if ($user['ldap'])
                                <div class="black-table-circle"></div>
                            @endif
                        </td>
                        <td>
                            @foreach ($user['roles'] as $role)
                                [{{ $role['description'] }}] 
                            @endforeach
                        </td>
                        <td align="right" style="vertical-align: middle">
                            @if (!$user['protected'])
                                <a href="{{ route('users') }}/edit/{{ $user['id'] }}" class="btn btn-outline-secondary btn-sm">Редактировать</a>
                            @else
                                User protected
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>
@endsection
