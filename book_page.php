<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/fetch_books.php") ?>
<?php include_once("./view/components/checkbox_field/checkbox_field.php") ?>

<link rel="stylesheet" href="./view/pages/book_page/book_page.css">
<script src="./view/pages/book_page/book_page.js" defer></script>

<main id="book-page">
    <header>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="GET">
            <div id="search-input-field">
                <input type="search" name="search-term" placeholder="Write a book's name...">

                <button class="icon-button simple-button" type="reset" data-svg-active-colour="error">
                    <?php include("./assets/icons/cross.svg") ?>
                </button>
                <button class="icon-button simple-button" type="submit">
                    <?php include("./assets/icons/magnifier.svg") ?>
                </button>
            </div>

            <?= checkbox_field(
                $name = "title",
                $title = "Title",
                $checked = true,
                $optional = true,
                $children = "T",
            ) ?>
            <?= checkbox_field(
                $name = "author",
                $title = "Author",
                $checked = false,
                $optional = true,
                $children = "A",
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