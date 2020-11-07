<?php 

// Instancia a classe
use application\modulos\maps\gMaps;

include 'application/modulos/maps/gMaps.php';

$gmaps = new gMaps('AIzaSyDfkJ34QvoQ-1kabQWWdEMGXEGMjEm5JOE');

// Pega os dados (latitude, longitude e zoom) do endereço:
$endereco = 'Av. Brasil, 1453, Rio de Janeiro, RJ';
$dados = $gmaps->geoLocal($endereco);

// Exibe os dados encontrados:
print_r($dados);

?>
<script>
function initialize() {
	   var mapOptions = {
	      center: new google.maps.LatLng(40.680898,-8.684059),
	      zoom: 11,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	   };
	   var map = new google.maps.Map(document.getElementById("map-canvas"),
	 mapOptions);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
function searchAddress() {

	  var addressInput = document.getElementById('address-input').value;

	  var geocoder = new google.maps.Geocoder();

	  geocoder.geocode({address: addressInput}, function(results, status) {

	    if (status == google.maps.GeocoderStatus.OK) {

	      var myResult = results[0].geometry.location; // referência ao valor LatLng

	      createMarker(myResult); // adicionar chamada à função que adiciona o marcador

	      map.setCenter(myResult);

	      map.setZoom(17);

	    }
	  });
	}


function createMarker(latlng) {

   // Se o utilizador efetuar outra pesquisa é necessário limpar a variável marker
   if(marker != undefined && marker != ''){
    marker.setMap(null);
    marker = '';
   }

   marker = new google.maps.Marker({
      map: map,
      position: latlng
   });

}

if (status == google.maps.GeocoderStatus.OK) {

    var myResult = results[0].geometry.location; // referência ao valor LatLng

    createMarker(myResult); // adicionar chamada à função que adiciona o marcador

    map.setCenter(myResult);

    map.setZoom(17);

  } else { // se o valor de status é diferente de "google.maps.GeocoderStatus.OK"

    // mensagem de erro
    alert("O Geocode não foi bem sucedido pela seguinte razão: " + status);

  }
</script>

    <div style="margin-top:50px;">
       Indique um endereço <input type="text" id="address-input">
       <button onclick="searchAddress();">Pesquisar</button>
    </div> 
 <div id="map-canvas"></div>