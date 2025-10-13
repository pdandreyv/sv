@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<form action="{{route('admin.users.store')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
    <h4>Добавить пользователя</h4><hr>  
    </div>
    <div class="form-group">
        <label for="name">ОТОБРАЖАЕМОЕ ИМЯ</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}" >
    </div>
    @if($errors->has('name'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('name') }}
        </div>
    @endif
    <div class="form-group">
        <label for="email">ЛОГИН (E-MAIL)</label>
        <input type="text" name="email" class="form-control" value="{{old('email')}}">
    </div>  
    @if($errors->has('email'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('email') }}
        </div>
    @endif          
    <div class="form-group">
        <label for="access">РОЛЬ</label>
        <select multiple="multiple" name="role[]" placeholder="Select roles..." class="SlectBox">            
            @foreach ($roles as $role)
                @php
                    $selected = (old('role')!==null && in_array($role->id, old('role')))?'selected="selected"':'';
                @endphp
                <option value="{{$role->id}}" {{$selected}}>{{$role->name}}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label for="access">ТИП</label>
        <select class="form-control" name="user_type_id">            
            <option value=""></option>
            @foreach ($types as $type)                
                @php
                    $selected = (old('user_type_id')!==null && $type->id == old('user_type_id'))?'selected="selected"':'';
                @endphp
                <option value="{{$type->id}}" {{$selected}}>{{$type->name}}</option>
            @endforeach
        </select>
    </div>

	<div class="form-group">
        <label for="alias">АЛИАС</label>
        <input type="text" name="alias" class="form-control" value="{{old('alias')}}">
    </div>
    @if($errors->has('alias'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('alias') }}
        </div>
    @endif
	
    <hr>        

    <div class="form-group">        
        <label for="name">ГОРОД</label>
        <input type="text" name="city" class="form-control" value="{{old('city')}}" >        
    </div>
    
    <div class="form-group">        
        <label for="name">АДРЕС ПРОЖИВАНИЯ</label>
        <input type="text" name="accomodation_address" class="form-control" value="{{old('accomodation_address')}}" >        
    </div>

    <div class="form-group">        
        <label for="name">НОМЕР ТЕЛЕФОНА</label>
        <input type="text" name="phone_number" class="form-control" value="{{old('phone_number')}}" >        
    </div>

    <div class="form-group">
        <label for="name">ФОТО</label>        
        <input name="photo_file" type="file">      
    </div>
    <h4>Паспортные данные</h4><hr>
    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label for="name">ФАМИЛИЯ</label>
            <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" >
        </div>

        <div class="col-md-4" style="padding-left: 0;">
            <label for="name">ИМЯ</label>
            <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" >
        </div>

        <div class="col-md-4" style="padding-left: 0;">
            <label for="name">ОТЧЕСТВО</label>
            <input type="text" name="middle_name" class="form-control" value="{{old('middle_name')}}" >
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
            <label for="name">ДЕНЬ РОЖДЕНИЯ</label>            
            <select name="birth_day" class="form-control"> 
                <option value=""></option>           
                <option value="01" {{(old('birth_day')=='01')?'selected="selected"':''}}>1</option>
                <option value="02" {{(old('birth_day')=='02')?'selected="selected"':''}}>2</option>
                <option value="03" {{(old('birth_day')=='03')?'selected="selected"':''}}>3</option>
                <option value="04" {{(old('birth_day')=='04')?'selected="selected"':''}}>4</option>
                <option value="05" {{(old('birth_day')=='05')?'selected="selected"':''}}>5</option>
                <option value="06" {{(old('birth_day')=='06')?'selected="selected"':''}}>6</option>
                <option value="07" {{(old('birth_day')=='07')?'selected="selected"':''}}>7</option>
                <option value="08" {{(old('birth_day')=='08')?'selected="selected"':''}}>8</option>
                <option value="09" {{(old('birth_day')=='09')?'selected="selected"':''}}>9</option>
                <option value="10" {{(old('birth_day')=='10')?'selected="selected"':''}}>10</option>
                <option value="11" {{(old('birth_day')=='11')?'selected="selected"':''}}>11</option>
                <option value="12" {{(old('birth_day')=='12')?'selected="selected"':''}}>12</option>
                <option value="13" {{(old('birth_day')=='13')?'selected="selected"':''}}>13</option>
                <option value="14" {{(old('birth_day')=='14')?'selected="selected"':''}}>14</option>
                <option value="15" {{(old('birth_day')=='15')?'selected="selected"':''}}>15</option>
                <option value="16" {{(old('birth_day')=='16')?'selected="selected"':''}}>16</option>
                <option value="17" {{(old('birth_day')=='17')?'selected="selected"':''}}>17</option>
                <option value="18" {{(old('birth_day')=='18')?'selected="selected"':''}}>18</option>
                <option value="19" {{(old('birth_day')=='19')?'selected="selected"':''}}>19</option>
                <option value="20" {{(old('birth_day')=='20')?'selected="selected"':''}}>20</option>
                <option value="21" {{(old('birth_day')=='21')?'selected="selected"':''}}>21</option>
                <option value="22" {{(old('birth_day')=='22')?'selected="selected"':''}}>22</option>
                <option value="23" {{(old('birth_day')=='23')?'selected="selected"':''}}>23</option>
                <option value="24" {{(old('birth_day')=='24')?'selected="selected"':''}}>24</option>
                <option value="25" {{(old('birth_day')=='25')?'selected="selected"':''}}>25</option>
                <option value="26" {{(old('birth_day')=='26')?'selected="selected"':''}}>26</option>
                <option value="27" {{(old('birth_day')=='27')?'selected="selected"':''}}>27</option>
                <option value="28" {{(old('birth_day')=='28')?'selected="selected"':''}}>28</option>
                <option value="29" {{(old('birth_day')=='29')?'selected="selected"':''}}>29</option>
                <option value="30" {{(old('birth_day')=='30')?'selected="selected"':''}}>30</option>
                <option value="31" {{(old('birth_day')=='31')?'selected="selected"':''}}>31</option>
            </select>
        </div>
        </div>
        <div class="col-md-4" style="padding-left: 0;">
        <div class="form-group">            
            <label for="name">МЕСЯЦ РОЖДЕНИЯ</label>
            <select class="form-control" name="birth_mounth">
                <option value=""></option>
                <option value="01" {{(old('birth_mounth')=='01')?'selected="selected"':''}}>Январь</option>
                <option value="02" {{(old('birth_mounth')=='02')?'selected="selected"':''}}>Февраль</option>
                <option value="03" {{(old('birth_mounth')=='03')?'selected="selected"':''}}>Март</option>
                <option value="04" {{(old('birth_mounth')=='04')?'selected="selected"':''}}>Апрель</option>
                <option value="05" {{(old('birth_mounth')=='05')?'selected="selected"':''}}>Май</option>
                <option value="06" {{(old('birth_mounth')=='06')?'selected="selected"':''}}>Июнь</option>
                <option value="07" {{(old('birth_mounth')=='07')?'selected="selected"':''}}>Июль</option>
                <option value="08" {{(old('birth_mounth')=='08')?'selected="selected"':''}}>Август</option>
                <option value="09" {{(old('birth_mounth')=='09')?'selected="selected"':''}}>Сентябрь</option>
                <option value="10" {{(old('birth_mounth')=='10')?'selected="selected"':''}}>Октябрь</option>
                <option value="11" {{(old('birth_mounth')=='11')?'selected="selected"':''}}>Ноябрь</option>
                <option value="12" {{(old('birth_mounth')=='12')?'selected="selected"':''}}>Декабрь</option>                
            </select>
        </div>
        </div> 
        <div class="col-md-4" style="padding-left: 0;">
        <div class="form-group">            
            <label for="name">ГОД РОЖДЕНИЯ</label>
            <select class="form-control" name="birth_year">
                <option value=""></option>
                <option value="1940" {{(old('birth_year')=='1940')?'selected="selected"':''}}>1940</option>
                <option value="1941" {{(old('birth_year')=='1941')?'selected="selected"':''}}>1941</option>
                <option value="1942" {{(old('birth_year')=='1942')?'selected="selected"':''}}>1942</option>
                <option value="1943" {{(old('birth_year')=='1943')?'selected="selected"':''}}>1943</option>
                <option value="1944" {{(old('birth_year')=='1944')?'selected="selected"':''}}>1944</option>               
                <option value="1945" {{(old('birth_year')=='1945')?'selected="selected"':''}}>1945</option>
                <option value="1946" {{(old('birth_year')=='1946')?'selected="selected"':''}}>1946</option>
                <option value="1947" {{(old('birth_year')=='1947')?'selected="selected"':''}}>1947</option>
                <option value="1948" {{(old('birth_year')=='1948')?'selected="selected"':''}}>1948</option>
                <option value="1949" {{(old('birth_year')=='1949')?'selected="selected"':''}}>1949</option>
                <option value="1950" {{(old('birth_year')=='1950')?'selected="selected"':''}}>1950</option>
                <option value="1951" {{(old('birth_year')=='1951')?'selected="selected"':''}}>1951</option>
                <option value="1952" {{(old('birth_year')=='1952')?'selected="selected"':''}}>1952</option>
                <option value="1953" {{(old('birth_year')=='1953')?'selected="selected"':''}}>1953</option>
                <option value="1954" {{(old('birth_year')=='1954')?'selected="selected"':''}}>1954</option>
                <option value="1955" {{(old('birth_year')=='1955')?'selected="selected"':''}}>1955</option>
                <option value="1956" {{(old('birth_year')=='1956')?'selected="selected"':''}}>1956</option>
                <option value="1957" {{(old('birth_year')=='1957')?'selected="selected"':''}}>1957</option>
                <option value="1958" {{(old('birth_year')=='1958')?'selected="selected"':''}}>1958</option>
                <option value="1959" {{(old('birth_year')=='1959')?'selected="selected"':''}}>1959</option>
                <option value="1960" {{(old('birth_year')=='1960')?'selected="selected"':''}}>1960</option>
                <option value="1961" {{(old('birth_year')=='1961')?'selected="selected"':''}}>1961</option>
                <option value="1962" {{(old('birth_year')=='1962')?'selected="selected"':''}}>1962</option>
                <option value="1963" {{(old('birth_year')=='1963')?'selected="selected"':''}}>1963</option>
                <option value="1964" {{(old('birth_year')=='1964')?'selected="selected"':''}}>1964</option>
                <option value="1965" {{(old('birth_year')=='1965')?'selected="selected"':''}}>1965</option>
                <option value="1966" {{(old('birth_year')=='1966')?'selected="selected"':''}}>1966</option>
                <option value="1967" {{(old('birth_year')=='1967')?'selected="selected"':''}}>1967</option>
                <option value="1968" {{(old('birth_year')=='1968')?'selected="selected"':''}}>1968</option>
                <option value="1969" {{(old('birth_year')=='1969')?'selected="selected"':''}}>1969</option>
                <option value="1970" {{(old('birth_year')=='1970')?'selected="selected"':''}}>1970</option>
                <option value="1971" {{(old('birth_year')=='1971')?'selected="selected"':''}}>1971</option>
                <option value="1972" {{(old('birth_year')=='1972')?'selected="selected"':''}}>1972</option>
                <option value="1973" {{(old('birth_year')=='1973')?'selected="selected"':''}}>1973</option>
                <option value="1974" {{(old('birth_year')=='1974')?'selected="selected"':''}}>1974</option>
                <option value="1975" {{(old('birth_year')=='1975')?'selected="selected"':''}}>1975</option>
                <option value="1976" {{(old('birth_year')=='1976')?'selected="selected"':''}}>1976</option>
                <option value="1977" {{(old('birth_year')=='1977')?'selected="selected"':''}}>1977</option>
                <option value="1978" {{(old('birth_year')=='1978')?'selected="selected"':''}}>1978</option>
                <option value="1979" {{(old('birth_year')=='1979')?'selected="selected"':''}}>1979</option>
                <option value="1980" {{(old('birth_year')=='1980')?'selected="selected"':''}}>1980</option>
                <option value="1981" {{(old('birth_year')=='1981')?'selected="selected"':''}}>1981</option>
                <option value="1982" {{(old('birth_year')=='1982')?'selected="selected"':''}}>1982</option>
                <option value="1983" {{(old('birth_year')=='1983')?'selected="selected"':''}}>1983</option>
                <option value="1984" {{(old('birth_year')=='1984')?'selected="selected"':''}}>1984</option>
                <option value="1985" {{(old('birth_year')=='1985')?'selected="selected"':''}}>1985</option>
                <option value="1986" {{(old('birth_year')=='1986')?'selected="selected"':''}}>1986</option>
                <option value="1987" {{(old('birth_year')=='1987')?'selected="selected"':''}}>1987</option>
                <option value="1988" {{(old('birth_year')=='1988')?'selected="selected"':''}}>1988</option>
                <option value="1989" {{(old('birth_year')=='1989')?'selected="selected"':''}}>1989</option>
                <option value="1990" {{(old('birth_year')=='1990')?'selected="selected"':''}}>1990</option>
                <option value="1991" {{(old('birth_year')=='1991')?'selected="selected"':''}}>1991</option>
                <option value="1992" {{(old('birth_year')=='1992')?'selected="selected"':''}}>1992</option>
                <option value="1993" {{(old('birth_year')=='1993')?'selected="selected"':''}}>1993</option>
                <option value="1994" {{(old('birth_year')=='1994')?'selected="selected"':''}}>1994</option>
                <option value="1995" {{(old('birth_year')=='1995')?'selected="selected"':''}}>1995</option>
                <option value="1996" {{(old('birth_year')=='1996')?'selected="selected"':''}}>1996</option>
                <option value="1997" {{(old('birth_year')=='1997')?'selected="selected"':''}}>1997</option>
                <option value="1998" {{(old('birth_year')=='1998')?'selected="selected"':''}}>1998</option>
                <option value="1999" {{(old('birth_year')=='1999')?'selected="selected"':''}}>1999</option>
                <option value="2000" {{(old('birth_year')=='2000')?'selected="selected"':''}}>2000</option>
                <option value="2001" {{(old('birth_year')=='2001')?'selected="selected"':''}}>2001</option>
                <option value="2002" {{(old('birth_year')=='2002')?'selected="selected"':''}}>2002</option>
                <option value="2003" {{(old('birth_year')=='2003')?'selected="selected"':''}}>2003</option>
                <option value="2004" {{(old('birth_year')=='2004')?'selected="selected"':''}}>2004</option>
                <option value="2005" {{(old('birth_year')=='2005')?'selected="selected"':''}}>2005</option>
                <option value="2006" {{(old('birth_year')=='2006')?'selected="selected"':''}}>2006</option>
                <option value="2007" {{(old('birth_year')=='2007')?'selected="selected"':''}}>2007</option>
                <option value="2008" {{(old('birth_year')=='2008')?'selected="selected"':''}}>2008</option>
                <option value="2009" {{(old('birth_year')=='2009')?'selected="selected"':''}}>2009</option>
                <option value="2010" {{(old('birth_year')=='2010')?'selected="selected"':''}}>2010</option>
                <option value="2011" {{(old('birth_year')=='2011')?'selected="selected"':''}}>2011</option>
                <option value="2012" {{(old('birth_year')=='2012')?'selected="selected"':''}}>2012</option>
                <option value="2013" {{(old('birth_year')=='2013')?'selected="selected"':''}}>2013</option>
                <option value="2014" {{(old('birth_year')=='2014')?'selected="selected"':''}}>2014</option>
                <option value="2015" {{(old('birth_year')=='2015')?'selected="selected"':''}}>2015</option>
                <option value="2016" {{(old('birth_year')=='2016')?'selected="selected"':''}}>2016</option>
                <option value="2017" {{(old('birth_year')=='2017')?'selected="selected"':''}}>2017</option>
                <option value="2018" {{(old('birth_year')=='2018')?'selected="selected"':''}}>2018</option>
            </select>            
        </div>
        </div>
        
        
    </div>
    
    <div class="form-group">
        <label for="name">ПОЛ</label>
        <select name="gender" class="form-control" placeholder="Выберите пол...">
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
            <label for="name">СЕРИЯ ПАСПОРТА</label>
            <input type="text" name="passport_series" class="form-control" value="{{old('passport_series')}}" >
        </div>
    </div>
    @if($errors->has('passport_series'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_series') }}
        </div>
    @endif
    
    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label for="name">НОМЕР ПАСПОРТА</label>
            <input type="text" name="passport_number" class="form-control" value="{{old('passport_number')}}" >
        </div>
    </div>
    @if($errors->has('passport_number'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_number') }}
        </div>
    @endif
    
    <div class="form-group">        
        <label for="name">КЕМ ВЫДАН</label>
        <input type="text" name="passport_give" class="form-control" value="{{old('passport_give')}}" >        
    </div>
    @if($errors->has('passport_give'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_give') }}
        </div>
    @endif
    
    <div class="form-group">
        <div class="col-md-4" style="padding-left: 0;">
            <label for="name">ДАТА ВЫДАЧИ</label>
            <input type="text" name="passport_give_date" class="form-control date" value="{{old('passport_give_date')}}" >
        </div> 
    </div>
    @if($errors->has('passport_give_date'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('passport_give_date') }}
        </div>
    @endif
    
    <div class="form-group">        
        <label for="name">АДРЕС ПРОПИСКИ</label>
        <input type="text" name="registration_address" class="form-control" value="{{old('registration_address')}}" >        
    </div>
    @if($errors->has('registration_address'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('registration_address') }}
        </div>
    @endif
    
    <div class="form-group">        
        <label for="name">ИДЕНТИФИКАЦИОННЫЙ КОД</label>
        <input type="text" name="identification_code" class="form-control" value="{{old('identification_code')}}" >        
    </div>
    @if($errors->has('identification_code'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('identification_code') }}
        </div>
    @endif
    
    <div class="form-group">
        <label for="name">ПЕРВАЯ СТРАНИЦА ПАСПОРТА</label>        
        <input name="page1_file" type="file" accept=".jpg,.jpeg,.png">      
    </div>
    @if($errors->has('page1_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('page1_file') }}
        </div>
    @endif
    
    <div class="form-group">
        <label for="name">ВТОРАЯ СТРАНИЦА ПАСПОРТА</label>        
        <input name="page2_file" type="file" accept=".jpg,.jpeg,.png">      
    </div>
    @if($errors->has('page2_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('page2_file') }}
        </div>
    @endif
    
    <div class="form-group">
        <label for="name">ТРЕТЬЯ СТРАНИЦА ПАСПОРТА</label>        
        <input name="page3_file" type="file" accept=".jpg,.jpeg,.png">      
    </div>
    @if($errors->has('page3_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('page3_file') }}
        </div>
    @endif
    
    <div class="form-group">
        <label for="name">ИДЕНТИФИКАЦИОННЫЙ КОД</label>        
        <input name="ic_file" type="file" accept=".jpg,.jpeg,.png">      
    </div>
    @if($errors->has('ic_file'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('ic_file') }}
        </div>
    @endif
    
    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll:true, captionFormatAllSelected: "Yeah, OK, so everything." });

        $('.SlectBox').on('sumo:opened', function(o) {
          console.log("dropdown opened", o)
        });

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

