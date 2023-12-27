const bookCards = [...document.querySelectorAll(".book-card")];
bookCards.forEach(bookCard => bookCard.addEventListener("click", _e =>
    bookCard.querySelector("form>button").click()
));