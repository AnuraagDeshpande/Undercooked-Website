const menu = document.querySelector('#mobile_menu');
const menulinks = document.querySelector('.navbar_menu');

menu.addEventListener('click', function() {
    menu.classList.toggle('is-active');
    menulinks.classList.toggle('is-active');
})