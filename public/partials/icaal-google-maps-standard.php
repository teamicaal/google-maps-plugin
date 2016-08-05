<?php

  $marker = get_option('icaal-google-maps_google_map_marker');

?>
<div id="map-<?php echo $id ?>" class="map-container">
</div>
<script type="text/javascript">

  function initMap() {
    var map,
        marker,
        infowindow,
        lat = <?php echo $lat ?>,
        lng = <?php echo $lng ?>,
        latlng = {lat: lat, lng: lng},
        address = '<?php echo $address ?>';

    map = new google.maps.Map(document.getElementById('map-<?php echo $id ?>'), {
      zoom: <?php echo $zoom ?>,
      center: latlng,
      scrollwheel: false
    });

    marker = new google.maps.Marker({
      position: latlng,
      icon: '<?php echo $marker ?>',
      map: map
    });

    infowindow = new google.maps.InfoWindow({
      content: '<?php echo esc_html($address) ?>'
    });

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });

  }
</script>