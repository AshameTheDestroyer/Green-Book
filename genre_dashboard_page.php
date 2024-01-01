<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/validate_administrator.php") ?>

<?php include_once("./view/components/modal/modal.php") ?>
<?php include_once("./view/components/input_field/input_field.php") ?>
<?php include_once("./view/components/dashboard_table/dashboard_table.php") ?>

<?php
$genre_to_edit_id = filter_input(INPUT_GET, "edit-id", FILTER_SANITIZE_STRING);
$genre_to_edit_name_id = filter_input(INPUT_POST, "genre-to-edit-name-id", FILTER_SANITIZE_STRING);
$genre_new_title = filter_input(INPUT_POST, "genre-new-title", FILTER_SANITIZE_STRING);

$genre_to_edit;
if ($genre_to_edit_id != null) {
    $query = "SELECT * FROM genres WHERE id = $genre_to_edit_id LIMIT 1";
    $result = $connection->execute_query($query);
    $genre_to_edit = $result->fetch_all(MYSQLI_ASSOC)[0];
}

if ($genre_to_edit_name_id != null) {
    $query = "UPDATE genres SET title = '$genre_new_title' WHERE id = '$genre_to_edit_name_id'";
    $connection->execute_query($query);
}
?>

<?php include("./control/fetch_all_genres.php") ?>

<link rel="stylesheet" href="./view/pages/dashboard_page/dashboard_page.css">

<main id="genre-dashboard-page" class="dashboard-page">
    <?= dashboard_table(
        $title = "Genres",
        $table_name = "genres",
        $table = $genres,
        $edit_page = $_SERVER["PHP_SELF"],
    ) ?>
</main>

<?php
if ($genre_to_edit_id != null) {
    $new_title_input = input_field(
        $name = "genre-new-title",
        $title = "New Title",
        $type = "text",
        $value = $genre_to_edit["title"],
    );

    echo modal(
        $id = "genre-edit",
        $title = "Edit Genre Name",
        $message = "Write the new name of the genre.",
        $children = "
                <form action=\"{$_SERVER["PHP_SELF"]}\" method=\"POST\" style=\"place-self: center\">
                    <input name=\"genre-to-edit-name-id\" type=\"hidden\" value=\"$genre_to_edit_id\">
                    $new_title_input
                    <button type=\"submit\">Proceed</button>
                </form>
            ",
    );
}
?>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>