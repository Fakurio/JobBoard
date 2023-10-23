@extends('layouts.app') @section('content')
<form class="addPostForm" method="POST" action="{{ route('addPost') }}">
    @csrf
    <fieldset class="addPostForm__company-section">
        <h2>Company Info</h2>
        <input
            type="text"
            name="company"
            class="company-name"
            placeholder="Enter company name"
            required
        />
        <div class="logo__wrapper">
            <div class="logo__preview hidden"></div>
            <div class="logo__input">
                <img src="{{ asset('icons/upload.svg') }}" alt="upload logo" />
                <input
                    id="logo"
                    type="file"
                    name="logo"
                    accept="image/*"
                    required
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
            class="title"
            placeholder="Enter post title"
            required
        />
        <select name="level" class="level" required>
            <option defaultchecked hidden value="">
                Select experience level
            </option>
            @foreach ($levels as $level)
            <option value="{{ $level->name }}">
                {{ $level->name }}
            </option>
            @endforeach
        </select>
        <select name="contract_type" class="contract-type" required>
            <option defaultChecked hidden value="">Select contract type</option>
            @foreach ($contractTypes as $contractType)
            <option value="{{ $contractType->name }}">
                {{ $contractType->name }}
            </option>
            @endforeach
        </select>
        <select name="location" class="location" required>
            <option defaultChecked hidden value="">Select job location</option>
            @foreach ($countries as $country)
            <option value="{{ $country->name }}">
                {{ $country->name }}
            </option>
            @endforeach
        </select>
        <div class="languages">
            <h3>Choose languages</h3>
            @foreach ($languages as $language)
            <div>
                <input
                    type="checkbox"
                    id="{{ $language->name }}"
                    name="languages[]"
                    value="{{ $language->name }}"
                /><label
                    for="{{ $language->name }}"
                    >{{ $language->name }}</label
                >
            </div>
            @endforeach
        </div>
    </fieldset>

    <div class="addPostForm__is-featured">
        <input type="checkbox" id="is-featured" name="is_featured" />
        <label for="is-featured">Mark as featured?</label>
    </div>

    <input type="submit" class="addPostForm__submit" value="Add Post" />
</form>
@endsection @push('scripts')
<script defer src="{{ asset('js/uploadCompanyLogo.js') }}"></script>
@endpush
