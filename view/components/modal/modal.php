<link rel="stylesheet" href="./view/components/modal/modal.css">
<script src="./view/components/modal/modal.js" defer></script>

<?php
function modal(
    string $id,
    string $title,
    string $message,
) {
    echo "
        <div id=\"{$id}-modal-background\" class=\"modal-background\"></div>
        <div id=\"{$id}-modal\" class=\"modal\">
            <div class=\"modal-close-button-container\">
                <button class=\"modal-close-button simple-button icon-button\" type=\"button\">X</button>
            </div>

            <h1>$title</h1>
            <p>$message</p>
        </div>
    ";
}
?>