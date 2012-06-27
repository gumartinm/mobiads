var map;
var oldMarker;

function initialize() {
        var longitude = document.getElementById('office_longitude');
        var latitude = document.getElementById('office_latitude');
        var myLatlng = new google.maps.LatLng(latitude.value, longitude.value);
        var myOptions = {
          zoom: 8,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

        oldMarker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title:"Your office"
        });

        google.maps.event.addListener(oldMarker, 'click', function() {
                map.setZoom(15);
                map.setCenter(marker.getPosition());
        });

        google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
        });
    }

function placeMarker(location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });

        oldMarker.setMap(null);
        oldMarker = marker;
        map.setCenter(location);
        var longitude = document.getElementById('office_longitude');
        var latitude = document.getElementById('office_latitude');
        longitude.value = location.lng().toFixed(4);
        latitude.value = location.lat().toFixed(4);
    }

function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC12sfHN7LppY0AkhTRzCCZEAAjMCT3BEM&sensor=false&callback=initialize';
        document.body.appendChild(script);
      }

      window.onload = loadScript;

    google.maps.event.addDomListener(window, 'load', initialize);
