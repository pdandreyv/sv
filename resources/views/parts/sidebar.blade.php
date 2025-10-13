<div class="col-md-3">
    <ul class="nav navbar navbar-default menu234" id="admin-side-menu">
        <li id="user-photo">
            @if( Auth::user()->photo && file_exists(public_path().'/images/users_photos/'.Auth::user()->photo) )
                <img src="/images/users_photos/{{Auth::user()->photo}}" class="css-adaptive">
            @else
                <img src="{{config('app.placeholder_url')}}250x250/00d2ff/ffffff" class="css-adaptive">
            @endif
        </li>
        @if(app('request')->attributes->get('canSendCooperativeRequest') && app('request')->attributes->get('emptyForm'))
           <li>
                <a href="{{route('cooperation.request')}}" class="btn-request">
                    <button style="width:100%; white-space: normal;" class="btn btn-default btn-primary">Подать заявку на участие в кооперативе</button>
                </a>
            </li>
        @endif
        <li {{(isset($menu_item) && $menu_item == 'my-page')?'class=active':''}}>
            <a href="{{ route('profile.my-page', ['id' => Auth::user()->id]) }}">Моя страница</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'profile')?'class=active':''}}>
            <a href="{{ route('profile.update', ['id' => Auth::user()->id]) }}">Редактирование профиля</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'questionnaire')?'class=active':''}}>
            <a href="{{ route('questionnaire.index') }}">Анкета</a>
        </li>

        @if(app('request')->attributes->get('isCooperative'))
            <li {{(isset($menu_item) && $menu_item == 'news')?'class=active':''}}>
                <a href="{{ route('news') }}">Новости</a>
            </li>
        @endif

        <li>
            <a href="{{ route('products.goods') }}">Наши товары</a>
        </li>

        <li>
            <a href="{{ route('products.services') }}">Наши услуги</a>
        </li>
        
        <li {{(isset($menu_item) && $menu_item == 'replanish-balance')?'class=active':''}}>
            <a href="{{ route('replenish.balance') }}">Пополнение баланса</a>
        </li>
        
        <li {{(isset($menu_item) && $menu_item == 'money-transfer')?'class=active':''}}>
            <a href="{{ route('money.transfer') }}">Перевод денег</a>
        </li>        

        @if(app('request')->attributes->get('isCooperative'))
            <li {{(isset($menu_item) && $menu_item == 'chat')?'class=active':''}}>
                @php
                    $mesCount = app('request')->attributes->get('mesCount');
                @endphp
                <a href="{{ route('chat.chats.list') }}">Мои сообщения {{$mesCount?(' ('.$mesCount.')'):''}}</a>
            </li>
            <li {{(isset($menu_item) && $menu_item == 'users-list')?'class=active':''}}>
                <a href="{{ route('users.list') }}">Список участников</a>
            </li>
        @endif

        <li {{(isset($menu_item) && $menu_item == 'my-network')?'class=active':''}}>
            <a href="{{ route('my.network') }}">Моя сеть</a>
        </li>

        @if(app('request')->attributes->get('isCooperative'))
            <li {{(isset($menu_item) && $menu_item == 'products')?'class=active':''}}>
                <a href="{{ route('products') }}">Мои товары</a>
            </li>
        @endif

        @if(app('request')->attributes->get('isCooperative'))
            <li {{(isset($menu_item) && $menu_item == 'service-products')?'class=active':''}}>
                <a href="{{ route('service-products') }}">Мои услуги</a>
            </li>
        @endif

        @if(app('request')->attributes->get('isCooperative'))
            <li {{(isset($menu_item) && $menu_item == 'resources')?'class=active':''}}>
                <a href="{{ route('resources.index') }}">Моя потребительская корзина</a>
            </li>
        @endif

        @if(app('request')->attributes->get('isCooperative'))
            <li {{(isset($menu_item) && $menu_item == 'settings')?'class=active':''}}>
                <a href="{{ route('chat.settings') }}">Настройки</a>
            </li>
        @endif
    </ul>
</div>