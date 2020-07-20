let appCart = {

    addCartBaseLink : document.querySelector('#addCartBtn').href,

    init: function(){

        var quantityInput = document.querySelector('#quantity');
        var quantityForm = document.querySelector('#quantityForm');
        var stockQuantity = document.querySelector('#stockQuantity');
        console.log('Quantité max : ' + stockQuantity.innerText)
        console.log(quantityForm)
        console.log(appCart.addCartBaseLink)

        quantityForm.addEventListener('submit', appCart.handleFormSubmit);
        quantityInput.addEventListener('change', appCart.isChanged);
        // console.log(quantityInput)
    },

    isChanged: function(event) {
        
        appCart.hasError('');
        let result = event.target.value;
        
        if(result < 0) {
            result = 0
            event.target.value = 0
        }

        if(result > parseInt(stockQuantity.innerText)) {
            appCart.hasError('Stock insuffisant');
            document.querySelector('#addCartBtn').href = '#';
        } else {

            document.querySelector('#addCartBtn').href = appCart.addCartBaseLink + result;
            console.log(appCart.addCartBaseLink + result)
        }
        console.log(result)
    },

    handleFormSubmit: function(event) {

        event.preventDefault();
    },

    hasError: function(errorMessage) {
        
        
        document.querySelector('#errorField').innerText = errorMessage
        appCart.init;
    }

}

document.addEventListener('DOMContentLoaded', appCart.init);