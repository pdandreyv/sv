@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    <br><br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                      <div class="input">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                          <center><h3>Вход</h3></center>
                          <br><br>
                        
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" placeholder="Адрес E-Mail" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" placeholder="Пароль" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                       </div> 
                      </div> 
                      <div class="name">
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label class="remember">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span>Запомнить меня</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 password">
                                <button type="submit" class="btn btn-primary loginbutton">
                                    Войти
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Забыли пароль?
                                </a>
                            </div>
                        </div>
                       </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
