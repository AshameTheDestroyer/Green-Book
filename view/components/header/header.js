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

const
    dashboardNavigationBar = document.querySelector("#dashboard-navigation-bar"),
    dashboardNavigationBarTogglingButton = document.querySelector("#dashboard-navigation-bar-toggling-button"),
    dashboardNavigationBarCloseButton = document.querySelector("#dashboard-navigation-bar-close-button");

if (dashboardNavigationBar != null) {
    dashboardNavigationBarTogglingButton.addEventListener("click", _e => {
        if (dashboardNavigationBar.getAttribute("data-is-open") == null) {
            dashboardNavigationBar.setAttribute("data-is-open", "true");
            return;
        }

        dashboardNavigationBar.removeAttribute("data-is-open");
    });

    dashboardNavigationBarCloseButton.addEventListener("click", _e =>
        dashboardNavigationBar.removeAttribute("data-is-open"),
    );
}