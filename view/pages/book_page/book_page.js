const bookCards = [...document.querySelectorAll(".book-card")];
bookCards.forEach(bookCard => bookCard.addEventListener("click", _e =>
    bookCard.querySelector("form>button").click()
));

const
    bookPageHeader = document.querySelector("#book-page header"),
    BOOK_PAGE_HEADER_HEIGHT = getComputedStyle(bookPageHeader)["height"].replace("px", ""),
    BOOK_PAGE_HEADER_TOP = Number(BOOK_PAGE_HEADER_HEIGHT) + Number(getComputedStyle(bookPageHeader)["top"].replace("px", ""));
window.addEventListener("scroll", _e => {
    if (window.scrollY > BOOK_PAGE_HEADER_HEIGHT / 2) {
        bookPageHeader.classList.add("sticking-header");
    } else {
        bookPageHeader.classList.remove("sticking-header");
    }
});

