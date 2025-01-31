@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/reset.css') }}">
</head>

@section('content')

    <img class="icon" alt="Password Update Icon" src="{{ asset('images/Email.png') }}">
    <div class="container">
        <div class="reset-box">
            <h2>Update Password</h2>
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                @if (session('status'))
                    <div class="success-message">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                <div id="emailError" class="error-message"></div>

                <label for="password">New Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    <button type="button" class="toggle-password">
                        <span class="material-icons">visibility_off</span>
                    </button>
                </div>
                <div id="passwordError" class="error-message"></div>
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password_confirmation">Confirm New Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                    <button type="button" class="toggle-password">
                        <span class="material-icons">visibility_off</span>
                    </button>
                </div>
                <div id="confirmPasswordError" class="error-message"></div>
                @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <button type="submit" class="reset-btn">Update Password</button>
            </form>

            <p class="login-link">Remember your password? <a href="{{ route('login') }}">Log in</a></p>
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

        document.addEventListener("DOMContentLoaded", function () {
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");
            const confirmPasswordInput = document.getElementById("password_confirmation");

            const emailError = document.getElementById("emailError");
            const passwordError = document.getElementById("passwordError");
            const confirmPasswordError = document.getElementById("confirmPasswordError");

            emailInput.addEventListener("blur", function () {
                if (this.value.trim() === "") {
                    emailError.textContent = "Email is required.";
                    emailError.style.color = "red";
                } else {
                    emailError.textContent = "";
                }
            });

            passwordInput.addEventListener("blur", function () {
                if (this.value.trim() === "") {
                    passwordError.textContent = "Password is required.";
                    passwordError.style.color = "red";
                } else if (this.value.length < 6) {
                    passwordError.textContent = "Password must be at least 6 characters.";
                    passwordError.style.color = "red";
                } else {
                    passwordError.textContent = "";
                }
            });

            confirmPasswordInput.addEventListener("blur", function () {
                if (this.value.trim() === "") {
                    confirmPasswordError.textContent = "Confirm Password is required.";
                    confirmPasswordError.style.color = "red";
                } else if (this.value !== passwordInput.value) {
                    confirmPasswordError.textContent = "Passwords do not match.";
                    confirmPasswordError.style.color = "red";
                } else {
                    confirmPasswordError.textContent = "";
                }
            });
        });
    </script>

@endsection
