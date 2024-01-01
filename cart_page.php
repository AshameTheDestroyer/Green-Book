<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/fetch_user_reserved_books.php") ?>
<?php include_once("./view/components/dashboard_table/dashboard_table.php") ?>

<link rel="stylesheet" href="./view/pages/dashboard_page/dashboard_page.css">

<main id="wishlist-dashboard-page" class="dashboard-page">
    <?= dashboard_table(
        $title = "Wishlists",
        $table_name = "reserved_books",
        $table = $reserved_books,
        $edit_page = "",
        $no_edit_button = true,
    ) ?>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>