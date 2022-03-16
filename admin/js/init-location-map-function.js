

function initMap(){

              var lat = parseFloat(document.getElementById('coordinatelat-values-from-info-contact').value);
              var lng = parseFloat(document.getElementById('coordinatelng-values-from-info-contact').value);
              var myIconMarker = document.getElementById('meta-image-iconmarker-url').value;
              var colorMap = document.getElementById('color-map-location').value;   
              var address = (document.getElementById('address').value ? document.getElementById('address').value : '');   
              var phone = (document.getElementById('phone') ? document.getElementById('phone').value : '');     
              var site_name = document.getElementById('site-name').value;    
                    

              var coordinates = {'lat' : lat , 'lng' : lng };
            
              
              var map = new google.maps.Map(document.getElementById('google-map'), {
                zoom: 16,
                center: coordinates,
                scrollwheel: false // to disable mouse scroll in the map. 
              });    
                
        
            var brownStyle = [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}];

            var grayStyle = [{"stylers":[{"saturation":-100},{"gamma":1}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":50},{"gamma":0},{"hue":"#50a5d1"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"weight":0.5},{"color":"#333333"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"gamma":1},{"saturation":50}]}];

            var blackStyle = [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]}, {"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]},
                                {"featureType": "road","elementType": "labels","stylers": [{ "visibility": "simplified" }]}
                              ]; 
            
            var aquaStyle2 = [
              {
                stylers: [
                  { hue: "#00ffe6"},
                  { saturation: -20 },                      
                ]
              },
              {
                featureType: "water",
                elementType: "geometry",
                stylers: [
                  { lightness: 100 },
                  { visibility: "simplified" } 
                ]
              },
              {
                featureType: "road",
                elementType: "labels",
                stylers: [
                  { visibility: "on" } 
                ]
              }
            ];
            var asignColor = blackStyle;

            if( colorMap == 'grayStyle')    asignColor = grayStyle;
            else if( colorMap == 'aquaStyle2')    asignColor = aquaStyle2;

            map.setOptions({styles: asignColor }); 

            var marker = new google.maps.Marker({
                position: coordinates,
                map: map,          
               /* title: 'We are here',*/
                icon: myIconMarker,
               
              }); 

            var contentString = '<div id="content" class="noscroll">'+     

              '<div id="bodyContent">'+             
              '<br /><strong>'+address+'<br />'+phone+
              '</strong></div>'+
              '</div>';

            var infowindow = new google.maps.InfoWindow({
            content: contentString
            });
            marker.addListener('click', function() {
            infowindow.open(map, marker);
            });
          

}