const fixedOptions = {
    appId: 'plZJ79P6OE4H',
    apiKey: 'c28a669b8b82c531a30f8cf0ca708ca0',
    container: document.querySelector('#form-address'),
};
  
const reconfigurableOptions = {
language: 'fr', // Receives results in French
countries: ['fr', 'us', 'ru'], // Search in the United States of America and in the Russian Federation
type: ['country', 'city', 'address'], // Search for countries + cities names + address
aroundLatLngViaIP: false // disable the extra search/boost around the source IP
};
const placesInstance = places(fixedOptions).configure(reconfigurableOptions);

// dynamically reconfigure options
placesInstance.configure({
countries: ['us'] // only search in the United States, the rest of the settings are unchanged: we're still searching for cities in German.
});

placesAutocomplete.on('clear', function() {
    $address.textContent = 'none';
});
  