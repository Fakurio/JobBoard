<x-app-layout>
    <x-slot name="header">
        <h1>Welcome to ITJobsBoard</h1>
    </x-slot>
    <div class="posts">
        @foreach ($posts as $post)
        <div class="post">
            <div class="post__logo--wrapper">
                <img
                    src="{{ asset('logos').'/'.$post->logo }}"
                    alt="{{$post->logo}}"
                    class="post__logo"
                />
            </div>

            <div class="post__body">
                <p>
                    {{$post->company_name}} @if ($post->is_featured)
                    <span>FEATURED</span>
                    @endif
                </p>

                <h2>
                    {{$post->title}} <span>{{$post->salary}}</span>
                </h2>

                <div>
                    <span>{{$post->country->name}}</span>
                    <span>{{$post->contract_type->name}}</span>
                    <span>Posted by: {{$post->user->name}}</span>
                </div>
            </div>
            <div class="post_tags">
                <span>{{$post->level->name}}</span>
                @foreach ($post->languages as $language)
                <span>{{$language->name}}</span>
                @endforeach
            </div>
            <!-- <p>Title: {{$post->title}}</p>
            <p>Company name: {{$post->company_name}}</p>
            <p>Is featured: {{$post->is_featured}}</p>
            <p>
                <img src="{{ asset('logos').'/'.$post->logo }}" />
            </p>
            <p>salary: {{$post->salary}}</p>
            <p>author: {{$post->user->name}}</p>
            <p>location: {{$post->country->name}}</p>
            <p>level: {{$post->level->name}}</p>
            <p>contract: {{$post->contract_type->name}}</p>
            <ul>
                @foreach ($post->languages as $language)
                <li>__{{$language->name}}</li>
                @endforeach
            </ul> -->
        </div>
        @endforeach
    </div>
</x-app-layout>
