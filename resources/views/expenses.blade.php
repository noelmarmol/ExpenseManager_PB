@extends('layouts.admin-app')

@section('content')

<expense-component :expenses_post="{{ $expenses_post }}" :categories="{{ $categories }}"></expense-component>

@endsection