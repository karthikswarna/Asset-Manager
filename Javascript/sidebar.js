// Functionality for sidebar

var sidebar = document.getElementById("mySidebar");
var navLink = document.getElementById("navLink");
navLink.addEventListener('click', function()
{
    sidebar.style.display = "block";
}, false);

var sidebarClose = document.getElementById("mySidebar").getElementsByTagName("BUTTON")[0];
sidebarClose.addEventListener('click', function()
{
    sidebar.style.display = "none";
}, false);

// Not working.
// window.addEventListener('click', function()
// {
//     if (event.target == sidebar)
//     {
//         sidebar.style.display = "none";
//     }
// }, false);