<!DOCTYPE html>
<html>
  <head>
    <title>
      Mobile Ads: advertising GEO localizatiodafdafdsdfan
    </title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>
    <script type="text/javascript">
        var map;
        var oldMarker;

        function initialize() {
            var myLatlng = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>);
            var myOptions = {
                zoom: <?php echo $zoom ?>,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

             map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

            oldMarker = new google.maps.Marker({
                position: myLatlng,
                map: map
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
            var adLongitude = self.opener.document.getElementById('office_longitude');
            var adLatitude = self.opener.document.getElementById('office_latitude');
            adLongitude.value = location.lng().toFixed(4);
            adLatitude.value = location.lat().toFixed(4);
        }

        function loadScript() {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC12sfHN7LppY0AkhTRzCCZEAAjMCT3BEM&sensor=false&callback=initialize';
            document.body.appendChild(script);
        }

        window.onload = loadScript;

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>

  <body>
    <div id="map_canvas" style="width:100%; height:100%"></div>
  </body>
</html>

