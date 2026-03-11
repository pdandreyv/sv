@extends('layouts.app')

@section('content')
<div class="auth-form-page">
    <div class="auth-page-title">
        <h2>Регистрация</h2>
    </div>

    <div class="auth-card auth-card-register">
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input id="name" type="text" placeholder="Имя" class="form-control auth-input" name="name" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" placeholder="Адрес E-Mail" class="form-control auth-input" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" placeholder="Пароль" class="form-control auth-input" name="password" required>
                @if ($errors->has('password'))
                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <input id="password-confirm" placeholder="Подтверждение пароля" type="password" class="form-control auth-input" name="password_confirmation" required>
            </div>

            <div class="auth-actions">
                <button type="submit" class="btn auth-btn auth-btn-primary">Зарегистрироваться</button>
            </div>
        </form>
    </div>
</div>
@endsection
