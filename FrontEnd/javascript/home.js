
const toTopButton = document.querySelector(".to-top");

  toTopButton.addEventListener("click", function() {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });
  