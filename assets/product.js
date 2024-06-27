import "./styles/product.scss";

let product = (function () {
  "use strict";

  const init = function () {
    const showMoreButtons = document.querySelectorAll(
      ".product-table__specs__buton-more"
    );
    console.log(showMoreButtons);
    const handleShowMoreButtonClick = function () {
      const arrow = this.querySelector(
        ".product-table__specs__buton-more__arrow"
      );
      const description = this.parentElement.parentElement.nextElementSibling;

      arrow.classList.toggle("product-table__specs__buy-now__arrow--down");
      description.classList.toggle("product-table__description--show");
    };

    for (let i = 0; i < showMoreButtons.length; i++) {
      showMoreButtons[i].addEventListener("click", handleShowMoreButtonClick);
    }
  };

  return {
    init,
  };
})();

product.init();
