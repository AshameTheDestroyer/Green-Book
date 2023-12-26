<?php
$anchors = [
    "Users" => "./user_page.php",
    "Books" => "./book_page.php",
    "Cart" => "./cart_page.php",
];
?>

<div class="fragment" data-create-portal="body" data-portal-index="0">
    <link rel="stylesheet" href="view/components/header/header.css">

    <header id="main-header">
        <main>
            <figure id="logo">
                <h1>
                    <a class="stroked-text undecorated-text" href="./home_page.php">Green Book</a>
                </h1>
            </figure>

            <form id="search-form">
                <input type="search" placeholder="Write a book's name...">

                <button class="icon-button simple-button" type="reset">
                    <?php include("./assets/icons/cross.svg") ?>
                </button>
                <button class="icon-button simple-button" type="submit">
                    <?php include("./assets/icons/magnifier.svg") ?>
                </button>
            </form>

            <section class="button-displayer" data-grid-repeat="3">
                <button class="icon-button simple-button" type="button">
                    <?php include_once("./assets/icons/star.svg") ?>
                </button>
                <button class="icon-button simple-button" type="button">
                    <?php include_once("./assets/icons/cart.svg") ?>
                </button>
                <button class="icon-button simple-button" type="button">
                    <a href="./signing_page.php">
                        <?php include_once("./assets/icons/user.svg") ?>
                    </a>
                </button>
            </section>
        </main>

        <nav>
            <ul>
                <?php foreach ($anchors as $title => $url): ?>
                    <li><a class="uncolourized-text" href=<?= $url ?>><?= $title ?></a></li>
                <?php endforeach ?>
            </ul>
        </nav>
    </header>
</div>