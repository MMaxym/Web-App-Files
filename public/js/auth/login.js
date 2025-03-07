document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("password");
    const icon = this.querySelector(".material-icons");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.textContent = "visibility";
    }
    else {
        passwordInput.type = "password";
        icon.textContent = "visibility_off";
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

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
        } else {
            passwordError.textContent = "";
        }
    });
});
