function checkSubmitButton() {
    const emailError = document.getElementById('email-errmsg').innerHTML === '';
    const usernameError = document.getElementById('username-errmsg').innerHTML === '';
    const passwordError = document.getElementById('password-errmsg').innerHTML === '';
    const roleError = document.getElementById('role-errmsg').innerHTML === ''; 

    document.getElementById('signup-button').disabled = !(emailError && usernameError && passwordError && roleError);
}

function checkEmail() {
    const email = document.getElementById('email').value;
    const emailErrorMsg = document.getElementById('email-errmsg');
    const emailInput = document.getElementById('email');

    if (!email.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
        emailErrorMsg.innerHTML = 'Invalid email';
        emailInput.style.borderColor = 'red';
    } else {
        emailErrorMsg.innerHTML = '';
        emailInput.style.borderColor = 'blue';
    }

    checkSubmitButton();
}

function checkUsername() {
    const username = document.getElementById('username').value;
    const usernameErrorMsg = document.getElementById('username-errmsg');
    const usernameInput = document.getElementById('username');

    if (username.length < 5) {
        usernameErrorMsg.innerHTML = 'Username must be at least 5 characters long';
        usernameInput.style.borderColor = 'red';
    } else {
        usernameErrorMsg.innerHTML = '';
        usernameInput.style.borderColor = 'blue';
    }

    checkSubmitButton();
}

function checkPassword() {
    const password = document.getElementById('password').value;
    const passwordErrorMsg = document.getElementById('password-errmsg');
    const passwordInput = document.getElementById('password');

    if (password.length >= 8) {
        passwordErrorMsg.innerHTML = '';
        passwordInput.style.borderColor = 'blue';
    } else {
        passwordErrorMsg.innerHTML = 'Password must be at least 8 characters long';
        passwordInput.style.borderColor = 'red';
    }

    checkSubmitButton();
}

function checkRole() {
    const role = document.getElementById('role').value;
    const roleErrorMsg = document.getElementById('role-errmsg');
    const roleSelect = document.getElementById('role');

    if (role === '') {
        roleErrorMsg.innerHTML = 'Please select a role';
        roleSelect.style.borderColor = 'red';
    } else {
        roleErrorMsg.innerHTML = '';
        roleSelect.style.borderColor = 'blue';
    }

    checkSubmitButton();
}

