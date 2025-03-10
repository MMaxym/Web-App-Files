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


let droppedFile = null;

document.querySelector('.add-file-btn').addEventListener('click', function(event) {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];

    const uploadedFilesCount = document.getElementById('uploadedFiles').childElementCount;

    if (!file && uploadedFilesCount === 0) {
        const errorAlert = document.getElementById('error-alert2');
        errorAlert.innerHTML = '<i class="fas fa-times-circle"></i> No file selected.';
        errorAlert.classList.add('visible');

        setTimeout(() => {
            errorAlert.classList.remove('visible');
        }, 3000);

        event.preventDefault();
    }
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
        droppedFile = file;
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

document.addEventListener("DOMContentLoaded", function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('deletionDate').setAttribute('min', today);
});

document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const fileInput = document.getElementById('fileInput');

    if (fileInput.files.length > 0) {
        formData.set('file', fileInput.files[0]);
    }
    else if (droppedFile) {
        formData.set('file', droppedFile);
    }
    else {
        showErrorMessage("No file selected.");
        return;
    }

    fetch(`/files/upload-file`, {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showErrorMessage(data.error);
            } else {
                const successAlert = document.getElementById("success-alert2");
                const successMessage = document.getElementById("success-message");

                successMessage.textContent = "File uploaded successfully!";
                successAlert.classList.add("visible");

                setTimeout(() => {
                    successAlert.classList.remove("visible");
                    location.reload();
                }, 1500);
            }
        })
        .catch(error => console.error("Error:", error));
});

function showErrorMessage(message) {
    const errorAlert = document.getElementById('error-alert2');
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = message;
    errorAlert.classList.add('visible');
    setTimeout(() => {
        errorAlert.classList.remove('visible');
    }, 3000);
}

