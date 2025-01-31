@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/auth/email.css') }}">
</head>

@section('content')

    <img class="icon" alt="Login Icon" src="{{ asset('images/Email.png') }}">
    <div class="container">
        <div class="login-box">
            <h2>Password Reset</h2>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
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
                <input type="email" id="email" name="email" placeholder="Enter email address" required value="{{ old('email') }}" >
                <div id="emailError" class="error-message"></div>

                <button type="submit" class="reset-btn">Send Password Reset Link</button>

                <div class="signup">
                    <p>Remember your password? <a href="{{ route('login') }}">Log In</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const emailInput = document.getElementById("email");
            const emailError = document.getElementById("emailError");

            emailInput.addEventListener("blur", function () {
                if (this.value.trim() === "") {
                    emailError.textContent = "Email is required.";
                    emailError.style.color = "red";
                } else if (!this.value.includes('@')) {
                    emailError.textContent = "Please enter a valid email address.";
                    emailError.style.color = "red";
                } else {
                    emailError.textContent = "";
                }
            });
        });
    </script>

@endsection

