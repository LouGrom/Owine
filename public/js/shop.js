let appShop = {

    init: function(){
        console.log("BIP BOUP, SCRIPT INITIALISÉ");
        var radioBtn = document.querySelectorAll('.priceFilters');
        let len = radioBtn.length;

        // assign function to onclick property of each radio button
        for (var i = 0; i < len; i++) {
            radioBtn[i].addEventListener('change', appShop.isClicked);
        }
    },

    isClicked: function(event) {

        let checkedPrice = event.currentTarget;
        console.log("TU AS CLIQUÉ SUR UN BOUTON, AAAAAAAAAH");
        console.log(checkedPrice.value);;
;
        let productCards = document.querySelectorAll('.product-card');
        let productPrice = 0;
        let len = productCards.length;
        for (var i = 0; i < len; i++) {
            productCardPrice = productCards[i].querySelector('.product-card__price')
            console.log(productCardPrice)
            productPrice = parseFloat(productCardPrice.innerText);
            console.log(productPrice);
            if(productPrice > checkedPrice.value && checkedPrice.value != 0) {
                productCards[i].setAttribute("hidden", "hidden");
            } else {
                productCards[i].removeAttribute("hidden", "hidden");
            }
            
            
            
        }
    }
}


document.addEventListener('DOMContentLoaded', appShop.init);