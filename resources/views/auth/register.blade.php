@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>

@section('content')

    <img class="icon" alt="Register Icon" src="{{ asset('images/Register.png') }}">

    <div class="container">
        <div class="register-box">
            <h2>Registration</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                <div id="emailError" class="error-message"></div>
                @error('email')
                <div class="error-message">* {{ $message }}</div>
                @enderror

                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <button type="button" class="toggle-password">
                        <span class="material-icons">visibility_off</span>
                    </button>
                </div>
                <div id="passwordError" class="error-message"></div>
                @error('password')
                <div class="error-message">* {{ $message }}</div>
                @enderror

                <label for="confirm-password">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" id="confirm-password" name="password_confirmation" placeholder="Confirm your password">
                    <button type="button" class="toggle-password">
                        <span class="material-icons">visibility_off</span>
                    </button>
                </div>
                <div id="confirmPasswordError" class="error-message"></div>
                @error('password_confirmation')
                <div class="error-message">* {{ $message }}</div>
                @enderror

                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first_name" placeholder="Enter first name" value="{{ old('first_name') }}">
                <div id="firstNameError" class="error-message"></div>
                @error('first_name')
                <div class="error-message">* {{ $message }}</div>
                @enderror

                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last_name" placeholder="Enter last name" value="{{ old('last_name') }}">
                <div id="lastNameError" class="error-message"></div>
                @error('last_name')
                <div class="error-message">* {{ $message }}</div>
                @enderror

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter phone number" value="{{ old('phone') }}">
                <div id="phoneError" class="error-message"></div>
                @error('phone')
                <div class="error-message">* {{ $message }}</div>
                @enderror

                <button type="submit" class="register-btn">SIGN UP</button>
            </form>

            <p class="login-link">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </div>

    <script>
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
    </script>

@endsection
