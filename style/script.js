const WRAPPER = document.querySelector('.wrapper');
const SIGNUPLINK = document.querySelector('.signUp-link');
const SIGNINLINK = document.querySelector('.signIn-link');
const FORGOTLINK = document.querySelector('.forgot-link');
const FORGOTTOSIGNINLINK = document.querySelector('.signIn-link2');


SIGNUPLINK.addEventListener('click', () => {
    WRAPPER.classList.add('animate-signIn');
    WRAPPER.classList.add('animate-forgot2');
    WRAPPER.classList.remove('animate-signUp');
});

SIGNINLINK.addEventListener('click', () => {
    WRAPPER.classList.add('animate-signUp');
    WRAPPER.classList.add('animate-forgot2');
    WRAPPER.classList.remove('animate-signIn');
});

FORGOTLINK.addEventListener('click', () => {
    WRAPPER.classList.add('animate-signIn2');
    WRAPPER.classList.remove('animate-forgot');
});

FORGOTTOSIGNINLINK.addEventListener('click', () => {
    WRAPPER.classList.add('animate-forgot');
    WRAPPER.classList.remove('animate-signIn2');
});
