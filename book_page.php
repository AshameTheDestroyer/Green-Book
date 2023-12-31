<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/fetch_genres.php") ?>
<?php include_once("./view/components/slider/slider.php") ?>
<?php include_once("./view/components/drop_down/drop_down.php") ?>
<?php include_once("./view/components/input_field/input_field.php") ?>
<?php include_once("./view/components/checkbox_field/checkbox_field.php") ?>

<link rel="stylesheet" href="./view/pages/book_page/book_page.css">
<script src="./view/pages/book_page/book_page.js" type="module" defer></script>

<main id="book-page">
    <header>
        <?php if ($_SESSION["user"]["is_administrator"] == true): ?>
            <button class="emphasized-button anchor-button">
                <a class="uncolourized-text" href="./publishing_page.php">Publish a Book</a>
            </button>
        <?php endif ?>

        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="GET">
            <div id="search-input-field">
                <input id="search-input" type="search" name="search-term" placeholder="Write a book's name...">

                <button class="icon-button simple-button" type="reset" data-svg-active-colour="error">
                    <?php include("./assets/icons/cross.svg") ?>
                </button>
            </div>

            <?= drop_down(
                $children = file_get_contents("./assets/icons/price.svg") . "<p>Price</p>",
                $drop_down_children = (
                    input_field(
                        $name = "min-price",
                        $title = "Minimum",
                        $type = "number",
                        $value = null,
                        $pattern = null,
                        $pattern_message = null,
                        $id = null,
                        $optional = true,
                        $minimum = 0,
                        $maximum = 1000,
                        $step = 0.01,
                    ) .
                    input_field(
                        $name = "max-price",
                        $title = "Maximum",
                        $type = "number",
                        $value = null,
                        $pattern = null,
                        $pattern_message = null,
                        $id = null,
                        $optional = true,
                        $minimum = 0,
                        $maximum = 1000,
                        $step = 0.01,
                    )
                ),
                $id = "price",
            ) ?>

            <?php
            $selected_genres = filter_input(INPUT_GET, "genres", FILTER_SANITIZE_STRING);
            $genre_checkboxes = "";
            foreach ($genres as $genre) {
                $genre_checkboxes .= checkbox_field(
                    $name = $genre["title"],
                    $title = ucwords($genre["title"]),
                    $checked = in_array($genre["title"], explode(",", $selected_genres)),
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
                $id = "genre",
            );
            ?>

            <?= drop_down(
                $children = file_get_contents("./assets/icons/filter.svg") . "<p>Filters</p>",
                $drop_down_children = (
                    checkbox_field(
                        $name = "title",
                        $title = "Title",
                        $checked = false,
                        $optional = true,
                        $children = file_get_contents("./assets/icons/label.svg"),
                    ) .
                    checkbox_field(
                        $name = "author",
                        $title = "Author",
                        $checked = false,
                        $optional = true,
                        $children = file_get_contents("./assets/icons/pencil.svg"),
                    )
                ),
            ) ?>
        </form>
    </header>

    <main id="book-displayer"></main>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>