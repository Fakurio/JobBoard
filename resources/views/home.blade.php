@extends('layouts.app') @section('header')
<h1 class="header__title">
    Welcome to <a href="/"><span>ITJobsBoard</span></a>
</h1>
<div class="header__search">
    <form class="header__search__form" method="POST" action="/">
        @csrf
        <div class="header__search__chips--wrapper">
            <input class="header__search__input" type="text" />
        </div>
        <input
            class="header__search__submit"
            type="submit"
            value="search"
            data-hidden="true"
        />
    </form>
    <img
        class="header__search__remove"
        src="{{ asset('icons/close.svg') }}"
        alt="remove all tags"
        data-hidden="true"
    />
</div>

@endsection @section('content')
<div class="posts">
    @if($posts->isEmpty())
    <p class="posts__error">Brak postów dla podanych tagów</p>
    @else @foreach ($posts as $post)
    <div class="post">
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
    @endforeach @endif
</div>
@endsection @push('scripts')
<script defer src="{{ asset('js/searchBar.js') }}"></script>

@endpush
