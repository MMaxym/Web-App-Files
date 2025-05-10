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


                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required value="{{ old('email') }}" >
                <div id="emailError" class="error-message"></div>
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <p>* {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <button type="submit" class="reset-btn">SEND PASSWORD RESET LINK</button>

                <div class="signup">
                    <p>Remember your password? <a href="{{ route('login') }}">Log In</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/auth/email.js') }}"></script>

@endsection

