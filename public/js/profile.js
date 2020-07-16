let app = {

    apiBaseUrl: 'http://localhost:8000',

    init: function () {
        // console.log("Script initialisé");
        var checkedBox = document.querySelectorAll('.destination:checked');

        // get reference to input elements
        var destinations = document.querySelectorAll('.destination');

        // assign function to onclick property of each checkbox
        for (var i = 0, len = destinations.length; i < len; i++) {
            if (destinations[i].type === 'checkbox') {
                destinations[i].addEventListener('click', app.isClicked);
            }
        }

        var packages = document.querySelectorAll('.package');

        // assign function to onclick property of each checkbox
        for (var i = 0, len = packages.length; i < len; i++) {
            if (packages[i].type === 'checkbox') {
                packages[i].addEventListener('click', app.isClicked);
            }
        }
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
}

document.addEventListener('DOMContentLoaded', app.init);