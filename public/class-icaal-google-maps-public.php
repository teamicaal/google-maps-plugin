<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.icaal.co.uk
 * @since      1.0.0
 *
 * @package    Icaal_Google_Maps
 * @subpackage Icaal_Google_Maps/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Icaal_Google_Maps
 * @subpackage Icaal_Google_Maps/public
 * @author     ICAAL <info@icaal.co.uk>
 */
class Icaal_Google_Maps_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Icaal_Google_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Icaal_Google_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/icaal-google-maps-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Icaal_Google_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Icaal_Google_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/icaal-google-maps-public.js', array( 'jquery' ), $this->version, false );

	}

	public function register_shortcodes() {
		function icaal_google_map_shortcode( $atts ) {

			$api_key = get_option('icaal-google-maps_google_api_key');
			wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&callback=initMap', '', '', true );

			$id = wp_rand();

			extract(shortcode_atts(
				array(
					'type' => 'standard',
					'lat' => '50.9097525',
					'lng' => '-1.4241363',
					'address' => 'Equity Court, 73-75 Millbrook Rd E, Southampton SO15 1RJ',
					'zoom' => 14,
					'title' => 'Enter Your Address To Get Directions!'
				),
				$atts )
			);

			ob_start();
			include plugin_dir_path( __FILE__ ) . 'partials/icaal-google-maps-' . $type . '.php';
			$content = ob_get_contents();
			ob_end_clean();
			return $content;

		}
		add_shortcode( 'icaal_google_map', 'icaal_google_map_shortcode' );
	}

	public function icaal_google_maps_directions() {

    $api_key = get_option('icaal-google-maps_google_api_key');

    if( check_ajax_referer( 'icaal_google_maps', '_wpnonce' ) ) {

      $origin_address = $_POST['origin'];
      $destination_address = $_POST['destination'];
      $destination_lat = $_POST['destination_lat'];
      $destination_lng = $_POST['destination_lng'];

      $args = http_build_query(
        array(
          'key' => $api_key,
          'origin' => $origin_address,
          'destination' => $destination_lat . ',' . $destination_lng,
          'language' => 'en-GB',
          'units' => 'imperial'
        )
      );
      $url = 'https://maps.googleapis.com/maps/api/directions/json?' . $args;
      $args = array( 'timeout' => 120 );
      $data_feed = wp_remote_get( $url, $args );
      $data = json_decode( $data_feed['body'], true );

      wp_send_json_success($data);

    } else {

    	wp_send_json_error('Could Not Complete Your Request at This Time');

    }

	}

}
