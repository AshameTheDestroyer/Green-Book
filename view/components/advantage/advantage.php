<?php
function advantage(
    $title,
    $text,
    $icon
):string{
    return"
        <div class='advantage'>
            <div class='icone-container'>
                <h1 class='$icon'></h1>
            </div>
            <div>
                <h4>$title</h4>
                <p>$text</p>
            </div>
        </div>
    ";
}
?>