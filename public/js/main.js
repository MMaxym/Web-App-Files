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
    } else if (droppedFile) {
        formData.set('file', droppedFile);
    } else {
        showErrorMessage("No file selected.");
        return;
    }

    fetch(uploadUrl, {
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
