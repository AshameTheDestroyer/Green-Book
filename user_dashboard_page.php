<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/validate_administrator.php") ?>

<?php include_once("./view/components/modal/modal.php") ?>
<?php include_once("./view/components/dashboard_table/dashboard_table.php") ?>

<?php
$user_to_edit_id = filter_input(INPUT_GET, "edit-id", FILTER_SANITIZE_STRING);
$user_to_promote_id = filter_input(INPUT_POST, "user-to-promote-id", FILTER_SANITIZE_STRING);
$user_to_revoke_id = filter_input(INPUT_POST, "user-to-revoke-id", FILTER_SANITIZE_STRING);

$user_to_edit;
if ($user_to_edit_id != null) {
    $query = "SELECT * FROM users WHERE id = $user_to_edit_id LIMIT 1";
    $result = $connection->execute_query($query);
    $user_to_edit = $result->fetch_all(MYSQLI_ASSOC)[0];
}

if ($user_to_promote_id != null) {
    $query = "UPDATE users SET is_administrator = TRUE WHERE id = '$user_to_promote_id'";
    $connection->execute_query($query);
    header("location: " . $_SERVER["PHP_SELF"]);
}

if ($user_to_revoke_id != null) {
    $query = "UPDATE users SET is_administrator = NULL WHERE id = '$user_to_revoke_id'";
    $connection->execute_query($query);
    header("location: " . $_SERVER["PHP_SELF"]);
}
?>

<?php include_once("./control/fetch_all_users.php") ?>

<link rel="stylesheet" href="./view/pages/dashboard_page/dashboard_page.css">

<main id="user-dashboard-page" class="dashboard-page">
    <?= dashboard_table(
        $title = "Users",
        $table_name = "users",
        $table = $users,
        $edit_page = $_SERVER["PHP_SELF"],
    ) ?>
</main>

<?php
if ($user_to_edit_id != null) {
    $unauthorized_self_permission_revoking_modal = modal(
        $id = "edit-user",
        $title = "Unauthorized Self Permission Revoking",
        $message = "An administrator cannot revoke their own permissions.",
    );

    $grant_user_permission_modal = modal(
        $id = "edit-user",
        $title = "Grant User Permissions",
        $message = "Do you wanna set this user to administrator?",
        $children = "
                <form action=\"{$_SERVER["PHP_SELF"]}\" method=\"POST\">
                    <input name=\"user-to-promote-id\" type=\"hidden\" value=\"$user_to_edit_id\">
                    <button type=\"submit\">Proceed</button>
                </form>
            ",
    );

    $revoke_user_permission_modal = modal(
        $id = "edit-user",
        $title = "Revoke User Permissions",
        $message = "Do you wanna set this user to a normal user?",
        $children = "
                    <form action=\"{$_SERVER["PHP_SELF"]}\" method=\"POST\">
                        <input name=\"user-to-revoke-id\" type=\"hidden\" value=\"$user_to_edit_id\">
                        <button type=\"submit\">Proceed</button>
                    </form>
                ",
    );

    $unauthorized_permission_revoking_modal = modal(
        $id = "edit-user",
        $title = "Unauthorized Permission Revoking",
        $message = "An administrator cannot revoke another administrator's permissions unless they're the owner of the website."
    );

    if ($user_to_edit_id == $_SESSION["user"]["id"]) {
        echo $unauthorized_self_permission_revoking_modal;
    } elseif (!$user_to_edit["is_administrator"]) {
        echo $grant_user_permission_modal;
    } elseif ($_SESSION["user"]["is_owner"]) {
        echo $revoke_user_permission_modal;
    } else {
        echo $unauthorized_permission_revoking_modal;
    }
}
?>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>