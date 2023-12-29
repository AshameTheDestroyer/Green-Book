<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php
if ($_SESSION["user"]["is_administrator"] == null) {
    header("location: index.php");
}
?>

<?php include_once("./view/components/input_field/input_field.php") ?>

<link rel="stylesheet" href="./view/pages/publishing_page/publishing_page.css">

<main id="publishing-page">
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
        <h1>Book Publishing</h1>

        <main>
            <?= input_field(
                $name = "title",
                $title = "Title",
            ) ?>
            <?= input_field(
                $name = "author",
                $title = "Author",
                $type = "text",
                $value = null,
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = true,
            ) ?>
            <?= input_field(
                $name = "price",
                $title = "Price",
                $type = "number",
                $value = "10.99",
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = 0,
                $maximum = 1000,
                $step = 0.01,
            ) ?>
            <?= input_field(
                $name = "page-count",
                $title = "Page Count",
                $type = "number",
                $value = "10",
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = 10,
                $maximum = 2000,
            ) ?>
            <?= input_field(
                $name = "rating",
                $title = "Rating",
                $type = "number",
                $value = "5",
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = 0,
                $maximum = 10,
            ) ?>
            <?= input_field(
                $name = "cover",
                $title = "Upload Cover",
                $type = "file",
                $value = null,
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = null,
                $maximum = null,
                $step = null,
                $accept = "image/*",
            ) ?>
            <?= input_field(
                $name = "pdf",
                $title = "Upload PDF",
                $type = "file",
                $value = null,
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = null,
                $maximum = null,
                $step = null,
                $accept = "application/msword, text/plain, application/pdf",
            ) ?>
        </main>

        <section class="button-displayer">
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
        </section>
    </form>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>