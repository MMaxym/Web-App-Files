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

document.getElementById('phone').addEventListener('input', function (e) {
    let value = e.target.value;
    value = value.replace(/[^0-9+]/g, '');

    if ((value.match(/\+/g) || []).length > 1) {
        value = value.replace(/\+/g, '');
    }

    if (value.length > 13) {
        value = value.substring(0, 13);
    }
    e.target.value = value;
});

document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm-password");
    const firstNameInput = document.getElementById("first-name");
    const lastNameInput = document.getElementById("last-name");
    const phoneInput = document.getElementById("phone");

    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    const firstNameError = document.getElementById("firstNameError");
    const lastNameError = document.getElementById("lastNameError");
    const phoneError = document.getElementById("phoneError");

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
        }
        else if (this.value.length < 6) {
            passwordError.textContent = "* Password must be at least 6 characters.";
            passwordError.style.color = "red";
        }
        else {
            passwordError.textContent = "";
        }
    });

    confirmPasswordInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            confirmPasswordError.textContent = "* Confirm Password is required.";
            confirmPasswordError.style.color = "red";
        }
        else if (this.value !== passwordInput.value) {
            confirmPasswordError.textContent = "* Passwords do not match.";
            confirmPasswordError.style.color = "red";
        } else {
            confirmPasswordError.textContent = "";
        }
    });

    firstNameInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            firstNameError.textContent = "* First Name is required.";
            firstNameError.style.color = "red";
        } else {
            firstNameError.textContent = "";
        }
    });

    lastNameInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            lastNameError.textContent = "* Last Name is required.";
            lastNameError.style.color = "red";
        } else {
            lastNameError.textContent = "";
        }
    });

    phoneInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            phoneError.textContent = "* Phone Number is required.";
            phoneError.style.color = "red";
        } else {
            phoneError.textContent = "";
        }
    });
});
