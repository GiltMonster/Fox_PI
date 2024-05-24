let close = document.querySelector(".closebtn");

let alert = document.querySelector(".alert");

if (alert) {
  setTimeout( () => {
        alert.style.opacity = "0";
        setTimeout(function () { alert.style.display = "none"; }, 600);
  }, 4000);
}

close.addEventListener( `click`, () => {
  alert.style.opacity = "0";
  setTimeout(function () { alert.style.display = "none"; }, 200);
})

