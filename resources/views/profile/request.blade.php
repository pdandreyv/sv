@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">
@if (session('error'))
<div class="alert alert-warning">{{ session('error') }}</div>
@else
<form method="post" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group">
        <h4>Заявка на участие в кооперативе</h4><hr>								
    </div>

    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="last_name">ФАМИЛИЯ</label>
            <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" required>
        </div>

        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="first_name">ИМЯ</label>
            <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" required>
        </div>

        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="middle_name">ОТЧЕСТВО</label>
            <input type="text" name="middle_name" class="form-control" value="{{old('middle_name')}}" required>
        </div>            
    </div>        
    @if($errors->has('last_name'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('last_name') }}
        </div>
    @endif
    
    @if($errors->has('first_name'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('first_name') }}
        </div>
    @endif

    @if($errors->has('middle_name'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('middle_name') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-4"  style="padding-left: 0;">
        <div class="form-group">            
            <label class="required" for="birth_day">ДЕНЬ РОЖДЕНИЯ</label>            
            <select name="birth_day" class="form-control" required> 
                <option value=""></option>
                @for ($i=1;$i<=31;$i++)
                    <option value="{{$i}}" {{(old('birth_day')==$i)?'selected="selected"':''}}>{{$i}}</option>
                @endfor
            </select>
        </div>
        </div>
        <div class="col-md-4" style="padding-left: 0;">
        <div class="form-group">            
            <label class="required" for="birth_mounth">МЕСЯЦ РОЖДЕНИЯ</label>
            <select class="form-control" name="birth_mounth" required>
                <option value=""></option>
                @php $month = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'] 
                @endphp
                @for ($i=1;$i<=12;$i++)
                    <option value="{{$i}}" {{(old('birth_mounth')==$i)?'selected="selected"':''}}>{{$month[$i-1]}}</option>
                @endfor
            </select>
        </div>
        </div> 
        <div class="col-md-4" style="padding-left: 0;">
        <div class="form-group">            
            <label class="required" for="birth_year">ГОД РОЖДЕНИЯ</label>
            <select class="form-control" name="birth_year" required>
                <option value=""></option>
                @for ($i=1940;$i<=date('Y');$i++)
                    <option value="{{$i}}" {{(old('birth_year')==$i)?'selected="selected"':''}}>{{$i}}</option>
                @endfor
            </select>            
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4"  style="padding-left: 0;">
            @if($errors->has('birth_day'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('birth_day') }}
                </div>
            @endif
        </div>
        <div class="col-md-4" style="padding-left: 0;">
            @if($errors->has('birth_mounth'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('birth_mounth') }}
                </div>
            @endif
        </div> 
        <div class="col-md-4" style="padding-left: 0;">
            @if($errors->has('birth_year'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('birth_year') }}
                </div>
            @endif
        </div>      
    </div>
    
    <div class="form-group">
        <label class="required" for="gender">ПОЛ</label>
        <select name="gender" class="form-control" placeholder="Выберите пол..." required>
            <option value=""></option>
            <option value="male" {{$selected = (old('gender')=='male')?'selected="selected"':''}}>Мужской</option>
            <option value="female" {{$selected = (old('gender')=='female')?'selected="selected"':''}}>Женский</option>
        </select>
    </div>
    @if($errors->has('gender'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('gender') }}
        </div>
    @endif
    
    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="city">ГОРОД</label>
            <input type="text" name="city" class="form-control" value="{{old('city')}}" required>
        </div>
    </div>
    @if($errors->has('city'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('city') }}
        </div>
    @endif
    
    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="phone_number">ТЕЛЕФОН</label>
            <input type="text" name="phone_number" class="form-control" value="{{old('phone_number')}}" required>
        </div>
    </div>
    @if($errors->has('phone_number'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('phone_number') }}
        </div>
    @endif

    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="passport_series">СЕРИЯ ПАСПОРТА</label>
            <input type="text" name="passport_series" class="form-control" value="{{old('passport_series')}}" required>
        </div>
    </div>
    @if($errors->has('passport_series'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_series') }}
        </div>
    @endif
    
    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="passport_number">НОМЕР ПАСПОРТА</label>
            <input type="text" name="passport_number" class="form-control" value="{{old('passport_number')}}" required>
        </div>
    </div>
    @if($errors->has('passport_number'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_number') }}
        </div>
    @endif
    
    <div class="form-group">        
        <label class="required" for="passport_give">КЕМ ВЫДАН</label>
        <input type="text" name="passport_give" class="form-control" value="{{old('passport_give')}}" required>        
    </div>
    @if($errors->has('passport_give'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_give') }}
        </div>
    @endif
    
    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label class="required" for="passport_give_date">ДАТА ВЫДАЧИ</label>
            <input type="text" name="passport_give_date" class="form-control date" value="{{old('passport_give_date')}}" required>
        </div> 
    </div>
    @if($errors->has('passport_give_date'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_give_date') }}
        </div>
    @endif
    
    <div class="form-group">        
        <label class="required" for="registration_address">АДРЕС ПРОПИСКИ</label>
        <input type="text" name="registration_address" class="form-control" value="{{old('registration_address')}}" required>        
    </div>
    @if($errors->has('registration_address'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('registration_address') }}
        </div>
    @endif
    
    <div class="form-group">        
        <label class="required" for="identification_code">ИДЕНТИФИКАЦИОННЫЙ КОД</label>
        <input type="text" name="identification_code" class="form-control" value="{{old('identification_code')}}" required>        
    </div>
    @if($errors->has('identification_code'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('identification_code') }}
        </div>
    @endif
    
    <div class="form-group">
        <label class="required" for="page1_file">ПЕРВАЯ СТРАНИЦА ПАСПОРТА</label>        
        <input name="page1_file" type="file" accept=".jpg,.jpeg,.png" required>      
    </div>
    @if($errors->has('page1_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('page1_file') }}
        </div>
    @endif
    
    <div class="form-group">
        <label class="required" for="page2_file">ВТОРАЯ СТРАНИЦА ПАСПОРТА</label>        
        <input name="page2_file" type="file" accept=".jpg,.jpeg,.png" required>      
    </div>
    @if($errors->has('page2_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('page2_file') }}
        </div>
    @endif
    
    <div class="form-group">
        <label class="required" for="page3_file">ТРЕТЬЯ СТРАНИЦА ПАСПОРТА</label>        
        <input name="page3_file" type="file" accept=".jpg,.jpeg,.png" required>      
    </div>
    @if($errors->has('page3_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('page3_file') }}
        </div>
    @endif
    
    <div class="form-group">
        <label class="required" for="ic_file">ИДЕНТИФИКАЦИОННЫЙ КОД</label>        
        <input name="ic_file" type="file" accept=".jpg,.jpeg,.png" required>      
    </div>
    @if($errors->has('ic_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('ic_file') }}
        </div>
    @endif    
    
    <div class="form-group">    
        <input type="checkbox" id="agree" required>            
        <label>Я согласен с правилами кооператива и обязуюсь их выполнять</label>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
@endif
</div>


<script type="text/javascript">
    $(document).ready(function () {        
        $('.date').datepicker({
            timePicker: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            language: 'ru',
            startDate: new Date(<?php echo date('Y-m-d') ?>)
        });
    });
</script>

@endsection
