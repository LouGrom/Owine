

// function initMap() {
//   var options = {
//     center: { lat: 48.8534, lng: 2.3488 },
//     zoom: 15
// };


// map = new google.maps.Map(document.getElementById("map"), options);

// infoWindow = new google.maps.InfoWindow;

// // Try HTML5 geolocation.
// if (navigator.geolocation) {
//   navigator.geolocation.watchPosition(function(position) {
//     var pos = {
//       lat: position.coords.latitude,
//       lng: position.coords.longitude
//     };

//     infoWindow.setPosition(pos);
//     infoWindow.setContent('Vous êtes ici');
//     infoWindow.open(map);
//     map.setCenter(pos);
//   }, function() {
//     handleLocationError(true, infoWindow, map.getCenter());
//   });
// } else {
//   // Browser doesn't support Geolocation
//   handleLocationError(false, infoWindow, map.getCenter());
// }
// }

// function handleLocationError(browserHasGeolocation, infoWindow, pos) {
//   infoWindow.setPosition(pos);
//   infoWindow.setContent(browserHasGeolocation ?
//     'Error: The Geolocation service failed.' :
//     'Error: Your browser doesn\'t support geolocation.');
//   infoWindow.open(map);
// }


function initMap() {

  var options = {
    center: { lat: 48.8534, lng: 2.3488 },
    zoom: 10
  };

  map = new google.maps.Map(document.getElementById("map"), options);

  var destination = document.getElementById("companyAddress").innerHTML;
  // console.log(destination);
  var arrival;

  var geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'address': destination }, function (coord) {
    // console.log(coord[0].geometry.location);
    arrival = { lat: coord[0].geometry.location.lat(), lng: coord[0].geometry.location.lng() };
    // console.log(arrival);
  });

  infoWindow = new google.maps.InfoWindow;

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(function (position) {
      // var pos = {
      //   lat: position.coords.latitude,
      //   lng: position.coords.longitude
      // };

      // infoWindow.setPosition(pos);
      // infoWindow.setContent('Vous êtes ici');
      // infoWindow.open(map);
      // map.setCenter(pos);

      var pointA = new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
      pointB = new google.maps.LatLng(arrival.lat, arrival.lng),
      myOptions = {
        zoom: 7,
        center: pointA
      },
      
      // Instantiate a directions service.
      directionsService = new google.maps.DirectionsService,
      directionsDisplay = new google.maps.DirectionsRenderer({
        map: map
      }),
      markerA = new google.maps.Marker({
        position: pointA,
        title: "point A",
        label: "A",
        map: map
      }),
      markerB = new google.maps.Marker({
        position: pointB,
        title: "point B",
        label: "B",
        map: map
      });

    // get route from A to B
    calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
    }, function () {
      handleLocationError(true, infoWindow, map.getCenter());
    });
    
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
      'Error: The Geolocation service failed.' :
      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }


    // var pointA = new google.maps.LatLng(48.8534, 2.3488),
      // pointB = new google.maps.LatLng(coord[0].geometry.location.lat(), coord[0].geometry.location.lng()),
      // myOptions = {
      //   zoom: 7,
      //   center: pointA
      // },
      // map = new google.maps.Map(document.getElementById('map'), myOptions),
      // // Instantiate a directions service.
      // directionsService = new google.maps.DirectionsService,
      // directionsDisplay = new google.maps.DirectionsRenderer({
      //   map: map
      // }),
      // markerA = new google.maps.Marker({
      //   position: pointA,
      //   title: "point A",
      //   label: "A",
      //   map: map
      // }),
      // markerB = new google.maps.Marker({
      //   position: pointB,
      //   title: "point B",
      //   label: "B",
      //   map: map
      // });

    // get route from A to B
    // calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);





  function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
    directionsService.route({
      origin: pointA,
      destination: pointB,
      avoidTolls: true,
      avoidHighways: false,
      travelMode: google.maps.TravelMode.DRIVING
    }, function (response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });


  }
}
