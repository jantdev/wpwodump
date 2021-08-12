const carousel = document.querySelector(".carousel-items");
const back = document.querySelector(".back");
const next = document.querySelector(".next");
const sliderImage = document.querySelector("#slider1");
const dot = document.querySelector(".carousel-dot");
const init = 100;
let click = 0;
let current = init;
let jump = 990;

initSize = () => {
  const imageWidth = parseInt(
    window.getComputedStyle(sliderImage).getPropertyValue("width")
  );
  if (imageWidth == 790) {
    jump = 1000;
  } else if (imageWidth == 500) {
    jump = 1074;
  } else if (imageWidth == 400) {
    jump = 1100;
  }
};

window.addEventListener("resize", (event) => {
  initSize();
});

window.addEventListener("load", () => {
  initSize();
  carousel.style.left = init + "px";
  updateDots(click);
});

back.addEventListener("click", () => {
  let jumpback = current + jump;
  if (click > 0) {
    carousel.style.left = jumpback + "px";
    current = jumpback;
    click--;
    updateDots(click);
  }
});

next.addEventListener("click", () => {
  let jumpnext = current - jump;
  if (click < 4) {
    carousel.style.left = jumpnext + "px";
    current = jumpnext;
    click++;
    updateDots(click);
  }
});

updateDots = (index) => {
  let output = "";
  for (let x = 0; x < 5; x++) {
    if (x === index) {
      output +=
        '<span class="material-icons select"> radio_button_checked </span>';
    } else {
      output += '<span class="material-icons"> fiber_manual_record </span>';
    }
  }
  dot.innerHTML = output;
};
