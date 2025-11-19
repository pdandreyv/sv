<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Светоград</title>

<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >

<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" >

<link href="{{ asset('css/bootstrap-grid.css') }}" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet">

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
<link href="{{ asset('css/media.css') }}" rel="stylesheet">

<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script>
    // Глобальный CSRF для всех jQuery AJAX-запросов
    (function() {
        var token = document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content');
        if (window.jQuery && token) {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': token }
            });
        }
        window.Laravel = window.Laravel || {};
        window.Laravel.csrfToken = token;
    })();
    // Базовый URL приложения (с правильной схемой)
    window.APP_BASE_URL = '{{ rtrim(config('app.url'), '/') }}';
</script>
<script>
    // Глобальная переменная для placeholder URL
    var PLACEHOLDER_URL = '{{config('app.placeholder_url')}}';
</script>
<!-- Bootstrap JS для работы dropdown и модалок -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>    
<script src="{{ asset('js/datepicker/locales/bootstrap-datepicker.ru.js') }}"></script>
<script src="{{ asset('jquery.sumoselect/jquery.sumoselect.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>
<script src="{{ asset('js/main.js') }}"></script>