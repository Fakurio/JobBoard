@extends('layouts.app')

@section("header")
@if (session("error"))
    <p class="session-info session-info--error">{{session("error")}}</p>
    {{Session::forget("error")}}
@endif
@endsection

@section('content')
<form
    class="addPostForm"
    method="POST"
    action="{{ route('addPost') }}"
    enctype="multipart/form-data"
>
    @csrf
    <fieldset class="addPostForm__company-section">
        <h2>Company Info</h2>
        <input
            type="text"
            name="company_name"
            class="company-name"
            placeholder="Enter company name"
            required
            value="{{ old('company_name') }}"
        />
        @error("logo")
        <div class="addPostForm__error">{{ $message }}</div>
        @enderror
        <div class="logo__wrapper">
            <div class="logo__preview hidden"></div>
            <div class="logo__input">
                <img src="{{ asset('icons/upload.svg') }}" alt="upload logo" />
                <input
                    id="logo"
                    type="file"
                    name="logo"
                    accept="image/*"
                />
                <label id="logo__label">Upload copmany logo</label>
            </div>
        </div>
    </fieldset>

    <fieldset class="addPostForm__job-section">
        <h2>Job info</h2>
        <input
            type="text"
            name="title"
            placeholder="Enter post title"
            required
            value="{{ old('title') }}"
        />
        <input type="number" 
            name="salary" 
            placeholder="Enter salary" 
            required 
            value="{{old("salary")}}" 
        />
        <select name="level"  required>
            <option defaultchecked hidden value="">
                Select experience level
            </option>
            @foreach ($levels as $level)
            <option @selected(old('level') == $level->name) value="{{ $level->name }}">
                {{ $level->name }}
            </option>
            @endforeach
        </select>
        <select name="contract_type" required>
            <option defaultChecked hidden value="">Select contract type</option>
            @foreach ($contractTypes as $contractType)
            <option @selected(old('contract_type') == $contractType->name) value="{{ $contractType->name }}">
                {{ $contractType->name }}
            </option>
            @endforeach
        </select>
        <select name="location" required>
            <option defaultChecked hidden value="">Select job location</option>
            @foreach ($countries as $country)
            <option @selected(old('location') == $country->name) value="{{ $country->name }}">
                {{ $country->name }}
            </option>
            @endforeach
        </select>
        <div class="languages">
            @error("languages")
            <div class="addPostForm__error">{{ $message }}</div>
            @enderror
            <h3>Choose languages</h3>
            @foreach ($languages as $language)
            <div>
                <input
                    type="checkbox"
                    id="{{ $language->name }}"
                    name="languages[]"
                    value="{{ $language->name }}"
                    @if (is_array(old('languages')) && in_array($language->name, array_values(old('languages'))))
                        checked
                    @endif
                    
                /><label
                    for="{{ $language->name }}"
                    >{{ $language->name }}</label
                >
            </div>
            @endforeach
        </div>
    </fieldset>

    <div class="addPostForm__is-featured">
        <input type="checkbox" id="is-featured" name="is_featured" 
        @if (old("is_featured") == "on")
            checked
        @endif
        />
        <label for="is-featured">Mark as featured?</label>
    </div>

    <input type="submit" class="addPostForm__submit" value="Add Post" />
</form>
@endsection @push('scripts')
<script defer src="{{ asset('js/uploadCompanyLogo.js') }}"></script>
@endpush
