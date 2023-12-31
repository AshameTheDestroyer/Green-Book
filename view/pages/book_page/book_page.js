import Debounce from "../../../utils/debounce.js";

const
    bookPageHeader = document.querySelector("#book-page header"),
    BOOK_PAGE_HEADER_HEIGHT = getComputedStyle(bookPageHeader)["height"].replace("px", ""),
    BOOK_PAGE_HEADER_TOP = Number(BOOK_PAGE_HEADER_HEIGHT) + Number(getComputedStyle(bookPageHeader)["top"].replace("px", ""));
window.addEventListener("scroll", _e => {
    if (window.scrollY > BOOK_PAGE_HEADER_TOP / 2) {
        bookPageHeader.classList.add("sticking-header");
    } else {
        bookPageHeader.classList.remove("sticking-header");
    }
});


const
    bookPageContent = document.querySelector("#book-page-content"),
    bookForm = document.querySelector("form"),
    searchInput = bookForm.querySelector("#search-input-field>input"),
    titleCheckbox = bookForm.querySelector("#title-checkbox"),
    authorCheckbox = bookForm.querySelector("#author-checkbox"),
    minimumPriceInput = bookForm.querySelector("#min-price-input"),
    maximumPriceInput = bookForm.querySelector("#max-price-input"),
    genreCheckboxes = [...bookForm.querySelectorAll("#genre-drop-down input[type=checkbox]")];

fetchBooks("");
searchInput.addEventListener("keyup", e => Debounce(fetchBooks, 250)(e.target.value));
bookForm.addEventListener("change", e => (e.target != searchInput) && fetchBooks(searchInput.value));

function fetchBooks(searchTerm) {
    searchTerm = searchTerm.trim();

    const xmlHttp = new XMLHttpRequest();
    xmlHttp.addEventListener("readystatechange", _e => {
        if (xmlHttp.readyState != 4 || xmlHttp.status != 200) { return; }

        bookPageContent.innerHTML = xmlHttp.responseText ?? "<h3 style=\"color:#00e25e\">No result</h3>";
    });

    if (searchInput == "") {
        xmlHttp.open("GET", "control/fetch_books.php", true);
    } else {
        const searchParams = new URLSearchParams({
            "search-term": searchTerm,
            title: titleCheckbox.checked,
            author: authorCheckbox.checked,
            "min-price": minimumPriceInput.value.replace(".", "_"),
            "max-price": maximumPriceInput.value.replace(".", "_"),
            genres: genreCheckboxes
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.name)
                .join(","),
        });
        xmlHttp.open("GET", "control/fetch_books.php?" + searchParams.toString(), true);
    }

    xmlHttp.send();
}