document.querySelector('.form-edit').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/users/update`, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            first_name: formData.get('first_name'),
            last_name: formData.get('last_name'),
            email: formData.get('email'),
            phone: formData.get('phone'),
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.user) {
                const successAlert = document.getElementById("success-alert3");
                const successMessage = document.getElementById("success-message3");

                successMessage.textContent = "User updated successfully!";
                successAlert.classList.add("visible");

                setTimeout(() => {
                    successAlert.classList.remove("visible");
                    location.reload();
                }, 1500);


            } else {
                showErrorMessage3(data.error);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });

    function showErrorMessage3(message) {
        const errorAlert = document.getElementById('error-alert3');
        const errorMessage = document.getElementById('error-message3');
        errorMessage.textContent = message;
        errorAlert.classList.add('visible');
        setTimeout(() => {
            errorAlert.classList.remove('visible');
        }, 3000);
    }
});


document.addEventListener("DOMContentLoaded", function () {
    let selectedFileId = null;

    document.querySelectorAll(".file-row").forEach(row => {
        row.addEventListener("click", function (event) {
            document.querySelectorAll(".file-row").forEach(r => r.classList.remove("selected"));
            this.classList.add("selected");
            selectedFileId = this.dataset.id;
            event.stopPropagation();
        });
    });

    document.getElementById('btn-delete').addEventListener("click", function () {
        if (!selectedFileId) {
            let errorMessage = "Select a file to delete!";
            let errorAlert = document.getElementById('error-alert5');
            errorAlert.classList.add('visible');

            document.getElementById('error-message5').innerText = errorMessage;
            errorAlert.style.display = 'block';

            setTimeout(function() {
                errorAlert.style.display = 'none';
                errorAlert.classList.remove('visible');
            }, 2000);
            return;
        }
        if (confirm("Are you sure you want to delete this file?")) {
            fetch(`/files/${selectedFileId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                }
            })
                .then(response => {
                    if (response.ok) {

                        let successMessage = "Select a file to delete!";
                        let successAlert = document.getElementById('success-alert5');
                        successAlert.classList.add('visible');

                        document.getElementById('success-message5').innerText = successMessage;
                        successAlert.style.display = 'block';

                        setTimeout(function() {
                            successAlert.style.display = 'none';
                            successAlert.classList.remove('visible');
                            location.reload();
                        }, 2000);

                    }
                    else {
                        let errorMessage2 = "File deletion error!";
                        let errorAlert = document.getElementById('error-alert5');
                        errorAlert.classList.add('visible');

                        document.getElementById('error-message').innerText = errorMessage2;
                        errorAlert.style.display = 'block';

                        setTimeout(function() {
                            errorAlert.style.display = 'none';
                            errorAlert.classList.remove('visible');
                        }, 2000);
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    });

    document.addEventListener("click", function (event) {
        if (!event.target.closest('.file-row')) {
            document.querySelectorAll(".file-row").forEach(row => row.classList.remove("selected"));
            selectedFileId = null;
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let selectedFileId = null;
    let selectedFileName = null;

    document.querySelectorAll(".file-row").forEach(row => {
        row.addEventListener("click", function (event) {
            document.querySelectorAll(".file-row").forEach(r => r.classList.remove("selected"));
            this.classList.add("selected");
            selectedFileId = this.dataset.id;
            selectedFileName = this.querySelector('.file-name').innerText;
            event.stopPropagation();
        });
    });

    document.getElementById('copy-btn').addEventListener("click", function () {
        if (!selectedFileName) {
            let errorMessage = "Select a file to copy the name!";
            let errorAlert2 = document.getElementById('error-alert5');
            errorAlert2.classList.add('visible');
            document.getElementById('error-message5').innerText = errorMessage;
            errorAlert2.style.display = 'block';

            setTimeout(function() {
                errorAlert2.style.display = 'none';
                errorAlert2.classList.remove('visible');
            }, 2000);
            return;
        }

        navigator.clipboard.writeText(selectedFileName)
            .then(() => {
                let successMessage2 = "File name copied to clipboard!";
                let successAlert2 = document.getElementById('success-alert5');
                successAlert2.classList.add('visible');

                document.getElementById('success-message5').innerText = successMessage2;
                successAlert2.style.display = 'block';

                setTimeout(function() {
                    successAlert2.style.display = 'none';
                    successAlert2.classList.remove('visible');
                }, 2000);
            })
            .catch(error => {
                console.error("Failed to copy text: ", error);
                alert("Failed to copy file name.");
            });
    });

    document.addEventListener("click", function (event) {
        if (!event.target.closest('.file-row')) {
            document.querySelectorAll(".file-row").forEach(row => row.classList.remove("selected"));
            selectedFileId = null;
            selectedFileName = null;
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {

    let selectedFileLinkId = null;

    document.querySelectorAll(".file-row").forEach(row => {
        row.addEventListener("click", function (event) {
            document.querySelectorAll(".file-row").forEach(r => r.classList.remove("selected"));
            this.classList.add("selected");
            selectedFileLinkId = this.dataset.id;
            event.stopPropagation();
        });
    });

    function generateLink(type) {
        if (!selectedFileLinkId) {
            let errorMessage3 = "Select a file to generate link!";
            let errorAlert3 = document.getElementById('error-alert5');
            errorAlert3.classList.add('visible');
            document.getElementById('error-message5').innerText = errorMessage3;
            errorAlert3.style.display = 'block';

            setTimeout(function() {
                errorAlert3.style.display = 'none';
                errorAlert3.classList.remove('visible');
            }, 2000);

            return;
        }

        fetch(`/files/${selectedFileLinkId}/generate-link`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ type })
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById("link").value = data.url;
                document.getElementById("linkModal").style.display = "flex";
            })
            .catch(error => console.error("Error:", error));
    }

    document.getElementById("openModalLink1").addEventListener("click", function() {
        generateLink("temporary");
    });

    document.getElementById("openModalLink2").addEventListener("click", function() {
        generateLink("public");
    });

    document.getElementById("closeModalLink").addEventListener("click", function () {
        document.getElementById("linkModal").style.display = "none";
        location.reload();
    });

    document.addEventListener("click", function (event) {
        if (!event.target.closest('.file-row') && !event.target.closest('#linkModal') &&
            !event.target.closest('#openModalLink1') && !event.target.closest('#openModalLink2')) {
            document.querySelectorAll(".file-row").forEach(row => row.classList.remove("selected"));
            selectedFileLinkId = null;
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const fileRows = document.querySelectorAll('.file-row');
    if (fileRows.length > 0) {
        fileRows.forEach(row => {
            row.addEventListener('dblclick', function () {
                const fileId = this.getAttribute('data-id');
                openFileModal(fileId);
            });
        });
    }

    const closeModalBtn = document.getElementById('closeModalBtn');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            closeModalFiles();
        });
    }
});

function openFileModal(fileId) {
    fetch(`/files/${fileId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('File not found or server error');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('fileName').textContent = data.file.file_name;

                const fileComment = data.file.comment ? data.file.comment : 'No Comment';
                document.getElementById('fileDescription').textContent = fileComment;

                document.getElementById('fileViews').textContent = data.file.views_count;

                const expirationDate = data.file.expiration_date;
                let formattedDate = 'No date expiration';

                if (expirationDate) {
                    const dateObj = new Date(expirationDate);
                    const day = String(dateObj.getDate()).padStart(2, '0');
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const year = dateObj.getFullYear();
                    formattedDate = `${day}.${month}.${year}`;
                }
                document.getElementById('fileExpirationDate').textContent = formattedDate;

                document.getElementById('fileModal').style.display = 'flex';
            } else {
                console.error('Error: File details could not be retrieved.');
            }
        })
        .catch(error => {
            console.error('Error fetching file details:', error);
            alert('Error loading file details. Please try again later.');
        });
}

function closeModalFiles() {
    const modal = document.getElementById('fileModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const tooltip = document.createElement("div");
    tooltip.className = "custom-tooltip";
    tooltip.innerText = "Double-click to see file details";
    document.body.appendChild(tooltip);

    let hideTimeout;

    document.querySelectorAll(".file-row").forEach(row => {
        row.addEventListener("mouseenter", (event) => {
            tooltip.style.opacity = "1";
            tooltip.style.top = `${event.clientY + 15}px`;
            tooltip.style.left = `${event.clientX + 15}px`;

            hideTimeout = setTimeout(() => {
                tooltip.style.opacity = "0";
            }, 1000);
        });

        row.addEventListener("mousemove", (event) => {
            tooltip.style.top = `${event.clientY + 15}px`;
            tooltip.style.left = `${event.clientX + 15}px`;

            clearTimeout(hideTimeout);
            hideTimeout = setTimeout(() => {
                tooltip.style.opacity = "0";
            }, 1000);
        });

        row.addEventListener("mouseleave", () => {
            tooltip.style.opacity = "0";
            clearTimeout(hideTimeout);
        });
    });
});
