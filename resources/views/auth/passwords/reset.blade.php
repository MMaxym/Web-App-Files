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

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                <div id="emailError" class="error-message"></div>
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <p>* {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <label for="password">New Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    <button type="button" class="toggle-password">
                        <span class="material-icons">visibility_off</span>
                    </button>
                </div>
                <div id="passwordError" class="error-message"></div>
                @error('password')
                <div class="error-message">* {{ $message }}</div>
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
                <div class="error-message">* {{ $message }}</div>
                @enderror

                <button type="submit" class="reset-btn">UPDATE PASSWORD</button>
            </form>

            <p class="login-link">Remember your password? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </div>

    <script src="{{ asset('js/auth/reset.js') }}"></script>

@endsection
