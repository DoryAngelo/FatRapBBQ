const cpass = document.querySelector(".js-cpass"),
pass = document.querySelector(".js-pass");

pass.addEventListener('focus', () => {
    focus(pass);
})

pass.addEventListener('blur', () => {
    blur(pass);
})

cpass.addEventListener('focus', () => {
    focus(cpass);
})

cpass.addEventListener('blur', () => {
    blur(cpass);
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
    focus(pass);
    blur(pass);
    focus(cpass);
    blur(cpass);
})

//Password
const showPass = document.querySelector('.showpass'),
hidePass = document.querySelector('.hidepass');

showPass.addEventListener('mousedown', () => {
    showPass.style.display = "none";
    hidePass.style.display = "block";
    pass.type = "text";
})

hidePass.addEventListener('mouseup', () => {
    hidePass.style.display = "none";
    showPass.style.display = "block";
    pass.type = "password";
})

//Confirm Password
const showcPass = document.querySelector('.showcpass'),
hidecPass = document.querySelector('.hidecpass');

showcPass.addEventListener('click', () => {
    showcPass.style.display = "none";
    hidecPass.style.display = "block";
    cpass.type = "text";
})

hidecPass.addEventListener('click', () => {
    hidecPass.style.display = "none";
    showcPass.style.display = "block";
    cpass.type = "password";
})

