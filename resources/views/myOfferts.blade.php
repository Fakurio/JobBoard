@extends('layouts.app') @section('header')
<h1>My offerts</h1>
@endsection @section('content') @if (session("success"))
<p class="session-info session-info--success">{{ session("success") }}</p>
{{Session::forget('success')}}
@endif @if (session("error"))
<p class="session-info session-info--error">{{ session("error") }}</p>
{{Session::forget('error')}}
@endif
<div class="accordion">
    @if($posts->isEmpty())
    <p class="posts__error">
        You have 0 posts or no one applied for your offers
    </p>
    @endif @foreach ($posts as $post)
    <details class="accordion__tab accordion__tab--offert" open>
        <summary class="post accordion__tab__title">
            <div class="post__logo--wrapper">
                <img
                    src="{{ asset('logos').'/'.$post->logo }}"
                    alt="{{$post->logo}}"
                    class="post__logo"
                />
            </div>
            <div class="post__body">
                <p class="post__body__header">
                    {{$post->company_name}}
                    @if ($post->is_featured)
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
        </summary>
        <div class="accordion__tab__body accordion__tab__body--narrow">
            <h2 class="accordion__tab__body__title">Applicants</h2>
            @foreach ($post->applications as $application)
            <div class="applicant">
                <p>{{$application->user->name}}</p>
                <p class="applicant__email">{{$application->user->email}}</p>
                <form
                    method="POST"
                    action="{{route('applicants.update', ['newStatus' => 'accept', 'id' => $application->id])}}"
                >
                    @csrf
                    <button
                        type="submit"
                        class="applicant__btn applicant__btn--accept"
                    >
                        Accept
                    </button>
                </form>
                <form
                    method="POST"
                    action="{{route('applicants.update', ['newStatus' => 'reject', 'id' => $application->id])}}"
                >
                    @csrf
                    <button
                        type="submit"
                        class="applicant__btn applicant__btn--reject"
                    >
                        Reject
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </details>
    @endforeach
</div>
@endsection @push('scripts')
<script defer src="{{ asset('js/accordion.js') }}"></script>
@endpush
