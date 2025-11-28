<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('parts.head')
    </head>
    <body>
        <div id="app">
            @include('parts.header')
            <div class="container main-container">
                @yield('content')
            </div>
            <footer>
                <div class="container-fluid">
                    @include('parts.footer')
                </div>
            </footer>
        </div>
        @yield('before-body-end-scripts')
    </body>


    <script src="/js/tinymce/tinymce.min.js"></script>
    <script src="/js/tinymce/tiny-init.js"></script>
</html>

