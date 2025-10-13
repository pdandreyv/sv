<div class="user-info">
    <form method="post" class="user_info form-horizontal" action="{{ route('profile.access', ['id'=>Auth::user()->id]) }}">
                {{ csrf_field() }}

            <div class="form-group name">
                <span>{{$user->last_name ?: '-'}} {{$user->first_name ?: '-'}} {{$user->middle_name ?: '-'}}</span>
            </div>
            <div class="form-group custom-control custom-checkbox" title="Отображать или не отображать эти данные для других пользователей ">
                <label><input type="checkbox" name="birth_date_view" class="custom-control-input" {{$user->birth_date_view?'checked="checked"':''}}>
                    <span class="strong">Дата рождения:</span> {{ \Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') }}
                </label>
            </div>
            <!-- <div class="form-group custom-control custom-checkbox" title="Отображать или не отображать эти данные для других пользователей ">
                <label><input type="checkbox" class="custom-control-input" checked>
                    <span><span class="strong">Пол:</span> {{($user->gender =='male')?'Мужской':($user->gender =='female'?'Женский':'')}}</span>
                </label>
            </div> -->
            <div class="form-group" title="Отображать или не отображать эти данные для других пользователей ">
                <label><input type="checkbox" name="city_view" class="custom-control-input" {{$user->city_view?'checked="checked"':''}}>
                    <span><span class="strong">Город:</span> {{$user->city ?: '-'}}</span>
                </label>
            </div>
            <div class="form-group" title="Отображать или не отображать эти данные для других пользователей ">
                <label><input type="checkbox" name="phone_number_view" class="custom-control-input" {{$user->phone_number_view?'checked="checked"':''}}>
                    <span><span class="strong">Телефон:</span> {{$user->phone_number ?: '-'}}</span>
                </label>
            </div>
            <div class="form-group" title="Отображать или не отображать эти данные для других пользователей ">
                <label><input type="checkbox" name="email_view" class="custom-control-input" {{$user->email_view?'checked="checked"':''}}>
                    <span><span class="strong">Email:</span> {{$user->email ?: '-'}}</span>
                </label>
            </div>
            <div class="form-group">
                <span><span class="strong">Ваша реферальная ссылка:</span> <a href="{{route('referal.link', ['id'=>$user->getLink()])}}">{{route('referal.link', ['id'=>$user->getLink()])}}</a></span>
            </div>
            <div class="form-group" >
                <input type="submit" class="btn btn-primary" value="Сохранить изменения  ">
            </div>

    </form>
</div>