@extends('layouts.admin-app')

@section('content')

<category-component :category_post="{{ $category_post }}"></category-component>

@endsection