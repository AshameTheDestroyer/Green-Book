<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/validate_administrator.php") ?>

<?php include_once("./control/fetch_all_users.php") ?>
<?php include_once("./view/components/dashboard_table/dashboard_table.php") ?>

<link rel="stylesheet" href="./view/pages/dashboard_page/dashboard_page.css">

<main id="user-dashboard-page" class="dashboard-page">
    <?= dashboard_table(
        $title = "Users",
        $table = $users,
    ) ?>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>