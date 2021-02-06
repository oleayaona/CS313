let productImage = document.querySelectorAll(".product-img");

for (var i = 0; i < productImage.length; i++) {
    productImage[i].setAttribute('style', `data-item`);
}