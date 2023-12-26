const
    passwordInput = document.querySelector("#password-input"),
    confirmPasswordInput = document.querySelector("#confirm-password-input");

if (confirmPasswordInput != null) {
    passwordInput.addEventListener("change", e => confirmPasswordInput.pattern = e.target.value);
}