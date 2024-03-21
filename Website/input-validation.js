
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


//input validation
const form = document.getElementById('form');
const nameInput = document.getElementById('name');
const email = document.getElementById('email');
const number = document.getElementById('number');
const password = document.getElementById('password');
const password2 = document.getElementById('cpassword');

form.addEventListener('submit', e => {
    e.preventDefault();

    validateInputs();
});

const setError = (element, message) => {
    const inputControl = element.parentElement; //element should have input-control as its parent, with div.error as its sibling
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success')
}

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
};

const isValidEmail = email => {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

const validateInputs = () => {
    const nameValue = nameInput.value.trim();
    const emailValue = email.value.trim();
    const numberValue = number.value.trim();
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    //Regular expressions for input validation
    const nameRegex = /^[a-zA-Z ]+$/; //letters only
    const numberRegex = /^09\d{9}$/; //numbers only
    const uppercaseRegex = /[A-Z]/;
    const lowercaseRegex = /[a-z]/;
    const digitRegex = /\d/;
    const specialCharRegex = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;

    if (nameValue === '') {
        setError(nameInput, 'Please enter your name');
    } else if (!nameRegex.test(nameValue)) {
        setError(nameInput, 'Name must contain only letters');
    } else {
        setSuccess(nameInput);
    }

    if(emailValue === '') {
        setError(email, 'Please enter your email');
    } else if (!isValidEmail(emailValue)) {
        setError(email, 'Provide a valid email address');
    } else {
        setSuccess(email);
    }

    if (numberValue === '') {
        setError(number, 'Please enter your number');
    } else if (!numberRegex.test(numberValue)) {
        setError(number, 'Invalid number');
    } else {
        setSuccess(number);
    }

    if(passwordValue === '') {
        setError(password, 'Please enter your password');
    } else if (passwordValue.length < 8 ) {
        setError(password, 'Password must be at least 8 character.')
    } 
    else if (!uppercaseRegex.test(passwordValue)) {
        setError(password, 'Password must contain at least one uppercase letter.');
    } 
    else if (!lowercaseRegex.test(passwordValue)) {
        setError(password, 'Password must contain at least one lowercase letter.');
    } 
    else if (!digitRegex.test(passwordValue)) {
        setError(password, 'Password must contain at least one digit');
    } 
    else if (!specialCharRegex.test(passwordValue)) {
        setError(password, 'Password must contain at least one special character.');
    } 
    else {
        setSuccess(password);
    }

    if(password2Value === '') {
        setError(password2, 'Please confirm your password');
    } else if (password2Value !== passwordValue) {
        setError(password2, "Password doesn't match");
    } else {
        setSuccess(password2);
    }
};

        

