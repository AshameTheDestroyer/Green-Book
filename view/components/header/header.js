const
    mainHeader = document.querySelector("#main-header"),
    MAIN_HEADER_HEIGHT = getComputedStyle(mainHeader)["height"].replace("px", "");
window.addEventListener("scroll", _e => {
    if (window.scrollY > MAIN_HEADER_HEIGHT / 2) {
        mainHeader.classList.add("sticking-header");
    } else {
        mainHeader.classList.remove("sticking-header");
    }
});