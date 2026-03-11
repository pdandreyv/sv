@extends('layouts.app')

@section('content')
<div class="auth-form-page">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <div class="auth-page-title">
        <h2>Вход</h2>
    </div>

    <div class="auth-card">
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="form-control auth-input" placeholder="Адрес E-Mail" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control auth-input" placeholder="Пароль" name="password" required>
                @if ($errors->has('password'))
                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
            </div>

            <div class="checkbox auth-remember">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Запомнить меня</span>
                </label>
            </div>

            <div class="auth-actions">
                <button type="submit" class="btn auth-btn auth-btn-primary">Войти</button>
                <a class="btn auth-btn auth-btn-light" href="{{ route('password.request') }}">Забыли пароль?</a>
            </div>
        </form>
    </div>
</div>
@endsection
