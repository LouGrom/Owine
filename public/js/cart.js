let appCart = {

    apiBaseUrl: 'http://localhost:8000',

    init: function () {
        console.log("Script initialisé. BIP BOP");
        var products = document.querySelectorAll('.product-row');

        len = products.length;
        for (var i = 0; i < len; i++) {
            products[i].querySelector('.quantity').addEventListener('change', appCart.isChanged);
        }
    },

    isChanged: function(event) {
        
        let input = event.target;

        if(input.value < 1 ){
            input.value = 1;
        }
        tableRow = input.closest('tr');
        table = tableRow.closest('table');

        productPrice = tableRow.querySelector('.productPrice');
        productTotalPrice = tableRow.querySelector('.productTotalPrice');
        totalAmount = table.querySelector('.totalAmount');
        quantity = input.value;

        fetch(appCart.apiBaseUrl + '/cart/'+ tableRow.id +'/editQuantity/' + quantity)

        totalAmount.innerText = (parseFloat(totalAmount.innerText) - parseFloat(productTotalPrice.innerText) + (quantity * parseFloat(productPrice.innerText))).toFixed(2);
        productTotalPrice.innerText = (quantity * parseFloat(productPrice.innerText)).toFixed(2);

        return;
    },
    
}

document.addEventListener('DOMContentLoaded', appCart.init);