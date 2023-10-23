const logoWrapper = document.querySelector(".logo__wrapper");
const logoInputBox = document.querySelector(".logo__input");
const logoPreview = document.querySelector(".logo__preview");
const logoInput = logoInputBox.querySelector("input");

const preventDefaults = (e) => {
    e.preventDefault();
    e.stopPropagation();
};

const previewLogo = (file) => {
    let logo = document.createElement("img");
    logo.src = URL.createObjectURL(file);
    if (logoPreview.firstChild) logoPreview.removeChild(logoPreview.firstChild);
    logoPreview.appendChild(logo);
};

logoWrapper.addEventListener("click", (e) => {
    logoInput.click();
});

logoInput.addEventListener("change", (e) => {
    if (e.target.files[0]) {
        previewLogo(e.target.files[0]);
        logoInputBox.classList.add("hidden");
        logoPreview.classList.remove("hidden");
    }
});

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    logoWrapper.addEventListener(eventName, preventDefaults, false);
});

logoWrapper.addEventListener("drop", (e) => {
    if (e.dataTransfer.files[0].type.startsWith("image/")) {
        logoInput.files[0] = e.dataTransfer.files[0];
        previewLogo(e.dataTransfer.files[0]);
        logoInputBox.classList.add("hidden");
        logoPreview.classList.remove("hidden");
    }
});
