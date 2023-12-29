<?php include_once("./view/layout/head.php") ?>

<?php include_once("./control/signing.php") ?>
<?php include_once("./view/components/input_field/input_field.php") ?>
<?php include_once("./view/components/modal/modal.php") ?>

<?php
$signingMethod = filter_input(INPUT_GET, "signing_method", FILTER_SANITIZE_STRING);
$signingMethod ??= "signing_in";

global $signingError;
global $signingErrorMessage;

$formAction = $_SERVER["PHP_SELF"] . "?signing_method=" . $signingMethod;
$name_ = $name;
?>

<script src="./view/pages/signing_page/signing_page.js" defer></script>
<link rel="stylesheet" href="./view/pages/signing_page/signing_page.css">

<main id="signing-page">
    <?php if ($_SESSION["is_authenticated"] == true): ?>
        <form action="<?= $formAction ?>" method="POST">
            <input type="hidden" name="signing_out" value="1">
            <button id="signing-form-close-button" class="simple-button icon-button" type="button"
                data-svg-active-colour="error">
                <a href="./home_page.php">
                    <?php include("./assets/icons/cross.svg") ?>
                </a>
            </button>
            <h1>Sign out</h1>
            <p>
                You're currently signed in as
                <span class="colourized-text">
                    <?= $_SESSION["user"]["name"] ?>
                    <?= ($_SESSION["user"]["surname"] != null) ? (" " . $_SESSION["user"]["surname"]) : "" ?>
                </span>, do you
                wanna sign out?
            </p>
            <section class="button-displayer">
                <button class="unemphasized-button" type="submit">Sign out</button>
                <button class="emphasized-button" type="button">
                    <a class="uncolourized-text" href="./home_page.php">Go to Homepage</a>
                </button>
            </section>
        </form>
    <?php else: ?>
        <form action="<?= $formAction ?>" method="POST">
            <h1>
                <?= ($signingMethod == "signing_up") ? "Sign up" : "Sign in" ?>
            </h1>

            <main>
                <?php if ($signingMethod == "signing_up"): ?>
                    <input type="hidden" name="signing_up" value="1">
                    <?= input_field(
                        $name = "name",
                        $title = "Name",
                        $type = "text",
                        $value = $name_,
                        $pattern = "\$username\$",
                    ) ?>
                    <?= input_field(
                        $name = "surname",
                        $title = "Surname",
                        $type = "text",
                        $value = $surname,
                        $pattern = "\$username\$",
                        $pattern_message = NULL,
                        $id = "surname",
                        $optional = true,
                    ) ?>
                    <?= input_field(
                        $name = "email",
                        $title = "Email",
                        $type = "email",
                        $value = $email,
                        $pattern = "\$mail\$",
                    ) ?>
                    <?= input_field(
                        $name = "password",
                        $title = "Password",
                        $type = "password",
                        $value = NULL,
                        $pattern = "\$password\$",
                    ) ?>
                    <?= input_field(
                        $name = "confirm-password",
                        $title = "Confirm Password",
                        $type = "password",
                        $value = NULL,
                        $pattern = NULL,
                        $pattern_message = "Confirm password field should contain the same password as the above field.",
                    ) ?>
                <?php else: ?>
                    <input type="hidden" name="signing_in" value="1">
                    <?= input_field(
                        $name = "email",
                        $title = "Email",
                        $type = "email",
                        $value = $email,
                        $pattern = "\$mail\$",
                    ) ?>
                    <?= input_field(
                        $name = "password",
                        $title = "Password",
                        $type = "password",
                        $value = NULL,
                        $pattern = "\$password\$",
                    ) ?>
                <?php endif ?>
            </main>

            <?php if ($signingMethod == "signing_up"): ?>
                <section>
                    <div>
                        <input id="terms-and-conditions-input" type="checkbox" required>
                        <label for="terms-and-conditions-input">
                            I agree to all of the <a href="./">terms and conditions</a>
                        </label>
                    </div>
                </section>
            <?php endif ?>

            <section class="button-displayer">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </section>

            <section>
                <?php if ($signingMethod == "signing_up"): ?>
                    <p>Already have an account? <a href="?signing_method=signing_in">Sign in</a></p>
                <?php else: ?>
                    <p>Doesn't have an account? <a href="?signing_method=signing_up">Sign up</a></p>
                <?php endif ?>
            </section>
        </form>
    <?php endif ?>

    <?php if ($signingError != NULL): ?>
        <?= modal(
            $id = "signing-error",
            $title = $signingError,
            $message = $signingErrorMessage,
        ) ?>
    <?php endif ?>
</main>

<?php include_once("./view/layout/foot.php") ?>