const tabs = document.querySelectorAll(".accordion__tab");
tabs.forEach((item) => {
    item.addEventListener("click", (e) => {
        if (item.hasAttribute("open")) {
            e.preventDefault();
            item.classList.add("closing");
        }
        tabs.forEach((tab) => {
            if (e.currentTarget !== tab && tab.hasAttribute("open")) {
                tab.classList.add("closing");
            }
        });
    });

    item.addEventListener("animationend", (e) => {
        if (e.animationName == "close") {
            item.removeAttribute("open");
            item.classList.remove("closing");
        }
    });
});
