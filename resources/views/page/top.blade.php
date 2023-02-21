@extends('layout')
@section('header')
@include('header')
@endsection
@section('content')
<div class="new-upload-box">
    <div class="new-upload-area">
        <ul class="music-box">
            @foreach($music_data as $music)
            <li class="music-items">
                <div class="music-image">
                    <img src="{{ asset('storage/img/'.$music->image) }}">
                </div>
                <div class="music-name">{{ $music->music_name }}</div>
                <div class="user-id">
                    @auth
                    @if(!$music_model->isLikedBy($music))
                    <span class="likes">
                        <i class="fa-solid fa-heart like-toggle" data-music-id="{{  $music->id }}"></i>
                        <span class='like-counter'>{{$music->likes_count}}</span>
                    </span>
                    @else
                    <span class="likes">
                        <i class="fa-solid fa-heart like-toggle liked" data-music-id="{{  $music->id }}"></i>
                        <span class='like-counter'>{{$music->likes_count}}</span>
                    </span>
                    @endif
                    @endauth
                    @guest
                    <span class="likes">
                        <i class="fa-solid fa-heart"></i>
                        <span class='like-counter'>{{$music->likes_count}}</span>
                    </span>
                </div>
                @endguest
            </li>
            @endforeach
        </ul>
    </div>
    @endsection