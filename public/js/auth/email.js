document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("emailError");

    emailInput.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            emailError.textContent = "* Email is required.";
            emailError.style.color = "red";
        } else if (!this.value.includes('@')) {
            emailError.textContent = "* Please enter a valid email address.";
            emailError.style.color = "red";
        } else {
            emailError.textContent = "";
        }
    });
});
