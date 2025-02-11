document.querySelectorAll(".toggle-password").forEach(button => {
    button.addEventListener("click", function () {
        let passwordInput = this.previousElementSibling;
        let icon = this.querySelector(".material-icons");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.textContent = "visibility";
        } else {
            passwordInput.type = "password";
            icon.textContent = "visibility_off";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("password_confirmation");

    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");

    emailInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            emailError.textContent = "* Email is required.";
            emailError.style.color = "red";
        } else {
            emailError.textContent = "";
        }
    });

    passwordInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            passwordError.textContent = "* Password is required.";
            passwordError.style.color = "red";
        } else if (this.value.length < 6) {
            passwordError.textContent = "* Password must be at least 6 characters.";
            passwordError.style.color = "red";
        } else {
            passwordError.textContent = "";
        }
    });

    confirmPasswordInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            confirmPasswordError.textContent = "* Confirm Password is required.";
            confirmPasswordError.style.color = "red";
        } else if (this.value !== passwordInput.value) {
            confirmPasswordError.textContent = "* Passwords do not match.";
            confirmPasswordError.style.color = "red";
        } else {
            confirmPasswordError.textContent = "";
        }
    });
});
