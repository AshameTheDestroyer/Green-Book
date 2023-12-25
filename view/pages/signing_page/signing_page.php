<?php include_once("./control/signing.php") ?>
<?php include("./view/components/input_field/input_field.php") ?>

<link rel="stylesheet" href="./view/pages/signing_page/signing_page.css">

<main id="signing-page">
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
        <h1>Sign up</h1>
        <input type="hidden" name="signing_up" value="1">
        <main>
            <?= input_field(
                $title = "Name",
                $name = "name",
            ) ?>
            <?= input_field(
                $title = "Surname",
                $name = "surname",
            ) ?>
            <?= input_field(
                $name = "email",
                $type = "email",
                $title = "Email",
            ) ?>
            <?= input_field(
                $name = "password",
                $type = "password",
                $title = "Password",
            ) ?>
            <?= input_field(
                $name = "confirm-password",
                $type = "password",
                $title = "Confirm Password",
            ) ?>
        </main>
        <section>
            <div>
                <input id="terms-and-conditions-input" type="checkbox" required>
                <label for="terms-and-conditions-input">
                    I agree to all of the <a href="">terms and conditions</a>
                </label>
            </div>
        </section>
        <section class="button-displayer" data-is-vertical>
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
        </section>
    </form>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
        <h1>Sign in</h1>
        <input type="hidden" name="signing_in" value="1">
        <main>
            <?= input_field(
                $name = "email",
                $type = "email",
                $title = "Email",
            ) ?>
            <?= input_field(
                $name = "password",
                $type = "password",
                $title = "Password",
            ) ?>
        </main>
        <section class="button-displayer">
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
        </section>
    </form>
</main>