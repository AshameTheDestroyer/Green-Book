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
        const button = inputField.querySelector("button");

        if (e.target.value.trim() != "") {
            inputField.setAttribute("data-uploaded-file", e.target.value.trim());
            button.classList.add("emphasized-button");
            return;
        }

        inputField.removeAttribute("data-uploaded-file");
        button.classList.remove("emphasized-button");
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