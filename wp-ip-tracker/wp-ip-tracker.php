<?php
/**
 * Plugin Name: WP IP Tracker
 * Description: Special development for Jitu Chaudhary.
 * Version: 150831
 * Author: reedyseth
 * Author URI: http://datasoftengineering.com
 * Version: 150831
 * Stable tag: 150831
 * Tested up to: 4.2.2
 * License: GPL2
 */

// Avoid direct acces to the plugin
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

class wp_ip_traker {
	private $server_url = 'http://localhost/web/SOPORTE/012-Jitender-WPIP/track.php';

	function __construct() {
		// init functions for regular user
		// init functions for admin
		if( is_admin() ) {
			add_action( 'init', array( $this, 'wp_ip_init'));
			add_action( 'admin_menu', array( $this, 'wp_ip_admin_menu'));
		}
	}

	public function wp_ip_init() {

	}

	public function wp_ip_admin_menu() {
		add_menu_page( 'WP IP Tracker Settings', 'WP IP Tracker','administrator', 'wp_ip_manage_options', array( $this, 'wp_ip_manage_options'),'dashicons-location-alt' );
	}


	public function wp_ip_manage_options() {
		$page = <<< HTML
			<h1>WP IP Tracker Settings by Reedyseth.</h1>

			<p>This is your curren IP: {$this->wp_ip_get_realip()} </p>
			<p>This the Curl response: {$this->wp_ip_send_curl()} </p>
HTML;

	echo $page;
	}

	function wp_ip_get_realip() {
		$ip = '0.0.0.0';
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		  //check ip from share internet
		  $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		  //to check ip is pass from proxy
		  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		  $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function wp_ip_send_curl() {

		$data = array(
			'ip' => $this->wp_ip_get_realip(),
			'time' =>
		);

		$curl = curl_init();
		// Set URL
		curl_setopt( $curl, CURLOPT_URL, $this->server_url );
		// Set the number of parameters
		curl_setopt( $curl, CURLOPT_POST, 1 );
		// Send the parameters
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array( 'blog_name' => get_bloginfo( 'name' ) ) );
		// return the transfer as a string
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec( $curl );
		// Close curl resource to free up system resources
		curl_close( $curl );
		return $output;
	}
}

$wp_ip = new wp_ip_traker();