@extends('layout')
@section('header')
@include('loginheader')
@endsection
@section('content')
<div class="register-box">
    <div class="register-text">
        <h1>ログインしました</h1>
        <div class="w">{{ $data }}</div>
        <a href="{{ route('post') }}">投稿画面に戻る</a>
    </div>
</div>
@endsection