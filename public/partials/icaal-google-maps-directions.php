<div class="directions-map-container">
  <div id="map-<?php echo $id ?>" class="map-container">
  </div>
  <div class="directions-map-panel">
    <div class="directions-map-panel-inner">
      <form id="directions-map-form-<?php echo $id ?>" class="directions-map-form" method="post" action="<?php echo admin_url('admin-ajax.php') ?>">
        <?php wp_nonce_field('icaal_google_maps'); ?>
        <input type="hidden" name="action" value="icaal_google_maps_directions">
        <input type="hidden" name="destination" value="<?php echo $address ?>">
        <input type="hidden" name="destination_lat" value="<?php echo $lat ?>">
        <input type="hidden" name="destination_lng" value="<?php echo $lng ?>">
        <h3 class="directions-map-title"><?php echo $title ?></h3>
        <input type="text" class="directions-map-input form-control" name="origin" placeholder="Enter Address">
        <div class="response"></div>
        <input type="submit" class="directions-map-submit btn btn-primary" value="Get Directions">
      </form>
      <div class="directions-map-results">
        <div class="directions-map-results__origin"></div>
        <div class="directions-map-results__info"></div>
        <div class="directions-map-results__steps"></div>
        <div class="directions-map-results__destination"></div>
      </div>
    </div>
  </div>
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
      map: map
    });

    infowindow = new google.maps.InfoWindow({
      content: '<?php echo esc_html($address) ?>'
    });

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });

  }

  jQuery(document).ready(function($) {

    function directionsError( message ) {

      $('#directions-map-form-<?php echo $id ?>').find('.response').html('<div class="alert alert-danger">' + message + '</div>');
      
    }

    $('#directions-map-form-<?php echo $id ?>').submit(function(e) {

      e.preventDefault();

      var origin = $(this).find('[name="origin"]').val(),
          url = $(this).attr('action'),
          data = $(this).serialize(),
          container = $(this).parents('.directions-map-container'),
          panel = $(container).find('.directions-map-panel'),
          results = $(panel).find('.directions-map-results');

      if( origin ) {

        $(this).find('.response').empty();

        $.post( url, data, function(response) {
          console.log(response);

          if( response.success === true ) {
            var route = response.data.routes[0],
                legs = route.legs[0],
                steps = legs.steps,
                start = legs.start_address,
                end = legs.end_address,
                distance = legs.distance,
                duration = legs.duration,
                prefix = '.directions-map-results__';

            $(panel).addClass('active');
            $(prefix + 'origin').text(start);
            $(prefix + 'destination').text(end);
            $(prefix + 'info').text(distance.text + '. ' + duration.text);
            for ( i = 0; i < steps.length; i++ ) {
              $(prefix + 'steps').append('<div class="step">' + steps[i].html_instructions + '</div>');
            }

          } else {
            directionsError(response.data);
          }
        });

      } else {
        directionsError('Please Enter Your Address');
      }

    });

  });

</script>