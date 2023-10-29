@extends('layouts.app') 
@section('header') 
<h1>Enter post's new details</h1>
@endsection
@section('content') 
<form
    class="postForm"
    method="POST"
    action="{{ route('updatePost') }}"
    enctype="multipart/form-data"
>
    @csrf
    <fieldset class="postForm__company-section">
        <h2>Company Info</h2>
        <input
            type="text"
            name="company_name"
            class="company-name"
            placeholder="Enter company name"
            required
            value="{{ $post->company_name }}"
        />
        <div class="logo__wrapper">
            <div class="logo__preview">
                <img src="{{asset('logos/'.$post->logo)}}" alt="logo" />
            </div>
            <div class="logo__input hidden">
                <input
                    id="logo"
                    type="file"
                    name="logo"
                    accept="image/*"
                /> 
            </div>
        </div>
    </fieldset>

    <fieldset class="postForm__job-section">
        <h2>Job info</h2>
        <input
            type="text"
            name="title"
            placeholder="Enter post title"
            required
            value="{{ $post->title }}"
        />
        <input type="number" 
            name="salary" 
            placeholder="Enter salary" 
            required 
            value="{{ $post->salary }}" 
        />
        <select name="level"  required>
            <option defaultchecked hidden value="">
                Select experience level
            </option>
            @foreach ($levels as $level)
            <option @selected($post->level->name == $level->name) value="{{ $level->name }}">
                {{ $level->name }}
            </option>
            @endforeach
        </select>
        <select name="contract_type" required>
            <option defaultChecked hidden value="">Select contract type</option>
            @foreach ($contractTypes as $contractType)
            <option @selected($post->contract_type->name == $contractType->name) value="{{ $contractType->name }}">
                {{ $contractType->name }}
            </option>
            @endforeach
        </select>
        <select name="location" required>
            <option defaultChecked hidden value="">Select job location</option>
            @foreach ($countries as $country)
            <option @selected($post->country->name == $country->name) value="{{ $country->name }}">
                {{ $country->name }}
            </option>
            @endforeach
        </select>
        <div class="languages">
            @error("languages")
            <div class="postForm__error">{{ $message }}</div>
            @enderror
            <h3>Choose languages</h3>
            @foreach ($languages as $language)
            <div>
                <input
                    type="checkbox"
                    id="{{ $language->name }}"
                    name="languages[]"
                    value="{{ $language->name }}"
                    @foreach($post->languages as $lang)
                        @if ($lang->name == $language->name)
                            checked
                        @endif
                    @endforeach
                /><label
                    for="{{ $language->name }}"
                    >{{ $language->name }}</label
                >
            </div>
            @endforeach
        </div>
    </fieldset>

    <div class="postForm__is-featured">
        <input type="checkbox" id="is-featured" name="is_featured" 
        @if ($post->is_featured)
            checked
        @endif
        />
        <label for="is-featured">Mark as featured?</label>
    </div>

    <input type="submit" class="postForm__submit" value="Edit Post" />
</form>
@endsection @push('scripts')
<script defer src="{{ asset('js/uploadCompanyLogo.js') }}"></script>
@endpush