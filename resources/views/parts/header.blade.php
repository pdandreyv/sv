<nav class="navbar navbar-default navbar-static-top menuproducts">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Переключить Навигацию</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/images/tree2.png" class="img responsive"><span>светоград</span>
            </a>
            <div class="desktop-nav">
                @include('parts.header-nav')
            </div>
            <div class="mobile-nav collapse navbar-collapse" id="app-navbar-collapse">
                <!-- мобильное меню отключено, чтобы избежать дублирования -->
            </div>
        </div>
    </div>
</nav>