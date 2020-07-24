var map, infoWindow, placeSearch, autocomplete;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'long_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initMap() {
  var options = {
    center: { lat: 48.8534, lng: 2.3488 },
    zoom: 15
};

initAutocomplete();

map = new google.maps.Map(document.getElementById("map"), options);

infoWindow = new google.maps.InfoWindow;

// Try HTML5 geolocation.
if (navigator.geolocation) {
  navigator.geolocation.watchPosition(function(position) {
    var pos = {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    };

    infoWindow.setPosition(pos);
    infoWindow.setContent('Vous êtes ici');
    infoWindow.open(map);
    map.setCenter(pos);
  }, function() {
    handleLocationError(true, infoWindow, map.getCenter());
  });
} else {
  // Browser doesn't support Geolocation
  handleLocationError(false, infoWindow, map.getCenter());
}
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
    'Error: The Geolocation service failed.' :
    'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
}

function initAutocomplete() {
// Create the autocomplete object, restricting the search predictions to
// geographical location types.
autocomplete = new google.maps.places.Autocomplete(
    document.getElementById('autocomplete'), {types: ['geocode']});

// Avoid paying for data that you don't need by restricting the set of
// place fields that are returned to just the address components.
autocomplete.setFields(['address_component']);

// When the user selects an address from the drop-down, populate the
// address fields in the form.
autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
  var street = document.querySelector('#address');
  street.value = place.address_components[0].short_name + ' ' + place.address_components[1].long_name;
  var iso = document.querySelector('#iso');
  iso.value = place.address_components[5].short_name ;
  // var city = document.querySelector('#locality');
  // city.value = place.address_components[2].long_name;
  // var postal_code = document.querySelector('#postal_code');
  // postal_code.value = place.address_components[6].short_name;
  // var administrative_area_level_1 = document.querySelector('#administrative_area_level_1');
  // administrative_area_level_1.value = place.address_components[3].short_name;
  // var country = document.querySelector('#country');
  // country.value = place.address_components[5].long_name;
  console.log(place);
  // console.log(place.address_components[0].long_name);
  // console.log(place.address_components[0].short_name);
  // console.log(place.address_components[1].long_name);
  // console.log(place.address_components[1].short_name);
  // console.log(place.address_components[2].long_name);
  // console.log(place.address_components[2].short_name);
  // console.log(place.address_components[3].long_name);
  // console.log(place.address_components[3].short_name);
  // console.log(place.address_components[4].long_name);
  // console.log(place.address_components[4].short_name);
  // console.log(place.address_components[5].long_name);
  // console.log(place.address_components[5].short_name);
  // console.log(place.address_components[6].long_name);
  // console.log(place.address_components[6].short_name);

  // console.log(places.bounds);


  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    // console.log(addressType);
    // console.log(componentForm[addressType]);
      if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        document.getElementById(addressType).value = val;
      }
  }

  var address = place.address_components[0].short_name + ' ' + place.address_components[1].long_name + ', ' + place.address_components[2].long_name + ', ' + place.address_components[6].short_name + ', ' + place.address_components[3].long_name + ', ' + place.address_components[5].long_name;
  console.log(address);
  var geocoder = new google.maps.Geocoder();
  console.log(geocoder);
  geocoder.geocode({'address': address}, function (coord) {
      console.log(coord[0].geometry.location);
      // Et centrage de la map sur les coordonnées renvoyées par Google :
      infoWindow.setPosition(coord[0].geometry.location);
      infoWindow.setContent('Voici l\'adresse indiquée');
      map.setCenter(coord[0].geometry.location);
});
}

// options = {
//   center: { lat: 48.8534, lng: 2.3488 },
//   zoom: 15
// };


// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
// function geolocate() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(function(position) {
//       var geolocation = {
//         lat: position.coords.latitude,
//         lng: position.coords.longitude
//       };
//       var circle = new google.maps.Circle(
//           {center: geolocation, radius: position.coords.accuracy});
//       autocomplete.setBounds(circle.getBounds());
//     });
//   }
// }
