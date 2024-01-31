const user = document.querySelector(".js-user"),
pass = document.querySelector(".js-pass");
pass = document.querySelector(".js-cpass");

user.addEventListener('focus', () => {
    focus(user);
})

user.addEventListener('blur', () => {
    blur(user);
})

pass.addEventListener('focus', () => {
    focus(pass);
})

pass.addEventListener('blur', () => {
    blur(pass);
})

function focus(e){
    parentEl = e.parentElement;
    parentEl.classList.add('active')
};

function blur(e){
    parentEl = e.parentElement;
    if(!e.value){
        parentEl.classList.remove('active')
    }
}

window.addEventListener('pageshow', () => {
    focus(user);
    blur(user);
    focus(pass);
    blur(pass);
})

const showPass = document.querySelector('.showpass'),
hidePass = document.querySelector('.hidepass');

showPass.addEventListener('click', () => {
    showPass.style.display = "none";
    hidePass.style.display = "block";
    pass.type = "text";
})

hidePass.addEventListener('click', () => {
    hidePass.style.display = "none";
    showPass.style.display = "block";
    pass.type = "password";
})

const showPass2 = document.querySelector('.showpass2'),
hidePass2 = document.querySelector('.hidepass2');

showPass.addEventListener('click', () => {
    showPass2.style.display = "none";
    hidePass2.style.display = "block";
    cpass.type = "text";
})

hidePass2.addEventListener('click', () => {
    hidePass2style.display = "none";
    showPass2.style.display = "block";
    cpass.type = "password";
})