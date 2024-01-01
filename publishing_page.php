<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/validate_administrator.php") ?>

<?php
global $publishingError;
global $publishingErrorMessage;

$book_id = filter_input(INPUT_GET, "edit-id", FILTER_SANITIZE_STRING);
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

<?php include_once("./control/publishing.php") ?>
<?php include_once("./view/components/modal/modal.php") ?>
<?php include_once("./view/components/slider/slider.php") ?>
<?php include_once("./view/components/drop_down/drop_down.php") ?>
<?php include_once("./view/components/input_field/input_field.php") ?>
<?php include_once("./view/components/checkbox_field/checkbox_field.php") ?>

<link rel="stylesheet" href="./view/pages/publishing_page/publishing_page.css">

<main id="publishing-page">
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
        <h1>Book Publishing</h1>

        <main>
            <?php if ($book_id != null): ?>
                <input name="book-to-edit-id" type="hidden" value="<?= $book_id ?>" />
            <?php endif ?>

            <?= input_field(
                $name = "title",
                $title = "Title",
                $type = "text",
                $value = $book["title"],
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = null,
                $maximum = null,
                $step = null,
                $accept = null,
                $minimum_length = 0,
                $maximum_length = 32,
            ) ?>
            <?= input_field(
                $name = "author",
                $title = "Author",
                $type = "text",
                $value = $book["author"],
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = true,
                $minimum = null,
                $maximum = null,
                $step = null,
                $accept = null,
                $minimum_length = 0,
                $maximum_length = 32,
            ) ?>
            <?= input_field(
                $name = "price",
                $title = "Price",
                $type = "number",
                $value = $book["price"] ?? "10.99",
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = 0,
                $maximum = 1000,
                $step = 0.01,
            ) ?>
            <?= input_field(
                $name = "page-count",
                $title = "Page Count",
                $type = "number",
                $value = $book["page_count"] ?? "10",
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = 10,
                $maximum = 2000,
            ) ?>
            <?= input_field(
                $name = "rating",
                $title = "Rating",
                $type = "number",
                $value = $book["rating"] ?? "5",
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = 0,
                $maximum = 10,
            ) ?>
            <?php
            foreach ($genres as $genre) {
                $genre_checkboxes .= checkbox_field(
                    $name = $genre["title"],
                    $title = ucwords($genre["title"]),
                    $checked = ($book_genres != null) ? in_array($genre, $book_genres) : false,
                    $optional = true,
                    $children = file_get_contents("./assets/icons/check.svg"),
                );
            }

            $genre_slider = slider(
                $children = $genre_checkboxes,
                $isVerticalNotHorizontal = true,
            );

            echo drop_down(
                $children = file_get_contents("./assets/icons/book.svg") . "<p>Genres</p>",
                $drop_down_children = $genre_slider,
            );
            ?>

            <?php if ($book_id == null): ?>
                <section id="file-input-container" class="button-displayer">
                    <?= input_field(
                        $name = "cover",
                        $title = file_get_contents("./assets/icons/label.svg") . "<p>Upload Cover</p>",
                        $type = "file",
                        $value = null,
                        $pattern = null,
                        $pattern_message = null,
                        $id = null,
                        $optional = false,
                        $minimum = null,
                        $maximum = null,
                        $step = null,
                        $accept = "image/*",
                    ) ?>
                    <?= input_field(
                        $name = "pdf",
                        $title = file_get_contents("./assets/icons/book.svg") . "<p>Upload PDF</p>",
                        $type = "file",
                        $value = null,
                        $pattern = null,
                        $pattern_message = null,
                        $id = null,
                        $optional = false,
                        $minimum = null,
                        $maximum = null,
                        $step = null,
                        $accept = "application/msword, text/plain, application/pdf",
                    ) ?>
                </section>
            <?php endif ?>
        </main>

        <section class="button-displayer">
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
        </section>
    </form>

    <?php if ($publishingError != NULL): ?>
        <?= modal(
            $id = "publishing-error",
            $title = $publishingError,
            $message = $publishingErrorMessage,
        ) ?>
    <?php endif ?>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>