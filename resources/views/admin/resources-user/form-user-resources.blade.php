<form id="admin-add-to-resource-user" action="{{route('admin.resources.add-to-user')}}" class="form-horizontal" method="post">
    {{ csrf_field() }}
    <select name="user_id" id="user_id" required>
        <option selected value> -- выбрать пользователя -- </option>
        @foreach ($users as $user)
            <option value="{{$user->id}}" {{ isset($selected_user_id) && $selected_user_id == $user->id ? 'selected' : '' }}>{{ strlen(trim($user->name)) == 0 ? $user->email : $user->name }} ({{$user->id}})</option>
        @endforeach
    </select>
</form>