<ul class="nav navbar-nav navbar-right">
    @guest
        <li>
            <a href="{{ route('login') }}" class="login">
                <i class="fas fa-sign-in-alt"></i> Войти
            </a>
        </li>
        <li>
            <a href="{{ route('register') }}" class="register">
                <i class="fas fa-user-plus"></i> Регистрация
            </a>
        </li>
    @else
        @if( !(\Request::is('admin/*')) )
            <li>
                <form method="GET" class="form-inline search-form" action="{{ route('search') }}">
                    <label for="search_text"><img src="/images/search.png"></label>
                    <input type="text" placeholder="Поиск" name="search_text" class="form-control"/>
                    <label for="search_type">в:</label>
                    <select class="form-control search-type" name="search_type">
                        <option value="products">товарах</option>
                        <option value="service-products">услугах</option>
                        <option value="posts">статьях</option>
                    </select>
                    <button type="submit" class="btn btn-primary" value="Найти">
                        <span>Искать</span>
                    </button>
                </form>
            </li>
            @if(app('request')->attributes->get('isCooperative'))
                @php
                    $cartInfo = app('request')->attributes->get('cart');
                @endphp
                <li class="cart-container">
                    <a href="/cart" title="Моя корзина">
                        <span class="basket-content"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<span id="cart-quantity"><strong>{{$cartInfo['totalQuantity']}}</strong></span>&nbsp;шт&nbsp;-&nbsp;
                        <span id="cart-total"><strong>{{$cartInfo['totalAmount']}}</strong></span>&nbsp;грн</span>
                    </a>
                </li>
            @endif
            <li class="usr-balance">
                <a href="{{ route('replenish.balance')}}" title="Мой баланс">
                    <span class="icon"><i class="fas fa-coins"></i></span>
                    <span class="qty">{{Auth::user()->getBalanceDisplay()}}</span>
                </a>
            </li>
        @endif
        <li class="dropdown" id="auth_menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                @if( Auth::user()->photo && file_exists(public_path().'/images/users_photos/'.Auth::user()->photo) )
                    <img src="/images/users_photos/{{Auth::user()->photo}}" class="header-user-photo">
                @else
                    <img src="{{config('app.placeholder_url')}}50x50/00d2ff/ffffff" class="header-user-photo">
                @endif
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <span><i class="fas fa-signature"></i> {{Auth::user()->last_name}} {{ Auth::user()->first_name }}</span>
                </li>
                @if( Auth::user()->isAdmin() )
                    <li>
                        <a href="{{ route('admin.home') }}">
                            <i class="fas fa-user-cog"></i> Админка
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('profile.my-page', ['id' => Auth::user()->id]) }}">
                        <i class="fas fa-user"></i> Моя страница
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Выйти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    @endguest
</ul>