import "../styles/product.scss";

let product = (function () {
  "use strict";

  const init = function () {
    const showMoreButtons = document.querySelectorAll(
      ".product__items__item__specs__details__button-more"
    );

    const handleShowMoreButtonClick = function () {
      const arrow = this.querySelector(
        ".product__items__item__specs__details__button-more__arrow"
      );
      const description = this.parentElement.parentElement.nextElementSibling;
      console.log(description);
      arrow.classList.toggle(
        "product__items__item__specs__details__buy-now__arrow--down"
      );
      description.classList.toggle("product__items__item__description--show");
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
