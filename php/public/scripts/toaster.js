function showToast() {
    var toast = document.getElementById("toast");
    if (toast) {
        toast.className = "show";
        setTimeout(function () {
            toast.className = toast.className.replace("show", "hide");
        }, 3000); // Show for 3 seconds
    }
}

window.onload = function() {
    showToast();
};
