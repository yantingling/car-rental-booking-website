let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');
let memberIcon = document.querySelector('#user-icon');
var memberMenu = document.getElementById('ma-dropdown');
let memberDashboard = document.querySelector('#member_dashboard');
var memberDashboardMenu = document.getElementById('sidebar');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navbar.classList.toggle('active');
}

memberIcon.onclick = () =>
{
    memberMenu.classList.toggle('open-menu');
}

memberDashboard.onclick = () =>
{
    memberDashboardMenu.style.width = "280px";
}

window.onscroll = () => {
    menu.classList.remove('bx-x');
    navbar.classList.remove('active');
    loginMenu.classList.remove('show');
}