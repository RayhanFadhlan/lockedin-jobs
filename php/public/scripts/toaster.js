function toast(message = '') {
    var toast = document.getElementById("toast");
    toast.textContent = message;
    toast.className = "show";
    setTimeout(function () {
        toast.className = toast.className.replace("show", "hide");
    }, 3000);
    
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift());
    return null;
}

function setCookie(name, value) {
    document.cookie = `${name}=${encodeURIComponent(value)}; path=/`;
}


function deleteCookie(name) {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}


//PAKE INI KALO MAU NAMPILIN TOAST DARI JS
function showToast(message){
    setCookie('toastMessage', message, 1);
    toast(message);
}

window.onload = function() {
    
    const toastMessage = getCookie('toastMessage');
    if(toastMessage){
        toast(toastMessage);
        deleteCookie('toastMessage');
    }
};


