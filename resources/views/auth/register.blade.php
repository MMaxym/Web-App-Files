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

    <script src="{{ asset('js/auth/register.js') }}"></script>

@endsection
