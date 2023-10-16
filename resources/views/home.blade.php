<x-app-layout>
    <script>
        const searchBar = document.querySelector(".header__search");
        const searchInput = document.querySelector(".header__search__input");

        const currentChips = new Set();
        searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                let chipText = searchInput.value.trim();
                if (chipText && !currentChips.has(chipText)) {
                    currentChips.add(chipText);

                    let chip = document.createElement("span");
                    let chipTextWrapper = document.createElement("span");
                    let chipClose = document.createElement("span");
                    let closeIcon = document.createElement("img");

                    chip.classList.add("header__search__chip");
                    chipTextWrapper.classList.add("chip__text");
                    chipClose.classList.add("chip__close");

                    closeIcon.src = "{{ asset('icons/close.svg') }}";
                    chipClose.appendChild(closeIcon);
                    chipClose.addEventListener("click", (e) => {
                        chip.remove();
                    });
                    chipTextWrapper.textContent = chipText;
                    chip.appendChild(chipTextWrapper);
                    chip.appendChild(chipClose);

                    searchInput.value = "";
                    searchBar.insertBefore(chip, searchInput);
                } else {
                    searchInput.value = "";
                }
            }
        });

        searchBar.addEventListener("click", (e) => {
            if (e.target.classList.contains("header__search__remove")) {
                searchBar
                    .querySelectorAll(".header__search__chip")
                    .forEach((chip) => {
                        chip.remove();
                    });
                currentChips.clear();
            } else {
                searchInput.focus();
            }
        });
    </script>
    <x-slot name="header">
        <h1 class="header__title">Welcome to <span>ITJobsBoard</span></h1>
        <div class="header__search">
            <input class="header__search__input" type="text" />
            <img
                class="header__search__remove"
                src="{{ asset('icons/close.svg') }}"
                alt="remove all tags"
            />
        </div>
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
</x-app-layout>
