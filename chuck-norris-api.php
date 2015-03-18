<?php
/**
 * Plugin Name: Chuck Norris Jokes
 * Description: Love Chuck Norris jokes? This plugin is for you!
 * Author: Nikhil Vimal
 * Author URI: http://nik.techvoltz.com
 * Version: 1.0
 * Plugin URI: https://github.com/NikV/chuck-norris-plugin
 * License: GNU GPLv2+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//Chuck Norris has the best PHP Class around.
Class Chuck_Norris_Jokes {

	//Constructing the greatest WordPress plugin of all time
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'chuck_norris_dashboard_widget' ));
		add_shortcode('chuck-norris-jokes', array( $this, 'chuck_norris_shortcode' ));

	}

	/**
	 * The main Chuck Norris Function
	 */ 
	public function chuck_norris_function() {
		if (! $joke = get_transient('chuck_norris') ) {

			// If there's no cached version, let's get a joke
			$jsonurl     = "http://api.icndb.com/jokes/random?limitTo=[nerdy]";
			$json        = wp_remote_get( $jsonurl );

			if ( is_wp_error( $json ) ) {
				return "Chuck Norris accidentally kicked the server, it will be up soon!";
			}

			else {
				// If everything's okay, parse the body and json_decode it
				$json_output = json_decode( wp_remote_retrieve_body( $json ));
				$joke = $json_output->value->joke;

				// Store the result in a transient, expires after 1 day
				// Also store it as the last successful using update_option
				if ($json_output->type = "success") {

					set_transient( 'chuck_norris', $joke, 60 * 1 );
				}
			}
		}
			echo esc_html($joke);
			echo '<p><strong>Refresh Page for another great Chuck Norris Joke</strong></p>';

	}

	// The shortcode function for [chuck-norris-jokes]
	public function chuck_norris_shortcode() {
		return $this->chuck_norris_function();
	}

	/**
	 * Add dashboard widget. A Chuck Norris Dashboard Widget
	 */
	public function chuck_norris_dashboard_widget() {

		wp_add_dashboard_widget(
			'chuck_norris_dashboard_widget',         // Widget slug.
			'Chuck Norris Jokes',         // Champion Title.
			array( $this, 'roundhouse_widget_function' ) // Roundhouse kick that function to another line.
		);
	}
	
	/**
	 * Callback for dashboard widget
	 */ 
	public function roundhouse_widget_function() {
		return $this->chuck_norris_function();
	}

} //The end? It's only the beginning...
new Chuck_Norris_Jokes();
