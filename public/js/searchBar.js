const searchBar = document.querySelector(".header__search");
const searchInput = document.querySelector(".header__search__input");
const clearIcon = document.querySelector(".header__search__remove");
const chipsWrapper = searchBar.querySelector(".header__search__chips--wrapper");
const submitButton = searchBar.querySelector(".header__search__submit");
const postTagsWrappers = document.querySelectorAll(".post__tags");
const searchIcon = searchBar.querySelector(".header__search__search-icon");

const removeChip = (chip) => {
    currentChips.delete(chip.textContent);
    if (currentChips.size === 0) {
        clearIcon.setAttribute("data-hidden", true);
        submitButton.setAttribute("data-hidden", true);
        searchIcon.removeAttribute("data-hidden");
    }
    chip.remove();
};

const removeAllChips = () => {
    searchBar.querySelectorAll(".header__search__chip").forEach((chip) => {
        chip.remove();
    });
    currentChips.clear();
    clearIcon.setAttribute("data-hidden", true);
    submitButton.setAttribute("data-hidden", true);
    searchIcon.removeAttribute("data-hidden");
};

const createNewChip = (chipText) => {
    currentChips.add(chipText);
    clearIcon.removeAttribute("data-hidden");
    submitButton.removeAttribute("data-hidden");
    searchIcon.setAttribute("data-hidden", true);

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
    chipsWrapper.insertBefore(chip, searchInput);
};

const formatSearchInput = () => {
    let chipText = searchInput.value.trim().replace(/[^a-zA-Z ]/g, "");
    chipTextArr = chipText
        .split(/(\s+)/)
        .filter((item) => {
            return item.trim().length > 0;
        })
        .map((item) => {
            return item[0].toUpperCase() + item.slice(1).toLowerCase();
        });
    return chipTextArr;
};

const currentChips = new Set();
searchInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        let chipTextArr = formatSearchInput();
        chipTextArr.forEach((item) => {
            if (item && !currentChips.has(item)) {
                createNewChip(item);
            } else {
                searchInput.value = "";
            }
        });
    }
});

searchBar.addEventListener("click", (e) => {
    if (e.target.classList.contains("header__search__remove")) {
        removeAllChips();
    } else {
        searchInput.focus();
    }
});

postTagsWrappers.forEach((item) => {
    item.addEventListener("click", (e) => {
        if (e.target.classList.contains("post__tag")) {
            let chipText = e.target.textContent;
            if (!currentChips.has(chipText)) {
                createNewChip(chipText);
            }
        }
    });
});
