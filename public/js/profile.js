let app = {

    apiBaseUrl: 'http://localhost:8000',

    init: function () {
        // console.log("Script initialisé");
        var checkedBox = document.querySelectorAll('.destination:checked');
        // get reference to input elements
        var destinations = document.querySelectorAll('.destination');
        var packagesValidation = document.querySelectorAll('#bAcep');       
        var addPackageBtn = document.querySelector('.addPackage');

        // assign function to onclick property of each checkbox
        for (var i = 0, len = destinations.length; i < len; i++) {
            if (destinations[i].type === 'checkbox') {
                destinations[i].addEventListener('click', app.isClicked);
            }
        }

        for (var i = 0, len = packagesValidation.length; i < len; i++) {
                packagesValidation[i].addEventListener('click', app.isSaved);
        }

        addPackageBtn.addEventListener('click', app.init);
    },

    isClicked: function (event) {

        let checkedDestination = event.currentTarget;

        if (checkedDestination.checked == true) {
            app.checkDestination(checkedDestination.value);

        } else {
            app.uncheckDestination(checkedDestination.value);
        }

    },

    checkDestination: function (destinationId) {
        // ça fonctionne parce qu'on est des H4CK3RS (et que j'm'appelle Bob le Bricoleur)
        return fetch(app.apiBaseUrl + '/destination/' + destinationId + '/add');
    },

    uncheckDestination: function (destinationId) {
    
        return fetch(app.apiBaseUrl + '/destination/' + destinationId + '/remove');
    },

    isSaved: function (event) {

        console.log("TU AS APPUYÉ SUR LE BOUTON DE VALIDATION ! AAAAAH !!")
        
        let saveButton = event.currentTarget;
        let row = saveButton.closest('tr');
        console.log(row)
        let packageId = row.querySelector('.packageId').innerText;
        console.log('packageId : ' + packageId);
        let quantity = row.querySelector('.bottleQuantity').innerText;
        console.log('quantity : ' + quantity);
        let height = row.querySelector('.height').innerText;
        console.log('height : ' + height);
        let length = row.querySelector('.length').innerText;
        console.log('length : ' + length);
        let width = row.querySelector('.width').innerText;
        console.log('width : ' + width);
        let weight = row.querySelector('.weight').innerText;
        console.log('weight : ' + weight);

        let packageDatas = quantity+'-'+height+'-'+length+'-'+width+'-'+weight;
        
        return fetch(app.apiBaseUrl + '/package/' + packageDatas + '/add');

    },
    
}

document.addEventListener('DOMContentLoaded', app.init);