@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>

@section('content')

        <img class="icon" alt="Login Icon" src="{{ asset('images/Login.png') }}">
        <div class="container">
            <div class="login-box">
                <h2>Log in with</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                    <div id="emailError" class="error-message"></div>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror

                    <label for="password">Password <a href="#" class="forgot">Forgot Password?</a></label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                        <button type="button" id="togglePassword">
                            <span class="material-icons">visibility_off</span>
                        </button>
                    </div>
                    <div id="passwordError" class="error-message"></div>
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror

                    <div class="divider">or</div>

                    <div class="btn-google">
                        <a href="{{ route('google.redirect') }}" class="google-btn-link">
                            <img src="{{ asset('images/Google.svg') }}" alt="Google Icon" class="google-icon">
                            Google
                        </a>
                    </div>

                    <button type="submit" class="login-btn">LOG IN</button>
                </form>
                <p class="signup">Don’t have an account? <a href="{{route('register')}}">Sign up</a></p>
            </div>
        </div>

    <script>
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
                } else {
                    passwordError.textContent = "";
                }
            });
        });
    </script>

@endsection
