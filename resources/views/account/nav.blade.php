<ul class="nav flex-column nav-pills nav-fill">

    <li class="nav-item">
        <a class="nav-link @if (\Route::current()->getName() == 'account.orders') active @endif" href="{{ route('account.orders') }}">Pedidos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (\Route::current()->getName() == 'account.register') active @endif" href="{{ route('account.register') }}">Cadastro</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (\Route::current()->getName() == 'account.address') active @endif" href="{{ route('account.address') }}">Endereço</a>
    </li>
</ul>

@yield('nav_content')
