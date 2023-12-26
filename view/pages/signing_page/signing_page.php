<?php include_once("./control/signing.php") ?>
<?php include("./view/components/input_field/input_field.php") ?>
<?php include("./view/components/modal/modal.php") ?>

<script src="./view/pages/signing_page/signing_page.js" defer></script>

<?php
$signingMethod = filter_input(INPUT_GET, "signing_method", FILTER_SANITIZE_STRING);
$signingMethod ??= "signing_in";

global $signingError;
global $signingErrorMessage;

$formAction = $_SERVER["PHP_SELF"] . "?signing_method=" . $signingMethod;

$name_ = $name;
?>

<link rel="stylesheet" href="./view/pages/signing_page/signing_page.css">

<main id="signing-page">
    <?php if ($signingMethod == "signing_up"): ?>
        <form action=<?= $formAction ?> method="POST">
            <h1>Sign up</h1>
            <input type="hidden" name="signing_up" value="1">
            <main>
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
                    $patternMessage = NULL,
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
                    $patternMessage = "Confirm password field should contain the same password as the above field.",
                ) ?>
            </main>
            <section>
                <div>
                    <input id="terms-and-conditions-input" type="checkbox" required>
                    <label for="terms-and-conditions-input">
                        I agree to all of the <a href="./">terms and conditions</a>
                    </label>
                </div>
            </section>
            <section class="button-displayer">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </section>
            <section>
                <p>Already have an account? <a href="./?signing_method=signing_in">Sign in</a></p>
            </section>
        </form>
    <?php elseif ($signingMethod == "signing_in"): ?>
        <form action=<?= $formAction ?> method="POST">
            <h1>Sign in</h1>
            <input type="hidden" name="signing_in" value="1">
            <main>
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
            </main>
            <section class="button-displayer">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </section>
            <section>
                <p>Doesn't have an account? <a href="./?signing_method=signing_up">Sign up</a></p>
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