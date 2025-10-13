<div class="col-md-3">
    <ul class="nav navbar navbar-default menu123" id="admin-side-menu">
        <li {{(isset($menu_item) && $menu_item == 'users')?'class=active':''}}>
            <a href="{{url('admin/users')}}">Пользователи</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'questionnaire')?'class=active':''}}>
            <a href="{{route('admin.questionnaire.index')}}">Анкета</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'roles')?'class=active':''}}>
            <a href="{{route('admin.roles')}}">Роли</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'user_types')?'class=active':''}}>
            <a href="{{route('admin.user-types')}}">Типы пользователей</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'balance')?'class=active':''}}>
            <a href="{{route('admin.operations')}}">Финансовые операции</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'product_category')?'class=active':''}}>
            <a href="{{route('admin.product-categories')}}">Категории</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'products')?'class=active':''}}>
            <a href="{{route('admin.products')}}">Товары и Услуги</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'orders')?'class=active':''}}>
            <a href="{{route('admin.orders')}}">Заказы</a>
        <li {{(isset($menu_item) && $menu_item == 'order-statuses')?'class=active':''}}>
            <a href="{{route('admin.order-statuses')}}">Статусы заказов</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'posts')?'class=active':''}}>
            <a href="{{route('admin.posts')}}">Записи</a>
        </li> 
        <li {{(isset($menu_item) && $menu_item == 'mail_templates')?'class=active':''}}>
            <a href="{{route('admin.mail-templates')}}">Шаблоны писем</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'mailing')?'class=active':''}}>
            <a href="{{route('admin.mailing')}}">Рассылка писем</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'faq')?'class=active':''}}>
            <a href="{{route('admin.faq')}}">Вопросы</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'network')?'class=active':''}}>
            <a href="{{route('admin.network')}}">Сеть</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'funds')?'class=active':''}}>
            <a href="{{route('admin.funds')}}">Фонды</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'documents_cat')?'class=active':''}}>
            <a href="{{route('admin.documents_cat.index')}}">Документооборот</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'resources')?'class=active':''}}>
            <a href="{{route('admin.resources.index')}}">Потребительская корзина</a>
        </li>
        <li {{(isset($menu_item) && $menu_item == 'units')?'class=active':''}}>
            <a href="{{route('admin.units.index')}}">Единицы измерения</a>
        </li>
    </ul>
</div>

