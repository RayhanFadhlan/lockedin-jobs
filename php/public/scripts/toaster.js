function toast(message, type = 'default') {
    const toast = document.getElementById('toast');
    toast.className = 'toast ' + type + ' show';
    toast.querySelector('.toast-message').textContent = message;

    setTimeout(() => {
        toast.className = toast.className.replace('show', '');
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
function showToast(message, type = 'default'){
    setCookie('toastMessage', message, 1);
    setCookie('toastType', type, 1);
    toast(message, type);
}

window.onload = function() {
    
    const toastMessage = getCookie('toastMessage');
    const toastType = getCookie('toastType');
    if(toastMessage){
        if(toastType){
            toast(toastMessage, toastType);
            deleteCookie('toastType');
        }
        else {
            toast(toastMessage);
        }
        deleteCookie('toastMessage');
    }
};


