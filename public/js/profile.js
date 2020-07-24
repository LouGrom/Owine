let app = {

    apiBaseUrl: 'https://owine.shop/',

    init: function () {
        // console.log("Script initialisé");
        var checkedBox = document.querySelectorAll('.destination:checked');
        // get reference to input elements
        var destinations = document.querySelectorAll('.destination');
        var packagesValidation = document.querySelectorAll('#bAcep');       
        var addPackageBtn = document.querySelector('.addPackage');
        var packageDeleteBtn = document.querySelectorAll('#bElim');

        // assign function to onclick property of each checkbox
        for (var i = 0, len = destinations.length; i < len; i++) {
            if (destinations[i].type === 'checkbox') {
                destinations[i].addEventListener('click', app.isClicked);
            }
        }

        for (var i = 0, len = packagesValidation.length; i < len; i++) {
                packagesValidation[i].addEventListener('click', app.isSaved);
        }
        
        for (var i = 0, len = packageDeleteBtn.length; i < len; i++) {
            packageDeleteBtn[i].addEventListener('click', app.isRemoved);
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
        let packageId = row.querySelector('.packageId').innerText;
        let quantity = row.querySelector('.bottleQuantity').innerText;
        let height = row.querySelector('.height').innerText;
        let length = row.querySelector('.length').innerText;
        let width = row.querySelector('.width').innerText;
        let weight = row.querySelector('.weight').innerText;
        
        console.log(row)
        console.log('packageId : ' + packageId);
        console.log('quantity : ' + quantity);
        console.log('height : ' + height);
        console.log('length : ' + length);
        console.log('width : ' + width);
        console.log('weight : ' + weight);

        let packageDatas = packageId+'-'+quantity+'-'+height+'-'+length+'-'+width+'-'+weight;
        
        fetch(app.apiBaseUrl + '/package/' + packageDatas + '/add')
        document.location.reload(true);
        return

    },

    isRemoved: function(event) {

        let removeButton = event.currentTarget;
        let row = removeButton.closest('tr');
        let packageId = row.querySelector('.packageId').innerText;
        console.log(packageId);
        fetch(app.apiBaseUrl + '/package/' + packageId + '/remove');
        document.location.reload(true);
        return;

    }
    
}

document.addEventListener('DOMContentLoaded', app.init);