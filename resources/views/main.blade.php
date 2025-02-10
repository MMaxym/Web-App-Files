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
                        <button class="btn-add" id="openModal">
                            <span class="icon-circle"><i class="fas fa-plus"></i></span> Add file
                        </button>
                        <button class="btn-else"><i class="fas fa-copy"></i> Copy</button>
                        <button class="btn-else"><i class="fas fa-file-signature"></i> Rename</button>
                        <button class="btn-else"><i class="fas fa-trash-alt"></i> Delete</button>
                    </div>
                    <div class="account">
                        <button id="user-icon" class="user-icon">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <form class="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="button" id="logout-btn" class="logout-btn" onClick="confirmLogout()">
                                <i class="fas fa-sign-out-alt logout"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div id="uploadModal" class="modal">
                    <div class="m-content-upload">
                        <div class="modal-header-upload">
                            <h2>Files Upload</h2>
                            <span class="modalClose" id="closeModalUpload">
                                <i class="fas fa-times"></i>
                            </span>
                        </div>
                        <div class="modal-description-upload">Add your documents here</div>
                        <div class="modal-body-upload">
                            <div class="file-dropzone" id="dropzone">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="browse-desc">Drag your file(s) or <span class="browse" id="browseText">browse</span></p>
                                <p class="file-validation">* Max 5 MB files are allowed</p>
                                <input type="file" id="fileInput" style="display: none;">
                                <i class="far fa-file-alt file-icon" style="display: none;"></i>
                            </div>
                            <div id="uploadedFiles" class="uploaded-files">
                            </div>
                            <div class="optional-section">
                                <h2>Optional: <span class="optional">Add Comments and Deletion Date for File</span></h2>
                                <label for="comment">Comment</label>
                                <textarea id="comment" placeholder="Enter your comment"></textarea>

                                <label for="deletionDate">Deletion Date</label>
                                <input type="date" id="deletionDate">
                            </div>
                            <button class="add-file-btn">ADD FILE</button>
                            <div class="alert-danger2" id="error-alert2">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="dropdown" class="dropdown-content">
                    <div class="account-information">
                        <i class="fas fa-address-card"></i>
                        Personal Information
                    </div>
                    <div class="user-info">
                        <p class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <p class="user-email">{{ Auth::user()->email }}</p>
                        <p class="user-phone">{{ Auth::user()->phone }}</p>
                    </div>
                    <button class="btn-edit" id="editButton">
                        <i class="fas fa-pencil-alt"></i>
                        Edit
                    </button>
                </div>

                <div id="editModal" class="modal">
                    <div class="m-content">
                        <div class="modal-header">
                            <h2>Edit Personal Information</h2>
                            <span class="modalClose" id="closeModal">
                            <i class="fas fa-times"></i>
                        </span>
                        </div>
                        <div class="modal-description">You can edit your personal information and save it</div>
                        <div class="modal-body">
                            <form class="form-edit">
                                @csrf
                                <label for="firstName" id="firstNameLabel">First Name</label>
                                <input type="text" id="firstName" name="first_name" value="{{ Auth::user()->first_name }}">
                                <div id="firstNameError" class="error-message"></div>
                                @error('first_name')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror

                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="last_name" value="{{ Auth::user()->last_name }}">
                                <div id="lastNameError" class="error-message"></div>
                                @error('last_name')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror

                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}">
                                <div id="emailError" class="error-message"></div>
                                @error('email')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror

                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}">
                                <div id="phoneError" class="error-message"></div>
                                @error('phone')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror

                                <button type="submit" class="save-btn">SAVE CHANGES</button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="main-content">
                    <div class="sidebar">
                        <button class="sidebar-btn"  id="openModalLink1">
                            <i class="fas fa-link"></i> Generate disposable <span>link</span>
                        </button>
                        <button class="sidebar-btn"  id="openModalLink2">
                            <i class="fas fa-link"></i> Generate multiple <span>link</span>
                        </button>
                        <div class="total-count">
                            <span>Total Count</span>
                            <strong>142</strong>
                        </div>
                    </div>

                    <div id="linkModal" class="modal">
                        <div class="m-content-link">
                            <div class="modal-header-link">
                                <h2>Generate Link</h2>
                                <span class="modalClose" id="closeModalLink">
                                <i class="fas fa-times"></i>
                            </span>
                            </div>
                            <div class="modal-description-link">Copy the created link</div>
                            <div class="modal-body-link">
                                <div class="link-section">
                                    <label for="link">Generate Link</label>
                                    <input type="text" id="link" value="http://localhost/files/name-file.format/xdvpscvpdhbepwfjr9uvfvnru9e8urf0we8fhfvob" readonly>
                                </div>
                                <button class="copy-link-btn">
                                    <i class="fas fa-copy"></i> COPY LINK
                                </button>
                                <div id="copy-message" class="copy-message">
                                    <i class="fas fa-check-circle"></i> Link copied!
                                </div>
                            </div>
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
                                    <td>16.11.2023</td>
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
                                    <td>12.12.2023</td>
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
                                    <td>14.12.2023</td>
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
                                    <td>15.12.2023</td>
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
                                    <td>16.12.2023</td>
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
                                    <td>18.12.2023</td>
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
                                    <td>20.12.2023</td>
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
                                    <td>21.12.2023</td>
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
                                    <td>22.12.2023</td>
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

            function confirmLogout() {
                if (confirm("Are you sure you want to log out?")) {
                    document.querySelector('.logout-form').submit();
                }
            }

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

            document.addEventListener("DOMContentLoaded", function () {
                var userIcon = document.getElementById("user-icon");
                var dropdown = document.getElementById("dropdown");

                userIcon.addEventListener("mouseenter", function () {
                    dropdown.style.display = "block";
                });

                userIcon.addEventListener("click", function (event) {
                    event.stopPropagation();
                    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
                });

                dropdown.addEventListener("mouseleave", function () {
                    dropdown.style.display = "none";
                });

                document.addEventListener("click", function (event) {
                    if (!userIcon.contains(event.target) && !dropdown.contains(event.target)) {
                        dropdown.style.display = "none";
                    }
                });
            });

            const editButton = document.getElementById("editButton");
            const modal = document.getElementById("editModal");
            const closeModal = document.getElementById("closeModal");

            editButton.addEventListener("click", () => {
                modal.style.display = "flex";
            });

            closeModal.addEventListener("click", () => {
                modal.style.display = "none";
            });


            document.getElementById('phone').addEventListener('input', function (e) {
                let value = e.target.value;
                value = value.replace(/[^0-9+]/g, '');

                if ((value.match(/\+/g) || []).length > 1) {
                    value = value.replace(/\+/g, '');
                }

                if (value.length > 13) {
                    value = value.substring(0, 13);
                }
                e.target.value = value;
            });

            document.addEventListener("DOMContentLoaded", function () {
                const firstNameInput = document.getElementById("firstName");
                const lastNameInput = document.getElementById("lastName");
                const emailInput = document.getElementById("email");
                const phoneInput = document.getElementById("phone");

                const firstNameError = document.getElementById("firstNameError");
                const lastNameError = document.getElementById("lastNameError");
                const emailError = document.getElementById("emailError");
                const phoneError = document.getElementById("phoneError");

                firstNameInput.addEventListener("blur", function () {
                    if (this.value.trim() === "") {
                        firstNameError.textContent = "* First Name is required.";
                        firstNameError.style.color = "red";
                    } else {
                        firstNameError.textContent = "";
                    }
                });

                lastNameInput.addEventListener("blur", function () {
                    if (this.value.trim() === "") {
                        lastNameError.textContent = "* Last Name is required.";
                        lastNameError.style.color = "red";
                    } else {
                        lastNameError.textContent = "";
                    }
                });

                emailInput.addEventListener("blur", function () {
                    if (this.value.trim() === "") {
                        emailError.textContent = "* Email is required.";
                        emailError.style.color = "red";
                    } else if (!/\S+@\S+\.\S+/.test(this.value)) {
                        emailError.textContent = "* Please enter a valid email address.";
                        emailError.style.color = "red";
                    } else {
                        emailError.textContent = "";
                    }
                });

                phoneInput.addEventListener("blur", function () {
                    if (this.value.trim() === "") {
                        phoneError.textContent = "* Phone Number is required.";
                        phoneError.style.color = "red";
                    } else {
                        phoneError.textContent = "";
                    }
                });
            });

            document.getElementById("openModal").addEventListener("click", function() {
                document.getElementById("uploadModal").style.display = "flex";
            });
            document.getElementById("closeModalUpload").addEventListener("click", function() {
                document.getElementById("uploadModal").style.display = "none";
            });

            document.getElementById("openModalLink1").addEventListener("click", function() {
                document.getElementById("linkModal").style.display = "flex";
            });
            document.getElementById("closeModalLink").addEventListener("click", function() {
                document.getElementById("linkModal").style.display = "none";
            });


            document.getElementById("openModalLink2").addEventListener("click", function() {
                document.getElementById("linkModal").style.display = "flex";
            });
            document.getElementById("closeModalLink").addEventListener("click", function() {
                document.getElementById("linkModal").style.display = "none";
            });


            document.querySelector(".copy-link-btn").addEventListener("click", function () {
                const input = document.getElementById("link");

                navigator.clipboard.writeText(input.value).then(() => {
                    const message = document.getElementById("copy-message");

                    if (!message.classList.contains("visible")) {
                        message.classList.add("visible");
                        setTimeout(() => message.classList.remove("visible"), 3000);
                    }
                }).catch(err => console.error("Failed to copy: ", err));
            });




            document.getElementById('browseText').addEventListener('click', function() {
                document.getElementById('fileInput').click();
            });

            document.getElementById('fileInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    if (document.getElementById('uploadedFiles').childElementCount > 0) {
                        const errorAlert = document.getElementById('error-alert2');
                        errorAlert.innerHTML = '<i class="fas fa-times-circle"></i> You can only upload one file.';
                        errorAlert.classList.add('visible');
                        setTimeout(() => {
                            errorAlert.classList.remove('visible');
                        }, 3000);
                        return;
                    }

                    if (file.size > 5242880) {
                        const errorAlert = document.getElementById('error-alert2');
                        errorAlert.innerHTML = '<i class="fas fa-times-circle"></i> File size exceeds 5 MB.';
                        errorAlert.classList.add('visible');
                        setTimeout(() => {
                            errorAlert.classList.remove('visible');
                        }, 3000);
                        return;
                    }
                    displayFile(file);
                }
            });

            const dropzone = document.getElementById('dropzone');
            dropzone.addEventListener('dragover', function(event) {
                event.preventDefault();
                dropzone.classList.add('highlight');
            });

            dropzone.addEventListener('dragleave', function(event) {
                dropzone.classList.remove('highlight');
            });

            dropzone.addEventListener('drop', function(event) {
                event.preventDefault();
                dropzone.classList.remove('highlight');
                const file = event.dataTransfer.files[0];
                if (file) {
                    if (document.getElementById('uploadedFiles').childElementCount > 0) {
                        const errorAlert = document.getElementById('error-alert2');
                        errorAlert.innerHTML = '<i class="fas fa-times-circle"></i> You can only upload one file.';
                        errorAlert.classList.add('visible');
                        setTimeout(() => {
                            errorAlert.classList.remove('visible');
                        }, 3000);
                        return;
                    }

                    if (file.size > 5242880) {
                        const errorAlert = document.getElementById('error-alert2');
                        errorAlert.innerHTML = '<i class="fas fa-times-circle"></i> File size exceeds 5 MB.';
                        errorAlert.classList.add('visible');
                        setTimeout(() => {
                            errorAlert.classList.remove('visible');
                        }, 3000);
                        return;
                    }
                    displayFile(file);
                }
            });

            function displayFile(file) {
                const uploadedFilesDiv = document.getElementById('uploadedFiles');

                const fileDiv = document.createElement('div');
                fileDiv.classList.add('uploaded-file');

                const fileIcon = document.createElement('i');
                fileIcon.classList.add('far', 'fa-file-alt', 'file-icon');

                const fileName = document.createElement('span');
                fileName.textContent = file.name;

                const removeButton = document.createElement('button');
                removeButton.classList.add('remove-file-btn');
                removeButton.innerHTML = '<i class="fas fa-times"></i>';
                removeButton.onclick = function () {
                    uploadedFilesDiv.removeChild(fileDiv);
                };

                fileDiv.appendChild(fileIcon);
                fileDiv.appendChild(fileName);
                fileDiv.appendChild(removeButton);

                uploadedFilesDiv.appendChild(fileDiv);
            }

        </script>
@endsection
