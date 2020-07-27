var map, infoWindow;

function initMap() {
    var options = {
      center: { lat: 48.8534, lng: 2.3488 },
      zoom: 17
  };
  
  console.log('test');
  
  map = new google.maps.Map(document.getElementById("map"), options);
  
  infoWindow = new google.maps.InfoWindow;
  
  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      console.log('test2');
      infoWindow.setPosition(pos);
      infoWindow.setContent('Vous êtes ici');
      infoWindow.open(map);
      map.setCenter(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {console.log('test3');
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
  }
  
  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);console.log('test4');
    infoWindow.setContent(browserHasGeolocation ?
      'Error: The Geolocation service failed.' :
      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }