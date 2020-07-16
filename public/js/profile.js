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
        // On prépare la configuration de la requête HTTP
        var myInit = {
            method: 'PATCH',
            mode: 'cors',
            cache: 'no-cache',
            headers: {
                'Content-Type': 'application/json'
            }
        };

        // On déclenche la requête HTTP (via le moteur sous-jacent Ajax)
        return fetch(app.apiBaseUrl + '/destination/' + destinationId + '/add', myInit)
            // Ensuite, lorsqu'on reçoit la réponse au format JSON
            .then(function (responseText) {
                return responseText.status;
            })
    },

    uncheckDestination: function (destinationId) {
        // On prépare la configuration de la requête HTTP
        var myInit = {
            method: 'PATCH',
            mode: 'cors',
            cache: 'no-cache',
            headers: {
                'Content-Type': 'application/json'
            },
        };

        // On déclenche la requête HTTP (via le moteur sous-jacent Ajax)
        return fetch(app.apiBaseUrl + '/destination/' + destinationId + '/remove', myInit)
            // Ensuite, lorsqu'on reçoit la réponse au format JSON
            .then(function (responseText) {
                console.log(responseText.status);
                return responseText.status;
            })
    },
}

document.addEventListener('DOMContentLoaded', app.init);