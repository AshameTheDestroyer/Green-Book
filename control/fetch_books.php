<?php
$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "green_book";
$connection = new mysqli($serverName, $username, $password, $databaseName);
if ($connection->connect_error) {
    die("Connection has failed: " . $connection->connect_error);
}

$pagination_index = filter_input(INPUT_GET, "pagination_index", FILTER_SANITIZE_STRING) ?? "1";

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

$connection->close();
?>

<main id="book-displayer">
    <?php foreach ($books as $book): ?>
        <div class="book-card" tabindex="0" onclick="this.querySelector('form>button').click();">
            <form action="./book_page.php" method="GET" aria-hidden>
                <input type="hidden" name="book_id" value="<?= $book["id"] ?>" />
                <button type="submit"></button>
            </form>

            <header>
                <p>
                    <?= $book["price"] ?>$
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
    <?= $pagination_index ?>
</section>