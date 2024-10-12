function checkSubmitButton() {
    const emailError = document.getElementById('email-errmsg').innerHTML === '';
    const usernameError = document.getElementById('username-errmsg').innerHTML === '';
    const passwordError = document.getElementById('password-errmsg').innerHTML === '';
    const roleError = document.getElementById('role-errmsg').innerHTML === ''; 

    document.getElementById('signup-button').disabled = !(emailError && usernameError && passwordError && roleError);
}

// Validate email format and check availability
function checkEmail() {
    const email = document.getElementById('email').value;

    // Validate email format
    if (!email.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
        document.getElementById('email-errmsg').innerHTML = 'Invalid email';
        document.getElementById('email').style.borderColor = 'red';
        checkSubmitButton();
        return;
    }

    sendValidationRequest('email', email);
}

// Validate username length and check availability
function checkUsername() {
    const username = document.getElementById('username').value;

    if (username.length < 5) {
        document.getElementById('username-errmsg').innerHTML = 'Username must be at least 5 characters long';
        document.getElementById('username').style.borderColor = 'red';
        checkSubmitButton();
        return;
    }

    sendValidationRequest('username', username);
}

// Validate password length
function checkPassword() {
    const password = document.getElementById('password').value;

    if (password.length >= 8) {
        document.getElementById('password-errmsg').innerHTML = '';
        document.getElementById('password').style.borderColor = 'blue';
    } else {
        document.getElementById('password-errmsg').innerHTML = 'Password must be at least 8 characters long';
        document.getElementById('password').style.borderColor = 'red';
    }

    checkSubmitButton();
}

// Validate role selection
function checkRole() {
    const role = document.getElementById('role').value;

    if (role === '') {
        document.getElementById('role-errmsg').innerHTML = 'Please select a role';
        document.getElementById('role').style.borderColor = 'red';
    } else {
        document.getElementById('role-errmsg').innerHTML = '';
        document.getElementById('role').style.borderColor = 'blue';
    }

    checkSubmitButton();
}

function sendValidationRequest(field, value) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/signup/register', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.status === 'error') {
                document.getElementById(`${field}-errmsg`).innerHTML = response.message;
                document.getElementById(field).style.borderColor = 'red';
            } else {
                document.getElementById(`${field}-errmsg`).innerHTML = '';
                document.getElementById(field).style.borderColor = 'blue';
            }

            checkSubmitButton();
        }
    };
    xhr.onerror = function () {
        console.error('Request failed');
    };

    xhr.send(JSON.stringify({ field: field, value: value }));
}
