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

            <section>
                <input type="search" placeholder="Write a book's name...">
            </section>

            <section class="button-displayer" data-grid-repeat="3">
                <button class="icon-button simple-button" type="button">F</button>
                <button class="icon-button simple-button" type="button">C</button>
                <button class="icon-button simple-button" type="button">U</button>
            </section>
        </main>

        <nav>
            <ul>
                <?php foreach ($anchors as $title => $url): ?>
                    <li><a class="uncolourized-text" href=<?= $url ?>><?= $title ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>
</div>