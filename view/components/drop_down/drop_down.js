const dropDowns = [...document.querySelectorAll(".drop-down")];
dropDowns.forEach(dropDown => dropDown.querySelector("button").addEventListener("click", _e => {
    if (dropDown.getAttribute("data-is-open") == "true") {
        dropDown.setAttribute("data-is-open", "false");
        return;
    }

    dropDown.setAttribute("data-is-open", "true");
    document.addEventListener("click", e => (e.target.closest(".drop-down") != dropDown) &&
        dropDown.setAttribute("data-is-open", false));
}));