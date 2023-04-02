const chest = document.querySelector(".treasure-chest");
const light = document.querySelector(".light");
// console.log(light)
const modal = document.getElementById("myModal1");
const md = document.getElementById("myModal");
const modalPassword = document.getElementById("modalPassword");
const inputpass = document.getElementById("password");
const savePass = document.getElementById("savePass");
const modalEnterPass = document.getElementById("modalEnterPass");
const enterPassword = document.getElementById("enterPassword");
const sendPass = document.getElementById("sendPass");
const modalBiKip = document.getElementById("modalBiKip");
const mdS = document.querySelector('#area');
chest.addEventListener("click", () => {
  const password = localStorage.getItem("password");
  if (!password) {
    modalPassword.style.display = " block";
  } else {
    modalEnterPass.style.display = " block";
  }
});
savePass.addEventListener("click", () => {
  if (inputpass.value.length > 1) {
    modalPassword.style.display = " none";
    localStorage.setItem("password", inputpass.value);
  }
});
sendPass.addEventListener("click", () => {
  const password = localStorage.getItem("password");
  const bikip = localStorage.getItem("findBiKip");

  console.log("heni", enterPassword.value);
  console.log("heni1", password);
  if (enterPassword.value === password && bikip) {
    modalEnterPass.style.display = "none";
    modalBiKip.style.display = "block";
  }
  else if(enterPassword.value !== password){
    alert("Nhập sai mật khẩu");
  }
  else{
    alert("Đại hiệp chưa tìm được bí kíp")
  }
});
light.addEventListener("click", () => {
  modal.style.display = "block";
});

window.onclick = function (event) {
  if (event.target == modal || event.target == modalPassword || event.target == modalEnterPass || event.target == modalBiKip || event.target == md || event.target == mdS) {
    modal.style.display = "none";
    modalPassword.style.display = " none";
    modalEnterPass.style.display = "none";
    modalBiKip.style.display = "none";
    md.style.display = "none";
    mdS.style.display = "none";
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

