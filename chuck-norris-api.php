<?php
/**
 * Plugin Name: Chuck Norris Jokes
 * Description: Love Chuck Norris? Like Nerdy jokes? This plugin is for you!
 * Author: Nikhil Vimal
 * Author URI: http://nik.techvoltz.com
 * Version: 1.0
 * Plugin URI:
 * License: GNU GPLv2+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//Chuck Norris has the best PHP Class around.
Class Chuck_Norris_Jokes {

	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'chuck_norris_dashboard_widget' ));
		add_shortcode('chuck-norris-jokes', array( $this, 'chuck_norris_shortcode' ));

	}

	public function chuck_norris_shortcode() {
		$jsonurl = "http://api.icndb.com/jokes/random?limitTo=[nerdy]";
		$json = file_get_contents($jsonurl);
		$json_output = json_decode($json);
		echo $json_output->value->joke;

		return '<p><strong>Refresh Page for another great Chuck Norris Joke</strong></p>';

	}

	/**
	 * Add a widget to the dashboard.
	 *
	 * This function is hooked into the 'wp_dashboard_setup' action below.
	 */
	public function chuck_norris_dashboard_widget() {

		wp_add_dashboard_widget(
			'chuck_norris_dashboard_widget',         // Widget slug.
			'Chuck Norris Jokes',         // Champion Title.
			array( $this, 'roundhouse_widget_function' ) // Roundhouse kick that function to another line.
		);
	}


	public function roundhouse_widget_function() {

		$jsonurl = "http://api.icndb.com/jokes/random?limitTo=[nerdy]";
		$json = file_get_contents($jsonurl);
		$json_output = json_decode($json);
		echo $json_output->value->joke;

		echo '<p><strong>Refresh Page for another great Chuck Norris Joke</strong></p>';
	}
}
new Chuck_Norris_Jokes();