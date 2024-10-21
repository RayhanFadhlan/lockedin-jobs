const quill = new Quill("#editor", {
    theme: "snow",
});


const acceptButton = document.getElementById("accept-btn");
const rejectButton = document.getElementById("reject-btn");

acceptButton.addEventListener("click", () => {
    
    const confirmation = confirm("Are you sure you want to accept this application?");

    const formData = new FormData();
    formData.append("status", "accepted");
    formData.append("status_reason", quill.root.innerHTML);

    const xhr = new XMLHttpRequest();

    xhr.open("POST", window.location.href + "/status");
    xhr.setRequestHeader("Accept", "application/json");

    xhr.onload = function () {
        try {
            const response = JSON.parse(xhr.responseText);
            console.log("tes");
            if (response.success) {
                window.location.reload();
                showToast(response.message);
            } else {
                console.error("Error accepting application:", response.message);
                showToast(response.message);
            }
        } catch (error) {
            showToast("An error occured.");
        }
    }
    xhr.send(formData);
});

rejectButton.addEventListener("click", () => {

    const confirmation = confirm("Are you sure you want to reject this application?");

    const formData = new FormData();
    formData.append("status", "rejected");
    formData.append("status_reason", quill.root.innerHTML);

    const xhr = new XMLHttpRequest();

    xhr.open("POST", window.location.href + "/status");
    xhr.setRequestHeader("Accept", "application/json");

    xhr.onload = function () {
        try {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                window.location.reload();
                showToast(response.message);
            } else {
                console.error("Error rejecting application:", response.message);
                showToast(response.message);
            }
        } catch (error) {
            showToast("An error occured.");
        }
    }
    xhr.send(formData);
});