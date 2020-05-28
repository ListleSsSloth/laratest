<nav class="navbar navbar-expand-lg navbar-light bg-light">
    
    <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        
        <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="/demo1">Demo Page 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/demo2">Demo Page 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/demo3">Demo Page 3</a>
                            </li>
                        @endauth
                    </ul>
        
                @if (Route::has('login'))
                    <ul class="nav navbar-nav navbar-right">
                        @auth
                            @can('root-actions')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('debug') }}">debug</a>
                                </li>
                            @endcan
                            @can('admin-actions')
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown"
                                     aria-haspopup="true" aria-expanded="false">
                                        Администрирование
                                    </a>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="{{ route('users') }}">Пользователи</a>
                                      @can('edit-roles')
                                        <a class="dropdown-item" href="{{ route('roles') }}">Роли</a>
                                      @endcan
                                    </div>
                                  </li>
                            @endcan
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <img src="{{ asset('images/auth/user-ico.png') }}" alt="" class="menu-icon">
                                    {{ Auth::user()->login }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <img src="{{ asset('images/auth/logout-ico.png') }}" alt="" class="menu-icon">
                                    Logout
                                </a>
                            </li>            
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">
                                    Login
                                </a>
                            </li>
                        @endauth                  
                    </ul>
                @endif
        </div>
            
    
</nav>
