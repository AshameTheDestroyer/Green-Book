<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/fetch_books.php") ?>
<?php include_once("./control/fetch_genres.php") ?>
<?php include_once("./view/components/input_field/input_field.php") ?>
<?php include_once("./view/components/checkbox_field/checkbox_field.php") ?>
<?php include_once("./view/components/drop_down/drop_down.php") ?>

<link rel="stylesheet" href="./view/pages/book_page/book_page.css">
<script src="./view/pages/book_page/book_page.js" defer></script>

<main id="book-page">
    <header>
        <?php if ($_SESSION["user"]["is_administrator"] == true): ?>
            <button class="emphasized-button anchor-button">
                <a class="uncolourized-text" href="./publishing_page.php">Publish a Book</a>
            </button>
        <?php endif ?>

        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="GET">
            <div id="search-input-field">
                <input type="search" name="search-term" onkeyup="searchBooks(this.value)" placeholder="Write a book's name...">

                <button class="icon-button simple-button" type="reset" data-svg-active-colour="error">
                    <?php include("./assets/icons/cross.svg") ?>
                </button>
                <button class="icon-button simple-button" type="submit">
                    <?php include("./assets/icons/magnifier.svg") ?>
                </button>
            </div>
            <script>
                var mainContent;
                onload = ()=> {mainContent = document.getElementById("book-displayer").innerHTML;}
                function searchBooks(str) {
                    if (str == ""){
                        document.getElementById("book-displayer").innerHTML = mainContent;
                    }
                    else{
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = () => {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                document.getElementById("book-displayer").innerHTML = xmlhttp.responseText? xmlhttp.responseText:'<h3 style="color:#00e25e">No result</h3>';
                            }
                        };
                        xmlhttp.open("GET", "view/pages/book_page/searchBooks.php?q=" + str, true);
                        xmlhttp.send();
                    }
                    console.log(mainContent);
                }
            </script>

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
            $genre_checkboxes = "";

            foreach ($genres as $genre) {
                $genre_checkboxes .= checkbox_field(
                    $name = $genre["title"],
                    $title = ucwords($genre["title"]),
                    $checked = false,
                    $optional = true,
                    $children = file_get_contents("./assets/icons/check.svg"),
                );
            }

            echo drop_down(
                $children = file_get_contents("./assets/icons/book.svg") . "<p>Genres</p>",
                $drop_down_children = $genre_checkboxes,
            );
            ?>

            <?= drop_down(
                $children = file_get_contents("./assets/icons/filter.svg") . "<p>Filters</p>",
                $drop_down_children = (
                    checkbox_field(
                        $name = "title",
                        $title = "Title",
                        $checked = true,
                        $optional = true,
                        $children = file_get_contents("./assets/icons/label.svg"),
                    ) .
                    checkbox_field(
                        $name = "author",
                        $title = "Author",
                        $checked = true,
                        $optional = true,
                        $children = file_get_contents("./assets/icons/pencil.svg"),
                    )
                ),
            ) ?>
        </form>
    </header>

    <main id="book-displayer">
        <?php foreach ($books as $book): ?>
            <div class="book-card" tabindex="0">
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="GET" aria-hidden>
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
                    <img src="<?= $book["cover_url"] ?>" alt="The cover of the book &quot;<?= $book["title"] ?>&quot;.">
                </figure>

                <figcaption>
                    <h2>
                        <?= $book["title"] ?>
                    </h2>
                    <p>
                        By
                        <a href="?author=<?= $book["author"] ?>"
                            title="Click to see other books made by <?= $book["author"] ?>.">
                            <?= $book["author"] ?>
                        </a>
                    </p>
                </figcaption>
            </div>
        <?php endforeach ?>
    </main>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>