@extends('layouts.app')

<head>
{{--    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">--}}
</head>

@section('content')
    <h1 style="color: var(--text-color);">ГОЛОВНА  СТОРІНКА</h1>

    <button id="logout-btn">LOG OUT</button>


    <script>

        let token = "{{ session('jwt_token') }}";
        if (token) {
            sessionStorage.setItem("jwt_token", token);
        }

        document.getElementById('logout-btn').addEventListener('click', function () {
            if (!confirm('Are you sure you want to log out?')) {
                return;
            }

            fetch('{{ route('logout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (response.redirected) {
                        sessionStorage.clear();
                        window.location.href = response.url;
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data && data.error) {
                        alert('Logout error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong.\nPlease try again...');
                });
        });
    </script>
@endsection
