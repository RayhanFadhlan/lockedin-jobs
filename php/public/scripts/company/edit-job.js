const fileInput = document.getElementById("attachment");
const fileLabel = document.querySelector(".file-label");
const fileInputContainer = document.querySelector(".file-input-container");
const editform = document.getElementById("jobEditForm");

const quill = new Quill("#editor", {
    theme: "snow",
});

let selectedFiles = [];

fileInput.addEventListener("change", handleFileSelect);

function handleFileSelect(event) {
    const files = event.target.files;

    selectedFiles = [];

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (validateFile(file)) {
            selectedFiles.push(file);
        } else {
            console.warn(`File ${file.name} is not a valid image file.`);
        }
    }

    updateFileList();
}

function validateFile(file) {
    const acceptedTypes = [".png", ".jpg", ".jpeg"];
    const fileExtension = "." + file.name.split(".").pop().toLowerCase();
    return acceptedTypes.includes(fileExtension);
}

function updateFileList() {
    const existingList = fileInputContainer.querySelector(".file-list");
    if (existingList) {
        existingList.remove();
    }

    if (selectedFiles.length > 0) {
        const fileList = document.createElement("ul");
        fileList.className = "file-list";

        selectedFiles.forEach((file) => {
            const listItem = document.createElement("li");
            listItem.textContent = file.name;
            fileList.appendChild(listItem);
        });

        fileInputContainer.appendChild(fileList);
        fileLabel.textContent = `${selectedFiles.length} file(s) selected`;
    } else {
        fileLabel.textContent = "Choose Image";
    }
}



editform.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(editform);
    formData.append("jobDescription", quill.root.innerHTML);

    const fileInput = document.getElementById("attachment");
    if (fileInput.files.length > 0) {
        for (let i = 0; i < fileInput.files.length; i++) {
            formData.append("attachment[]", fileInput.files[i]);
        }
    }

    const xhr = new XMLHttpRequest();
    const url = window.location.href;

    xhr.open("POST", url);

    xhr.setRequestHeader("Accept", "application/json");
  

    xhr.onload = function () {
        try {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                window.location.href = "/company";
                showToast(response.message, "success");
            } else {
                console.error("Error updating job:", response.message);
                showToast(response.message);
            }
        } catch (e) {
            console.error("Failed to parse JSON response:", e);
            console.error("Response text:", xhr.responseText);
            showToast("An error occured.");
        }
    }

    xhr.onerror = function () {
        console.error("Network Error");
        showToast("A network error occurred.");
    };

    xhr.send(formData);



});
