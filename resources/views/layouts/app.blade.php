<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Web files')</title>

        <link rel="icon" href="{{ asset('images/Logo.png') }}">

        <link rel="stylesheet" href="{{ asset('css/global.css') }}">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .alert.alert-success {
                font-family: var(--h2-b), sans-serif;
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(40, 167, 69);
                color: white;
                padding: 15px 25px;
                font-size: 16px;
                border-radius: var(--br-3xs);
                display: flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
                z-index: 1001;
                border: none;
            }

            .alert.visible {
                display: flex;
                animation: fadeInOut 3s ease-in-out;
            }

            .alert.alert-danger {
                font-family: var(--h2-b), sans-serif;
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(220, 53, 69);
                color: white;
                padding: 15px 25px;
                font-size: 16px;
                border-radius: var(--br-3xs);
                display: flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
                z-index: 1001;
                border: none;
            }

            @keyframes fadeInOut {
                0% { opacity: 0; transform: translateX(-50%) translateY(-10px); }
                10% { opacity: 1; transform: translateX(-50%) translateY(0); }
                90% { opacity: 1; transform: translateX(-50%) translateY(0); }
                100% { opacity: 0; transform: translateX(-50%) translateY(-10px); }
            }
        </style>
    </head>

    <body style="background-color: var(--dark1);">
        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" id="error-alert">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var successAlert = document.getElementById('success-alert');
                var errorAlert = document.getElementById('error-alert');

                if (successAlert) {
                    successAlert.classList.add('visible');
                    setTimeout(() => successAlert.remove(), 3000);
                }

                if (errorAlert) {
                    errorAlert.classList.add('visible');
                    setTimeout(() => errorAlert.remove(), 3000);
                }
            });
        </script>
    </body>
</html>
