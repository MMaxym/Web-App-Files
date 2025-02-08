@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

@section('content')
        <div class="container">
            <div class="content">
                <div class="header">
                    <div class="logo">  <img src="{{ asset('images/main-logo.svg') }}" alt="Logo" class="main-logo"></div>
                    <div class="toolbar">
                        <button class="btn-add">
                            <span class="icon-circle"><i class="fas fa-plus"></i></span> Add file
                        </button>
                        <button class="btn-else"><i class="fas fa-copy"></i> Copy</button>
                        <button class="btn-else"><i class="fas fa-file-signature"></i> Rename</button>
                        <button class="btn-else"><i class="fas fa-trash-alt"></i> Delete</button>
                    </div>
                    <div class="account">
                        <button class="user-icon"><i class="far fa-user-circle"></i></button>
                        <button id="logout-btn"><i class="fas fa-sign-out-alt logout"></i></button>
                    </div>
                </div>

                <div class="main-content">
                    <div class="sidebar">
                        <button class="sidebar-btn">
                            <i class="fas fa-link"></i> Generate disposable <span>link</span>
                        </button>
                        <button class="sidebar-btn">
                            <i class="fas fa-link"></i> Generate multiple <span>link</span>
                        </button>
                        <div class="total-count">
                            <span>Total Count</span>
                            <strong>142</strong>
                        </div>
                    </div>

                    <div class="second-content">
                        <div class="stats">
                            <div class="stat-box">
                                <i class="far fa-eye stat-icon1"></i>
                                <div class="card-content">
                                    <span class="stat-title">Total Views</span>
                                    <span class="stat-value">365</span>
                                </div>
                            </div>
                            <div class="stat-box">
                                <i class="fas fa-file-alt stat-icon2"></i>
                                <div class="card-content">
                                    <span class="stat-title">Count of existing files</span>
                                    <span class="stat-value">177</span>
                                </div>
                            </div>
                            <div class="stat-box">
                                <i class="fas fa-file-excel stat-icon3"></i>
                                <div class="card-content">
                                    <span class="stat-title">Count of deleted files</span>
                                    <span class="stat-value">211</span>
                                </div>
                            </div>
                            <div class="stat-box">
                                <i class="fas fa-link stat-icon4"></i>
                                <div class="card-content">
                                    <span class="stat-title">Total of disposable links</span>
                                    <span class="stat-value">116 (87 used)</span>
                                </div>
                            </div>
                        </div>

                        <div class="file-list">
                            <table>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Views</th>
                                    <th>
                                        Date
                                        <i class="fas fa-arrow-down"></i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Draft1-changes-in-red-from-Simon.doc</span>
                                            <span class="file-desc">Discharge Summary</span>
                                        </div>
                                    </td>
                                    <td>357</td>
                                    <td>16.11.2023 04:45</td>
                                </tr>
                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Project-Plan-2024.pdf</span>
                                            <span class="file-desc">Project Overview</span>
                                        </div>
                                    </td>
                                    <td>1024</td>
                                    <td>12.12.2023 10:30</td>
                                </tr>

                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Team-Meeting-Minutes.docx</span>
                                            <span class="file-desc">Meeting Summary</span>
                                        </div>
                                    </td>
                                    <td>2050</td>
                                    <td>14.12.2023 09:15</td>
                                </tr>

                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Sales-Report-Q4-2023.xlsx</span>
                                            <span class="file-desc">Sales Overview</span>
                                        </div>
                                    </td>
                                    <td>1820</td>
                                    <td>15.12.2023 17:00</td>
                                </tr>

                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Annual-Budget-2024.pptx</span>
                                            <span class="file-desc">Financial Planning</span>
                                        </div>
                                    </td>
                                    <td>800</td>
                                    <td>16.12.2023 11:30</td>
                                </tr>

                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Research-Study-Results.pdf</span>
                                            <span class="file-desc">Scientific Data</span>
                                        </div>
                                    </td>
                                    <td>2500</td>
                                    <td>18.12.2023 13:45</td>
                                </tr>

                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Employee-Directory-2023.xlsx</span>
                                            <span class="file-desc">Company Contacts</span>
                                        </div>
                                    </td>
                                    <td>1540</td>
                                    <td>20.12.2023 08:00</td>
                                </tr>

                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Client-Contracts-2023.docx</span>
                                            <span class="file-desc">Legal Documents</span>
                                        </div>
                                    </td>
                                    <td>900</td>
                                    <td>21.12.2023 15:30</td>
                                </tr>

                                <tr>
                                    <td class="file-info">
                                        <i class="far fa-file-alt file-icon"></i>
                                        <div class="row-content">
                                            <span class="file-name">Project-Timeline-2024.pdf</span>
                                            <span class="file-desc">Timeline Overview</span>
                                        </div>
                                    </td>
                                    <td>1200</td>
                                    <td>22.12.2023 16:45</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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

            document.querySelectorAll('tr').forEach(row => {
                row.addEventListener('click', function(event) {
                    event.stopPropagation();
                    document.querySelectorAll('tr').forEach(r => r.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            document.addEventListener('click', function() {
                document.querySelectorAll('tr').forEach(r => r.classList.remove('selected'));
            });
        </script>
@endsection
