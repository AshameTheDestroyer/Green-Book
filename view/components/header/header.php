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

            <section class="button-displayer" data-grid-repeat="3">
                <button class="icon-button simple-button" type="button" data-svg-active-colour="warning">
                    <?php include_once("./assets/icons/star.svg") ?>
                </button>
                <button class="icon-button simple-button" type="button">
                    <?php include_once("./assets/icons/cart.svg") ?>
                </button>
                <button class="icon-button simple-button" type="button" data-svg-active-colour="information">
                    <a href="./signing_page.php">
                        <?php include_once("./assets/icons/user.svg") ?>
                    </a>
                </button>
            </section>
        </main>

        <nav>
            <ul>
                <?php foreach ($anchors as $title => $url): ?>
                    <li>
                        <a class="uncolourized-text" href="<?= $url ?>">
                            <?= $title ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </nav>
    </header>
</div>