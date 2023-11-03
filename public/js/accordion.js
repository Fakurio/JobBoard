const tabs = document.querySelectorAll(".accordion__tab");
tabs.forEach((item) => {
    item.addEventListener("click", (e) => {
        if (
            e.target.closest("summary") &&
            e.target
                .closest("summary")
                .classList.contains("accordion__tab__title") &&
            item.hasAttribute("open")
        ) {
            e.preventDefault();
            item.classList.add("closing");
        }
        if (!item.hasAttribute("open")) {
            tabs.forEach((tab) => {
                if (e.currentTarget !== tab && tab.hasAttribute("open")) {
                    tab.classList.add("closing");
                }
            });
        }
    });

    item.addEventListener("animationend", (e) => {
        if (e.animationName == "close") {
            item.removeAttribute("open");
            item.classList.remove("closing");
        }
    });
});
