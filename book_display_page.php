<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php
$book_id = filter_input(INPUT_GET, "book-id", FILTER_SANITIZE_STRING);

$book;
$book_genres;
if ($book_id != null) {
    $query = "SELECT * FROM books WHERE id = '$book_id' LIMIT 1";
    $result = $connection->execute_query($query);
    $book = $result->fetch_all(MYSQLI_ASSOC)[0];

    $query = "
        SELECT genres.id, genres.title FROM books_to_genres
        JOIN genres ON books_to_genres.genre_id = genres.id
        JOIN books ON books_to_genres.book_id = books.id
        WHERE books.id = $book_id
    ";
    $result = $connection->execute_query($query);
    $book_genres = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<?php include_once("./view/components/input_field/input_field.php") ?>

<link rel="stylesheet" href="./view/pages/book_display_page/book_display_page.css">

<main id="book-display-page">
    <?php if ($book != null): ?>
        <div class="book-card" tabindex="0" onclick="this.querySelector('form>button').click();">
            <form action="./book_display_page.php" method="GET" aria-hidden>
                <input type="hidden" name="book_id" value="<?= $book["id"] ?>" />
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
                                <?php include("./assets/icons/star.svg") ?>
                            </span>
                        <?php endfor ?>
                    </div>
                    <div>
                        <?php for ($i = $book["rating"]; $i > 0; $i--): ?>
                            <span data-is-half="<?= ($i == 0.5) ? "true" : "" ?>">
                                <?php include("./assets/icons/star.svg") ?>
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
                <p>
                    <?= $book["title"] ?>
                </p>
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

        <section>
            <div>
                <div class="colourized-text">Title:</div>
                <div>
                    <?= $book["title"] ?>
                </div>
            </div>
            <div>
                <div class="colourized-text">Author:</div>
                <div>
                    <?= $book["author"] ?>
                </div>
            </div>
            <div id="genre-displayer">
                <div class="colourized-text">Genres:</div>
                <?php foreach ($book_genres as $genre): ?>
                    <div>
                        <?= $genre["title"] ?>
                    </div>
                <?php endforeach ?>
            </div>

            <form action="./control/add_to_cart.php" method="POST">
                <input name="book-id" type="hidden" value="<?= $book["id"] ?>">
                <input name="user-id" type="hidden" value="<?= $_SESSION["user"]["id"]; ?>">

                <?= input_field(
                    $name = "bought-amount",
                    $title = "Bought Amount",
                    $type = "number",
                    $value = 1,
                    $pattern = null,
                    $pattern_message = null,
                    $id = null,
                    $optional = false,
                    $minimum = 1,
                    $maximum = 99,
                ) ?>

                <section class="button-displayer">
                    <button type="reset">Reset</button>
                    <button type="submit">Add to Cart</button>
                </section>
            </form>
        </section>
    <?php else: ?>
        <main id="book-display-message">
            <section>
                <h1>Book Not Found</h1>
                <p>The book you're looking for doesn't exist.</p>
            </section>
        </main>
    <?php endif ?>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>