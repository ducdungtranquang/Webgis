var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};
const mapELement = document.querySelector("#map");
const toolTip = document.querySelector(".tool_tip");


mapELement.addEventListener("mousemove", e => {
    toolTip.classList.remove("hide_tool_tips");
    document.querySelector(".coordinateX").innerHTML = e.offsetX;
    document.querySelector(".coordinateY").innerHTML = e.offsetY;
    // toolTip.style.top = e.offsetY + 12 + "px";
    // toolTip.style.left = e.offsetX + "px";
})

mapELement.addEventListener('mouseleave', () => {
    toolTip.classList.add("hide_tool_tips");
})