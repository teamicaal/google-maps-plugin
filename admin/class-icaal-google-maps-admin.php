<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.icaal.co.uk
 * @since      1.0.0
 *
 * @package    Icaal_Google_Maps
 * @subpackage Icaal_Google_Maps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Icaal_Google_Maps
 * @subpackage Icaal_Google_Maps/admin
 * @author     ICAAL <info@icaal.co.uk>
 */
class Icaal_Google_Maps_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/icaal-google-maps-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/icaal-google-maps-admin.js', array( 'jquery' ), $this->version, false );

	}

  public function register_global_settings() {

  	register_setting( $this->plugin_name, $this->plugin_name . '_google_api_key' );
  	register_setting( $this->plugin_name, $this->plugin_name . '_google_map_marker' );
  	register_setting( $this->plugin_name, $this->plugin_name . '_google_map_marker_start' );
  	register_setting( $this->plugin_name, $this->plugin_name . '_google_map_marker_end' );

  }

  public function global_settings_menu() {

  	add_submenu_page(
  		'options-general.php',
  		'Google Maps Settings',
  		'ICAAL Google Maps',
  		'manage_options',
  		'settings',
  		array( $this, 'global_settings_page' )
  	);

  }

  public function global_settings_page() {
  	?>
  	<div class="wrap">
	  	<h1>Google Maps Settings</h1>
			<div class="welcome-panel is-dismissible">
				<h3 style="margin-top:0">How to Get an API Key</h3>
				<p class="message">You can get an API Key buy following <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">this guide</a>. If you are using the directions map you will need to enable the Google Maps Directions API within the Google Developers Console.</p>
				<h3>Placing the Map Using Shortcodes</h3>
				<p class="message">You can embed the Google Map using a shortcode either in the standard WordPress editor or in the <a href="https://developer.wordpress.org/reference/functions/do_shortcode/" target="_blank">theme template file.</a></p>
				<table class="form-table">
					<tr>
						<th>Standard Map Shortcode</th>
						<td>
							<input type="text" class="regular-text" name="directions-map" value="<?php echo esc_attr('[icaal_google_map lat="50.9097525" lng="-1.4241363" address="Equity Court, 73-75 Millbrook Rd E, Southampton SO15 1RJ"]') ?>" readonly> 
						</td>
					</tr>
					<tr>
						<th>Directions Map Shortcode</th>
						<td>
							<input type="text" class="regular-text" name="directions-map" value="<?php echo esc_attr('[icaal_google_map type="directions" lat="50.9097525" lng="-1.4241363" address="Equity Court, 73-75 Millbrook Rd E, Southampton SO15 1RJ"]') ?>" readonly> 
						</td>
					</tr>
				</table>
			</div>
	  	<form method="post" action="<?php echo get_admin_url( '', 'options.php' ) ?>">
  			<?php settings_fields( $this->plugin_name ); ?>
  			<?php do_settings_sections( $this->plugin_name ); ?>
  			<table class="form-table">
  				<tr>
  					<th>Google API Key</th>
  					<td>
	  					<input type="text" class="regular-text" name="<?php echo $this->plugin_name . '_google_api_key' ?>" value="<?php echo esc_attr( get_option($this->plugin_name . '_google_api_key') ); ?>">
	  				</td>
  				</tr>
  				<tr>
  					<th>Map Marker URL</th>
  					<td>
	  					<input type="text" class="regular-text" name="<?php echo $this->plugin_name . '_google_map_marker' ?>" value="<?php echo esc_attr( get_option($this->plugin_name . '_google_map_marker') ); ?>">
  					</td>
  				</tr>
  				<tr>
  					<th>Map Marker Start URL</th>
  					<td>
	  					<input type="text" class="regular-text" name="<?php echo $this->plugin_name . '_google_map_marker_start' ?>" value="<?php echo esc_attr( get_option($this->plugin_name . '_google_map_marker_start') ); ?>">
  					</td>
  				</tr>
  				<tr>
  					<th>Map Marker End URL</th>
  					<td>
	  					<input type="text" class="regular-text" name="<?php echo $this->plugin_name . '_google_map_marker_end' ?>" value="<?php echo esc_attr( get_option($this->plugin_name . '_google_map_marker_end') ); ?>">
  					</td>
  				</tr>
  			</table>
  			<?php submit_button(); ?>
		  </form>
	  </div>
  	<?php
  }

}
