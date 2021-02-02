var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++)
{
    coll[i].addEventListener("click", function()
    {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block")
        {
            content.style.display = "none";
        }
        else
        {
            content.style.display = "block";
        }
    });
}

// Modal for "Assign asset" button
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");

btn.addEventListener('click', function()
{
    modal.style.display = "block";
}, false);

window.addEventListener('click', function() // When the user clicks anywhere outside of the modal, close it
{
    if (event.target == modal)
    {
        modal.style.display = "none";
    }
}, false);



// Modal for "Check-in" button
var modal2 = document.getElementById("myModal2");
var modal3 = document.getElementById("myModal3");
var yesBtn = document.getElementById("yesBtn");
var noBtn = document.getElementById("noBtn");
var okBtn = document.getElementById("okBtn");
var btns = document.getElementsByClassName("myBtn2");

// When the user clicks on "checkin" button, open the modal
var openModal = function()
{
    modal2.style.display = "block";
    var id = this.parentNode.parentNode.attributes[0].value;
    console.log(id);

    // Yes button.
    yesBtn.addEventListener('click', function()
    {
        var xhr = new XMLHttpRequest();
        xhr.onload = function()
        {
            if (this.status == 200)
            {
                var txt = xhr.responseText;
                console.log(txt);
                if(txt[2] !== "<")
                {    
                    txt = JSON.parse(txt);
                    window.location.href = "/1/error.php?error=" + JSON.stringify(txt);
                }
                
                modal3.style.display = "block";
                modal2.style.display = "none";
            }
        };

        xhr.onerror = function()
        {
            console.log("XHR error..!");
        }

        xhr.open("GET", "delete_assign.php?id=" + id + "&sid=" + Math.random(), true);
        xhr.send();

    }, false);
};
for (var i = 0; i < btns.length; i++)
{
    btns[i].addEventListener('click', openModal, false);
}

// No button.
noBtn.addEventListener('click', function()
{
    modal2.style.display = "none";
}, false);

// OK button.
okBtn.addEventListener('click', function()
{
    modal3.style.display = "none";
    location.reload();
}, false);

window.addEventListener('click', function()
{
    if (event.target == modal2)
    {
        modal2.style.display = "none";
    }
}, false);



// Functionality for 'X' symbol in modals.
var spans = document.getElementsByClassName("close");
var closeModal = function()
{
    modal.style.display = "none";
    modal2.style.display = "none";
    modal3.style.display = "none";
};
for (var i = 0; i < spans.length; i++)
{
    spans[i].addEventListener('click', closeModal, false);
}