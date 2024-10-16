function showToast($message = '') {
    var toast = document.getElementById("toast");
    if($message!== '' ) {
        console.log($message, "message triggered");
        toast.textContent = $message
        toast.className = "show";
        setTimeout(function () {
            toast.className = toast.className.replace("show", "hide");
        }, 3000); 
    }
    else if (toast.textContent.trim() !== '') {
        console.log(toast.textContent, "textcontent triggered");
        toast.className = "show";
        setTimeout(function () {
            toast.className = toast.className.replace("show", "hide");
        }, 3000); 
    }
    else {
        console.log('No message to display');
    }

}

window.onload = function() {
    showToast();
};
