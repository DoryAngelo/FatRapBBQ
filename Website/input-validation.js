
//for eye icon password
function togglePassword(passwordFieldId) {
    const passwordField = document.getElementById(passwordFieldId);
    const eyeIconOpen = document.getElementById(`eyeIconOpen${passwordFieldId.toUpperCase()}`);
    const eyeIconClosed = document.getElementById(`eyeIconClosed${passwordFieldId.toUpperCase()}`);

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIconOpen.style.display = 'none';
        eyeIconClosed.style.display = 'block';
    } else {
        passwordField.type = 'password';
        eyeIconOpen.style.display = 'block';
        eyeIconClosed.style.display = 'none';
    }
}


        

