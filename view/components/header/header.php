<?php
$dashboards = [
    file_get_contents("./assets/icons/user.svg") . "<p>Users</p>" => "./user_dashboard_page.php",
    file_get_contents("./assets/icons/book.svg") . "<p>Books</p>" => "./book_dashboard_page.php",
    file_get_contents("./assets/icons/label.svg") . "<p>Genres</p>" => "./genre_dashboard_page.php",
    file_get_contents("./assets/icons/price.svg") . "<p>Wishlists</p>" => "./wishlist_dashboard_page.php",
];
?>

<?php include_once("./control/fetch_all_genres.php") ?>
<?php include_once("./view/components/slider/slider.php") ?>

<div class="fragment" data-create-portal="body" data-portal-index="0">
    <link rel="stylesheet" href="./view/components/header/header.css">
    <script src="./view/components/header/header.js" defer></script>

    <header id="main-header">
        <main>
            <figure id="logo" title="Go Home">
                <h1>
                    <a class="stroked-text undecorated-text" href="./home_page.php">Green Book</a>
                </h1>
            </figure>

            <section class="button-displayer" data-grid-repeat="<?= ($_SESSION["user"]["is_administrator"]) ? 4 : 3 ?>">
                <button class="icon-button simple-button" type="button" title="Ratings"
                    data-svg-active-colour="warning">
                    <?php include_once("./assets/icons/star.svg") ?>
                </button>
                <button class="icon-button simple-button" type="button" title="Cart">
                    <a href="./cart_page.php">
                        <?php include_once("./assets/icons/cart.svg") ?>
                    </a>
                </button>
                <button class="icon-button simple-button" type="button" title="Account"
                    data-svg-active-colour="information">
                    <a href="./signing_page.php">
                        <?php include_once("./assets/icons/user.svg") ?>
                    </a>
                </button>
                <?php if ($_SESSION["user"]["is_administrator"]): ?>
                    <button id="dashboard-navigation-bar-toggling-button" class="icon-button simple-button" type="button"
                        title="Dashboards" data-svg-active-colour="required">
                        <?php include_once("./assets/icons/dashboard.svg") ?>
                    </button>
                <?php endif ?>
            </section>
        </main>

        <nav id="main-navigation-bar">
            <?php
            $genre_anchors = "";
            $genres_and_all = $genres;
            array_unshift($genres_and_all, ["title" => "all"]);
            foreach ($genres_and_all as $genre) {
                $genre_rendered_title = ucwords($genre["title"]);
                $genre_anchors .= "
                        <li>
                            <a class=\"uncolourized-text\" href=\"./book_page.php?genres={$genre["title"]}\">
                                $genre_rendered_title
                            </a>
                        </li>
                    ";
            }

            echo slider(
                $children = $genre_anchors,
                $isVerticalNotHorizontal = false,
                $isUnorderedList = true,
            );
            ?>
        </nav>

        <?php if ($_SESSION["user"]["is_administrator"]): ?>
            <nav id="dashboard-navigation-bar" data-create-portal="body" data-portal-index="1">
                <div>
                    <button id="dashboard-navigation-bar-close-button" class="emphasized-button simple-button icon-button"
                        type="button" data-svg-active-colour="error">
                        <?php include("./assets/icons/cross.svg") ?>
                    </button>
                </div>
                <?php
                $dashboard_anchors = "";
                foreach ($dashboards as $title => $url) {
                    $dashboard_anchors .= "
                        <li>
                            <a class=\"uncolourized-text\" href=\"$url\">
                                $title
                            </a>
                        </li>
                    ";
                }

                echo slider(
                    $children = $dashboard_anchors,
                    $isVerticalNotHorizontal = true,
                    $isUnorderedList = true,
                );
                ?>
            </nav>
        <?php endif ?>
    </header>
</div>