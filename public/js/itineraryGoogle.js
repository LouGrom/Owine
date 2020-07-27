function initMap() {

  var options = {
    center: { lat: 48.8534, lng: 2.3488 },
    zoom: 4
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
    var pointA = new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
    pointB = new google.maps.LatLng(arrival.lat, arrival.lng),
    myOptions = {
      zoom: 10,
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
      'Erreur: Accès position geographique non autorisé - vérifiez vos autorisation ou l\'activation de votre GPS.' :
      
      'Erreur: Vote navigateur ne supporte pas le service de geolocalisation.');
    infoWindow.open(map);
  }

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
