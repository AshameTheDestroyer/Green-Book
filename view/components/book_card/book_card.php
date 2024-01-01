<?php
function book_card(
    $book_id,
    $book_price,
    $book_rating,
    $book_cover_url,
    $book_title,
    $book_author
): string {
    $htmlString = '<div class="book-card" tabindex="0" onclick="this.querySelector(\'form>button\').click();">
    <form action="./book_page.php" method="GET" aria-hidden>
        <input type="hidden" name="book_id" value="' . $book_id . '" />
        <button type="submit"></button>
    </form>

    <header>
        <p>
            ' . $book_price . '$
        </p>
        <div class="star-displayer" title="This book has a rating of ' . $book_rating * 2 . '/10.">
            <div>';

    for ($i = 5; $i > 0; $i--) {
        $htmlString .= '<span>'
         .file_get_contents("./assets/icons/star.svg").   
        '</span>';
    }

    $htmlString .= '</div>
            <div>';

    for ($i = $book_rating; $i > 0; $i--) {
        $htmlString .= '<span data-is-half="' . ($i == 0.5 ? "true" : "") . '">'
            .file_get_contents("./assets/icons/star.svg"). 
        '</span>';
    }

    $htmlString .= '</div>
        </div>
    </header>

    <figure>
        <img src="' . $book_cover_url . '" aria-hidden>
        <img src="' . $book_cover_url . '"
            alt="The cover of the book &quot;' . $book_title . '&quot;">
    </figure>

    <figcaption>
        <h3>
            ' . $book_title . '
        </h3>';

    if (trim($book_author) != "") {
        $htmlString .= '<p>
        By
        <a href="?author=' . $book_author . '"
            title="Click to see other books made by ' . $book_author . '.">
            ' . $book_author . '
        </a>
    </p>';
    }

    $htmlString .= '</figcaption>
</div>';

    return $htmlString;
}
?>
