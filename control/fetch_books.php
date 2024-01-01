<?php
$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "book_store";
$connection = new mysqli($serverName, $username, $password, $databaseName);
if ($connection->connect_error) {
    die("Connection has failed: " . $connection->connect_error);
}

define("BOOKS_PER_PAGE", 6);

$pagination_index = filter_input(INPUT_GET, "pagination-index", FILTER_SANITIZE_STRING) ?? "1";

$search_term = filter_input(INPUT_GET, "search-term", FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_GET, "title", FILTER_SANITIZE_STRING);
$author = filter_input(INPUT_GET, "author", FILTER_SANITIZE_STRING);

$minimum_price = filter_input(INPUT_GET, "min-price", FILTER_SANITIZE_STRING);
$maximum_price = filter_input(INPUT_GET, "max-price", FILTER_SANITIZE_STRING);
$minimum_price = str_replace("_", ".", $minimum_price);
$maximum_price = str_replace("_", ".", $maximum_price);

$genre_inputs = filter_input(INPUT_GET, "genres", FILTER_SANITIZE_STRING);
$genre_inputs = ($genre_inputs == "") ? array() : explode(",", $genre_inputs);

$books = array();
$query = (count($genre_inputs) == 0) ? "
        SELECT * FROM books
    " : "
        SELECT DISTINCT(book_id), books.*, genres.title AS genre_title FROM books_to_genres
        JOIN genres ON books_to_genres.genre_id = genres.id
        JOIN books ON books_to_genres.book_id = books.id
    ";

if ($search_term != null) {
    $checkbox_filters = array();

    if ($title == "true") {
        array_push($checkbox_filters, "books.title LIKE '%$search_term%'");
    }

    if ($author == "true") {
        array_push($checkbox_filters, "books.author LIKE '%$search_term%'");
    }

    if (count($checkbox_filters) > 0) {
        $query .= " WHERE (" . implode(" AND ", $checkbox_filters) . ")";
    } else {
        $query .= " WHERE (books.title LIKE '%$search_term%' OR books.author LIKE '%$search_term%')";
    }
}

$price_filters = array();

if ($minimum_price) {
    array_push($price_filters, "books.price >= '$minimum_price'");
}

if ($maximum_price) {
    array_push($price_filters, "books.price <= '$maximum_price'");
}

if (count($price_filters) > 0) {
    if (str_contains($query, "WHERE")) {
        $query .= " AND ";
    } else {
        $query .= " WHERE ";
    }

    $query .= "(" . implode(" AND ", $price_filters) . ")";
}

if (count($genre_inputs) > 0) {
    if (str_contains($query, "WHERE")) {
        $query .= " AND ";
    } else {
        $query .= " WHERE ";
    }

    $query .= "genres.title IN ('" . implode("','", $genre_inputs) . "')";
}

$result = $connection->execute_query($query);
$books = $result->fetch_all(MYSQLI_ASSOC);

$maximum_page_count = ceil(count($books) / BOOKS_PER_PAGE);
$start = BOOKS_PER_PAGE * ($pagination_index - 1);

$connection->close();
?>

<?php if (count($books) == 0): ?>
    <main id="no-book-message">
        <h1>No Book Matches The Criteria</h1>
        <p>There is no book found that matches the provided filtering criteria.</p>
    </main>
    <?php return ?>
<?php endif ?>

<?php if ($pagination_index > $maximum_page_count): ?>
    <main id="no-book-message">
        <h1>Pagination Index is out of Range</h1>
        <p>There's no page with that index, how did you get to this page?</p>
        <?= $pagination_index ?>
        <?= $maximum_page_count ?>
    </main>
    <?php return ?>
<?php endif ?>

<?php $books = array_slice($books, $start, BOOKS_PER_PAGE); ?>

<?php include_once("../view/components/slider/slider.php") ?>

<main id="book-displayer">
    <?php foreach ($books as $book): ?>
        <div class="book-card" tabindex="0" onclick="this.querySelector('form>button').click();">
            <form action="./book_display_page.php" method="GET" aria-hidden>
                <input type="hidden" name="book-id" value="<?= $book["id"] ?>" />
                <button type="submit"></button>
            </form>

            <header>
                <p>
                    <?= str_pad(floor($book["price"]), 3, "0", STR_PAD_LEFT) . "." .
                        str_pad(round($book["price"] - floor($book["price"]), 2) * 100, 2, "0", STR_PAD_RIGHT) ?>$
                </p>
                <div class="star-displayer" title="This book has a rating of <?= $book["rating"] * 2 ?>/10.">
                    <div>
                        <?php for ($i = 5; $i > 0; $i--): ?>
                            <span>
                                <?php include("../assets/icons/star.svg") ?>
                            </span>
                        <?php endfor ?>
                    </div>
                    <div>
                        <?php for ($i = $book["rating"]; $i > 0; $i--): ?>
                            <span data-is-half="<?= ($i == 0.5) ? "true" : "" ?>">
                                <?php include("../assets/icons/star.svg") ?>
                            </span>
                        <?php endfor ?>
                    </div>
                </div>
            </header>

            <figure>
                <img src="<?= "./uploads/covers/" . $book["cover_url"] ?>" aria-hidden>
                <img src="<?= "./uploads/covers/" . $book["cover_url"] ?>"
                    alt="The cover of the book &quot;<?= $book["title"] ?>&quot;.">
            </figure>

            <figcaption>
                <h2>
                    <?= $book["title"] ?>
                </h2>
                <?php if (trim($book["author"]) != ""): ?>
                    <p>
                        By
                        <a href="?author=<?= $book["author"] ?>"
                            title="Click to see other books made by <?= $book["author"] ?>.">
                            <?= $book["author"] ?>
                        </a>
                    </p>
                <?php endif ?>
            </figcaption>
        </div>
    <?php endforeach ?>
</main>

<section id="pagination-button-displayer">
    <button class="pagination-step-button" <?= ($pagination_index <= 1) ? "disabled" : "" ?> type="button"
        title="First Page." data-step-type="first">&lt;&lt;</button>
    <button class="pagination-step-button" <?= ($pagination_index <= 1) ? "disabled" : "" ?> type="button"
        title="Previous Page." data-step-type="previous">&lt;</button>

    <?php
    $pagination_buttons = "";
    for ($i = 1; $i <= $maximum_page_count; $i++) {
        $emphasized_class = ($i == $pagination_index) ? "emphasized-button" : "";
        $pagination_buttons .= "
                <button class=\"$emphasized_class\" type=\"button\">$i</button>
            ";
    }

    echo slider(
        $children = $pagination_buttons,
    );
    ?>

    <button class="pagination-step-button" <?= ($pagination_index >= $maximum_page_count) ? "disabled" : "" ?>
        type="button" title="Next Page." data-step-type="next">&gt;</button>
    <button class="pagination-step-button" <?= ($pagination_index >= $maximum_page_count) ? "disabled" : "" ?>
        type="button" title="Last Page." data-step-type="last">&gt;&gt;</button>
</section>