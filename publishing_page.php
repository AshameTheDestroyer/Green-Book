<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/validate_administrator.php") ?>

<?php
global $publishingError;
global $publishingErrorMessage;
?>

<?php include_once("./control/publishing.php") ?>
<?php include_once("./view/components/modal/modal.php") ?>
<?php include_once("./view/components/slider/slider.php") ?>
<?php include_once("./view/components/drop_down/drop_down.php") ?>
<?php include_once("./view/components/input_field/input_field.php") ?>
<?php include_once("./view/components/checkbox_field/checkbox_field.php") ?>

<link rel="stylesheet" href="./view/pages/publishing_page/publishing_page.css">

<main id="publishing-page">
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
        <h1>Book Publishing</h1>

        <main>
            <?= input_field(
                $name = "title",
                $title = "Title",
                $type = "text",
                $value = null,
                $pattern = null,
                $pattern_message = null,
                $id = null,
                $optional = false,
                $minimum = null,
                $maximum = null,
                $step = null,
                $accept = null,
                $minimum_length = 0,
                $maximum_length = 32,
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
                $minimum = null,
                $maximum = null,
                $step = null,
                $accept = null,
                $minimum_length = 0,
                $maximum_length = 32,
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
            <?php
            foreach ($genres as $genre) {
                $genre_checkboxes .= checkbox_field(
                    $name = $genre["title"],
                    $title = ucwords($genre["title"]),
                    $checked = false,
                    $optional = true,
                    $children = file_get_contents("./assets/icons/check.svg"),
                );
            }

            $genre_slider = slider(
                $children = $genre_checkboxes,
                $isVerticalNotHorizontal = true,
            );

            echo drop_down(
                $children = file_get_contents("./assets/icons/book.svg") . "<p>Genres</p>",
                $drop_down_children = $genre_slider,
            );
            ?>

            <section id="file-input-container" class="button-displayer">
                <?= input_field(
                    $name = "cover",
                    $title = file_get_contents("./assets/icons/label.svg") . "<p>Upload Cover</p>",
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
                    $title = file_get_contents("./assets/icons/book.svg") . "<p>Upload PDF</p>",
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
            </section>
        </main>

        <section class="button-displayer">
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
        </section>
    </form>

    <?php if ($publishingError != NULL): ?>
        <?= modal(
            $id = "publishing-error",
            $title = $publishingError,
            $message = $publishingErrorMessage,
        ) ?>
    <?php endif ?>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>