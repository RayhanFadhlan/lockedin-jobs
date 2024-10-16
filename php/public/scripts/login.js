document.addEventListener("DOMContentLoaded", function () {
    const password = document.getElementById("password");
    const passwordErrMsg = document.getElementById("password-errmsg");
    const loginForm = document.getElementById("loginForm");

    function validatePassword() {
        passwordErrMsg.textContent = "";

        if (password.value.length < 8) {
            passwordErrMsg.textContent = "Password must be at least 8 characters long";
            password.classList.add("redborder");
            return false;
        } else {
            password.classList.remove("redborder");
            return true;
        }
    }

    password.addEventListener("input", validatePassword);

    loginForm.addEventListener("submit", function (event) {
        if (!validatePassword()) {
            event.preventDefault(); 
        }
    });
});