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
fileInputFields.forEach(inputField =>
    inputField.querySelector("input").addEventListener("change", e => {
        inputField.setAttribute("data-uploaded-file", e.target.value);
        inputField.querySelector("button").classList.add("emphasized-button");
    }),
);

const forms = [...document.querySelectorAll("form")];
forms.forEach(form => form.addEventListener("reset", _e =>
    [...form.querySelectorAll(".input-field[data-is-file-input]")]
        .forEach(inputField => {
            inputField.removeAttribute("data-uploaded-file");
            inputField.querySelector("button").classList.remove("emphasized-button");
        }),
));