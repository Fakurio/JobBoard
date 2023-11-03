@extends('layouts.app') @section('header')
<h1>My applications</h1>
@endsection @section('content')
<div class="accordion">
    <details class="accordion__tab">
        <summary class="accordion__tab__title">Sent</summary>
        @foreach ($applications as $application) @if($application->status->name
        == 'Sent')
        <div class="post accordion__tab__body">
            <div class="post__logo--wrapper">
                <img
                    src="{{ asset('logos').'/'.$application->post->logo }}"
                    alt="{{$application->post->logo}}"
                    class="post__logo"
                />
            </div>
            <div class="post__body">
                <p class="post__body__header">
                    {{$application->post->company_name}}
                    @if ($application->post->is_featured)
                    <span>FEATURED</span>
                    @endif
                </p>
                <h2 class="post__body__title">
                    {{$application->post->title}}
                </h2>
                <div class="post__body__footer">
                    <span>{{$application->post->country->name}}</span>
                    <span>{{$application->post->contract_type->name}}</span>
                    <span class="post__author"
                        >Posted by: {{$application->post->user->name}}</span
                    >
                </div>
            </div>
            <div class="post__salary">
                <span>{{$application->post->salary}} PLN</span>
            </div>
            <div class="post__tags">
                <span
                    class="post__tag"
                    >{{$application->post->level->name}}</span
                >
                @foreach ($application->post->languages as $language)
                <span class="post__tag">{{$language->name}}</span>
                @endforeach
            </div>
        </div>
        @endif @endforeach
    </details>
    <details class="accordion__tab">
        <summary class="accordion__tab__title">Accepted</summary>
        @foreach ($applications as $application) @if($application->status->name
        == 'Accepted')
        <div class="post accordion__tab__body">
            <div class="post__logo--wrapper">
                <img
                    src="{{ asset('logos').'/'.$application->post->logo }}"
                    alt="{{$application->post->logo}}"
                    class="post__logo"
                />
            </div>
            <div class="post__body">
                <p class="post__body__header">
                    {{$application->post->company_name}}
                    @if ($application->post->is_featured)
                    <span>FEATURED</span>
                    @endif
                </p>
                <h2 class="post__body__title">
                    {{$application->post->title}}
                </h2>
                <div class="post__body__footer">
                    <span>{{$application->post->country->name}}</span>
                    <span>{{$application->post->contract_type->name}}</span>
                    <span class="post__author"
                        >Posted by: {{$application->post->user->name}}</span
                    >
                </div>
            </div>
            <div class="post__salary">
                <span>{{$application->post->salary}} PLN</span>
            </div>
            <div class="post__tags">
                <span
                    class="post__tag"
                    >{{$application->post->level->name}}</span
                >
                @foreach ($application->post->languages as $language)
                <span class="post__tag">{{$language->name}}</span>
                @endforeach
            </div>
        </div>
        @endif @endforeach
    </details>
    <details class="accordion__tab">
        <summary class="accordion__tab__title">Rejected</summary>
        @foreach ($applications as $application) @if($application->status->name
        == 'Rejected')
        <div class="post accordion__tab__body">
            <div class="post__logo--wrapper">
                <img
                    src="{{ asset('logos').'/'.$application->post->logo }}"
                    alt="{{$application->post->logo}}"
                    class="post__logo"
                />
            </div>
            <div class="post__body">
                <p class="post__body__header">
                    {{$application->post->company_name}}
                    @if ($application->post->is_featured)
                    <span>FEATURED</span>
                    @endif
                </p>
                <h2 class="post__body__title">
                    {{$application->post->title}}
                </h2>
                <div class="post__body__footer">
                    <span>{{$application->post->country->name}}</span>
                    <span>{{$application->post->contract_type->name}}</span>
                    <span class="post__author"
                        >Posted by: {{$application->post->user->name}}</span
                    >
                </div>
            </div>
            <div class="post__salary">
                <span>{{$application->post->salary}} PLN</span>
            </div>
            <div class="post__tags">
                <span
                    class="post__tag"
                    >{{$application->post->level->name}}</span
                >
                @foreach ($application->post->languages as $language)
                <span class="post__tag">{{$language->name}}</span>
                @endforeach
            </div>
        </div>
        @endif @endforeach
    </details>
</div>
@endsection @push('scripts')
<script defer src="{{ asset('js/accordion.js') }}"></script>
@endpush
