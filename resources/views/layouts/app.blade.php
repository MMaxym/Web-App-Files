<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Web files')</title>

    <link rel="icon" href="{{ asset('images/Logo.png') }}">
{{--    Зробити лого більшим--}}

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .alert {
            opacity: 1;
            transition: opacity 1s ease-out;
            text-align: center;
            z-index: 1001;
        }
        .alert.fade-out {
            opacity: 0;
        }
    </style>
</head>

<body style="background-color: var(--dark1);">
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif

@yield('content')


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            var errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                successAlert.classList.add('fade-out');
            }

            if (errorAlert) {
                errorAlert.classList.add('fade-out');
            }
            setTimeout(function() {
                if (successAlert) {
                    successAlert.remove();
                }

                if (errorAlert) {
                    errorAlert.remove();
                }
            }, 1000);
        }, 1500);
    });
</script>
</body>
</html>
