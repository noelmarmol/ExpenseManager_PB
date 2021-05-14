@extends('layouts.admin-app')

@section('content')

<user-component :user_post="{{ $user_post }}" :roles_user="{{ $roles_user }}"></user-component>

@endsection