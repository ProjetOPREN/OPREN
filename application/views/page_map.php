<head>
  <style>
    #map {
      height: 500px;
      width: 100%;
     }
  </style>
  </head>


<!-- !PAGE CONTENT! -->
<div  class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Formulaire d'Offres -->
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge title_color"><b>Carte de Rennes</b></h1>
     <hr class="w3-round bar">
    <form action="add_offer" method="POST">
      <div class="w3-section">
     <h3>Plan des parkings</h3>
    <div id="map"></div>
    <script>
    var currentInfoWindow = null;
      function initMap() {
        var parking1 = {lat: 48.104269, lng: -1.715388};
        var parking2 = {lat: 48.088110, lng: -1.705172};
        var parking3 = {lat: 48.083102, lng: -1.676891};
        var parking4 = {lat: 48.087006, lng: -1.643345};
        var parking5 = {lat: 48.090242, lng: -1.626043};
        var bruz = {lat: 48.033325, lng: -1.744241};
        var opren = {lat: 48.0895072, lng: -1.6882092};

        //Initialisation de la carte
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: opren,
      mapTypeId: 'roadmap'
        });
        //Personalisation des markers
        var parking = {
      // Adresse de l'icône personnalisée
      url: 'http://opren.istic.univ-rennes1.fr/assets/img/parking.png'
    };
    var balle = {
      // Adresse de l'icône personnalisée
      url: 'http://opren.istic.univ-rennes1.fr/assets/img/balles.png'
    };

        var marker1 = new google.maps.Marker({
          position: parking1,
          icon: parking,
          title:"Parking Cleunay"
        })

        var marker2 = new google.maps.Marker({
          position: parking2,
          icon: parking,
          title: 'Parking Castorama St-Jacques'
        });
        var marker3 = new google.maps.Marker({
          position: parking3,
          icon: parking,
          title: 'Parking Alma'
        });
        var marker4 = new google.maps.Marker({
          position: parking4,
          icon: parking,
          title: 'Parking La Poterie'
        });
        var marker5 = new google.maps.Marker({
          position: parking5,
          icon: parking,
          title: 'Parking Decathlon Chantepie'
        });
        var markerbruz = new google.maps.Marker({
          position: bruz,
          icon: balle,
          title: 'TC Bruz'
        });

        var markeropren = new google.maps.Marker({
          position: opren,
          icon: balle,
          title: 'Salle colette Besson'
        });


        // click marqueur ouvre infoBulle
        var parkingcleunay =
          '<h1>Parking Cleunay</h1>'+
          '<p><b>Adresse : </b>Rue Jules Vallès, 35000 Rennes</p>';

          var parkingcasto =
            '<h2>Parking Castorama St-Jacques</h2>'+
            '<p><b>Adresse : </b>140 Rue du Temple de Blosne, 35136 Saint-Jacques-de-la-Lande</p>';

          var parkingalma =
            '<h2>Parking Alma</h2>'+
            '<p><b>Adresse : </b>5 Rue du Boshore, 35200 Rennes</p>';

            var parkingpoterie =
              '<h2>Parking La Poterie</h2>'+
              '<p><b>Adresse : </b>Rue Emile Littré, 35200 Rennes</p>';

            var parkingdecathlon =
              '<h2>Parking Decathlon Chantepie</h2>'+
              '<p><b>Adresse : </b>3 Rue du Moulin, 35135 Chantepie</p>';

            var parkingbruz =
                '<h2>TC Bruz</h2>'+
                '<p><b>Adresse : </b>La Bihardais, Rue du 8 mai 1944, 35170 Bruz</p>';

            var opren =
                '<h2>Salle Colette Besson</h2>'+
                '<p><b>Adresse : </b>12 Boulevard Albert-Ier, 35200 Rennes</p>'

        var cleunay = new google.maps.InfoWindow({
          content: parkingcleunay
        })
        google.maps.event.addListener(marker1, 'click', function(){
          if (currentInfoWindow != null) {
        currentInfoWindow.close();
        }
          cleunay.open(map,marker1);
        currentInfoWindow = cleunay;
        });

        var casto = new google.maps.InfoWindow({
          content: parkingcasto
        })
       google.maps.event.addListener(marker2, 'click', function(){
         if (currentInfoWindow != null) {
       currentInfoWindow.close();
       }
          casto.open(map,marker2);
          currentInfoWindow = casto;
        });
        var alma = new google.maps.InfoWindow({
          content: parkingalma
        })
        google.maps.event.addListener(marker3, 'click', function(){
          if (currentInfoWindow != null) {
        currentInfoWindow.close();
        }
          alma.open(map,marker3);
          currentInfoWindow = alma;
        });
        var poterie = new google.maps.InfoWindow({
          content: parkingpoterie
        })
        google.maps.event.addListener(marker4, 'click', function(){
          if (currentInfoWindow != null) {
        currentInfoWindow.close();
        }
          poterie.open(map,marker4);
          currentInfoWindow = poterie;
        });
        var decathlon = new google.maps.InfoWindow({
          content: parkingdecathlon
        })
        google.maps.event.addListener(marker5, 'click', function(){
          if (currentInfoWindow != null) {
        currentInfoWindow.close();
        }
          decathlon.open(map,marker5);
          currentInfoWindow = decathlon;
        });
        var bruz = new google.maps.InfoWindow({
          content: parkingbruz
        })

        google.maps.event.addListener(markerbruz, 'click', function(){
          if (currentInfoWindow != null) {
        currentInfoWindow.close();
        }
          bruz.open(map,markerbruz);
          currentInfoWindow = bruz;
        });
        var openrennes = new google.maps.InfoWindow({
          content: opren
        })

        google.maps.event.addListener(markeropren, 'click', function(){
          if (currentInfoWindow != null) {
        currentInfoWindow.close();
        }
          openrennes.open(map,markeropren);
          currentInfoWindow = openrennes;
        });



        marker1.setMap(map);
        marker2.setMap(map);
        marker3.setMap(map);
        marker4.setMap(map);
        marker5.setMap(map);
        markeropren.setMap(map);
        markerbruz.setMap(map);

        //Géolocalisaiton
        var infoWindow = new google.maps.InfoWindow({map: map});
        if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function(position) {
           var pos = {
             lat: position.coords.latitude,
             lng: position.coords.longitude
           };

           infoWindow.setPosition(pos);
           infoWindow.setContent('Votre position.');
           map.setCenter(opren);
         }, function() {
           handleLocationError(true, infoWindow, map.getCenter());
         });
       } else {
         // Browser doesn't support Geolocation
         handleLocationError(false, infoWindow, map.getCenter());
       }



     function handleLocationError(browserHasGeolocation, infoWindow, pos) {
       infoWindow.setPosition(pos);
       infoWindow.setContent(browserHasGeolocation ?
                             'Erreur: La Géolocalisation a échoué.' :
                             'Erreur: Votre navigateur ne supporte pas la Géolocalisation.');
     }


      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDX0jhtt25zvHzjPoeJTtM--NNPUH41nWY&callback=initMap">
    </script>
