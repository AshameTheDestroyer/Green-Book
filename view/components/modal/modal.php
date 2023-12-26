<link rel="stylesheet" href="./view/components/modal/modal.css">
<script src="./view/components/modal/modal.js" defer></script>

<?php
function modal(
    string $id,
    string $title,
    string $message,
) {
    $crossIcon = file_get_contents("./assets/icons/cross.svg");

    echo "
        <div id=\"{$id}-modal-background\" class=\"modal-background\"></div>
        <div id=\"{$id}-modal\" class=\"modal\">
            <div class=\"modal-close-button-container\">
                <button class=\"simple-button icon-button\" type=\"button\" data-svg-active-colour=\"error\">
                    $crossIcon
                </button>
            </div>

            <h1>$title</h1>
            <p>$message</p>
        </div>
    ";
}
?>