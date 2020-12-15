<div>
    email : {{$user->name}}
    {{ route('user.verify', $user->remember_token) }}
</div>
