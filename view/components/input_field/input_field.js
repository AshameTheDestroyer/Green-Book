import { default as REGEX_PATTERNS } from "../../../utils/REGEX_PATTERNS.js";


Object.entries(REGEX_PATTERNS).forEach(([patternName, pattern]) => {
    const inputs = [...document.querySelectorAll(`input[pattern=\"\$${patternName}\$\"]`)];
    inputs.forEach(input => {
        input.pattern = pattern.value;
        input.title = pattern.message;
    });
});