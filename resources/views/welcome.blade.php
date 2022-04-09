@extends('layout.layout')
@section('content')

<a href="{{ route('user.create') }}"> Add user </a>

@include('user.index')

@endsection
