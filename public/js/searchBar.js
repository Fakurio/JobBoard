const searchBar = document.querySelector(".header__search");
const searchInput = document.querySelector(".header__search__input");
const clearIcon = document.querySelector(".header__search__remove");
const searchBarForm = searchBar.querySelector(".header__search__form");

const removeChip = (chip) => {
    currentChips.delete(chip.textContent);
    if (currentChips.size === 0) {
        clearIcon.setAttribute("data-hidden", true);
    }
    chip.remove();
};

const removeAllChips = () => {
    searchBar.querySelectorAll(".header__search__chip").forEach((chip) => {
        chip.remove();
    });
    currentChips.clear();
    clearIcon.setAttribute("data-hidden", true);
};

const createNewChip = (chipText) => {
    currentChips.add(chipText);
    clearIcon.removeAttribute("data-hidden");

    let chip = document.createElement("span");
    let chipTextWrapper = document.createElement("span");
    let chipCloseWrapper = document.createElement("span");
    let closeIcon = document.createElement("img");
    let chipInputHidden = document.createElement("input");

    chip.classList.add("header__search__chip");
    chipTextWrapper.classList.add("chip__text");
    chipCloseWrapper.classList.add("chip__close");
    closeIcon.src = "icons/close.svg";
    chipCloseWrapper.appendChild(closeIcon);
    chipInputHidden.type = "hidden";
    chipInputHidden.name = "tags[]";
    chipInputHidden.value = chipText.toLowerCase();

    chipCloseWrapper.addEventListener("click", () => {
        removeChip(chip);
    });

    chipTextWrapper.textContent = chipText;
    chipTextWrapper.appendChild(chipInputHidden);
    chip.appendChild(chipTextWrapper);
    chip.appendChild(chipCloseWrapper);

    searchInput.value = "";
    searchBarForm.insertBefore(chip, searchInput);
};

const currentChips = new Set();
searchInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        let chipText = searchInput.value.trim();
        if (chipText && !currentChips.has(chipText)) {
            createNewChip(chipText);
        } else {
            searchInput.value = "";
        }
    }
});

searchBar.addEventListener("click", (e) => {
    if (e.target.classList.contains("header__search__remove")) {
        removeAllChips();
    } else {
        searchInput.focus();
    }
});

const btn = document.querySelector(".searchBtn");
btn.addEventListener("click", (e) => {
    // e.preventDefault();
    let form = new FormData();
    form.append("keywords", Array.from(currentChips));
    for (var p of form) {
        console.log(p);
    }
    fetch("/filter", {
        method: "POST",
        body: form,
    });
});
