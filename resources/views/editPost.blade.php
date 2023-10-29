@extends('layouts.app') @section("header")
<h1>Select post to edit</h1>
@endsection @section('content')
<div class="posts">
    @foreach ($posts as $post)
    <div class="post post--removable">
        <button class="post__edit-btn">
            <a href="{{route('editPost.post', ['postID' => $post->id])}}"
                >Edit</a
            >
        </button>
        <div class="post__logo--wrapper">
            <img
                src="{{ asset('logos').'/'.$post->logo }}"
                alt="{{$post->logo}}"
                class="post__logo"
            />
        </div>
        <div class="post__body">
            <p class="post__body__header">
                {{$post->company_name}} @if ($post->is_featured)
                <span>FEATURED</span>
                @endif
            </p>
            <h2 class="post__body__title">
                {{$post->title}}
            </h2>
            <div class="post__body__footer">
                <span>{{$post->country->name}}</span>
                <span>{{$post->contract_type->name}}</span>
                <span class="post__author"
                    >Posted by: {{$post->user->name}}</span
                >
            </div>
        </div>
        <div class="post__salary">
            <span>{{$post->salary}} PLN</span>
        </div>
        <div class="post__tags">
            <span class="post__tag">{{$post->level->name}}</span>
            @foreach ($post->languages as $language)
            <span class="post__tag">{{$language->name}}</span>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection
