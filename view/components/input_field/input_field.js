import { default as REGEX_PATTERNS } from "../../../utils/REGEX_PATTERNS.js";

Object.entries(REGEX_PATTERNS).forEach(([patternName, pattern]) => {
    const inputs = [...document.querySelectorAll(`input[pattern=\"\$${patternName}\$\"]`)];
    inputs.forEach(input => {
        input.pattern = pattern.value;
        input.title = pattern.message;
    });
});

const labelContainerButtons = [...document.querySelectorAll(".label-container-button")];
labelContainerButtons.forEach(button => button.addEventListener("click", e =>
    (e.target == button) && button.querySelector("label").click(),
));

const fileInputFields = [...document.querySelectorAll(".input-field[data-is-file-input]")];
fileInputFields.forEach(inputField => {
    const input = inputField.querySelector("input");

    input.addEventListener("change", _e => updateFileInputField(inputField));
    updateFileInputField(inputField);

    input.value = input.defaultValue;
});

function updateFileInputField(inputField) {
    const
        input = inputField.querySelector("input"),
        button = inputField.querySelector("button"),
        value = input.value?.trim() ?? "",
        defaultValue = input.defaultValue?.trim() ?? "";

    if (value != "" || defaultValue != "") {
        inputField.setAttribute("data-uploaded-file", value);
        button.classList.add("emphasized-button");
        return;
    }

    inputField.removeAttribute("data-uploaded-file");
    button.classList.remove("emphasized-button");
}

const forms = [...document.querySelectorAll("form")];
forms.forEach(form => form.addEventListener("reset", _e =>
    [...form.querySelectorAll(".input-field[data-is-file-input]")]
        .forEach(inputField => {
            inputField.removeAttribute("data-uploaded-file");
            inputField.querySelector("button").classList.remove("emphasized-button");
        }),
));