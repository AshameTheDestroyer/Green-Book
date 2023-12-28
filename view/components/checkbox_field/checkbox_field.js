const checkboxFields = [...document.querySelectorAll(".checkbox-field")];
checkboxFields.forEach(checkboxField => {
    const
        button = checkboxField.querySelector("button"),
        checkbox = checkboxField.querySelector("input");

    button.addEventListener("click", _e => {
        checkbox.click();
    });

    checkbox.addEventListener("change", OnCheckboxChange);

    function OnCheckboxChange(_e) {
        if (checkbox.checked) { button.classList.add("emphasized-button"); return; }
        button.classList.remove("emphasized-button");
    }
});