@extends('layout.layout')
@section('content')
    <a href="/"> users </a>
    @php $userSet = isset($user) @endphp
    <form method="post" action="{{ $userSet ? route('user.update', ['user' => $user->id]) : route('user.store') }}">
        @csrf
        @if($userSet) @method('PUT') @endif
        @include('user.partials.basic-fields')
        @if(!$userSet) @include('user.partials.additional-fields') @endif
        <button type="submit">@if($userSet) Update @else Save @endif</button>
    </form>
@endsection
