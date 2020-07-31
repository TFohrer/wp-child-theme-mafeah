<?php
/**
 * Adds new shortcode "myprefix_say_hello" and registers it to
 * the Visual Composer plugin
 *
 */

if ( ! class_exists( 'MyPrefix_Say_Hello_Shortcode' ) ) {

	class MyPrefix_Say_Hello_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			
			// Registers the shortcode in WordPress
			add_shortcode( 'myprefix_say_hello', array( 'MyPrefix_Say_Hello_Shortcode', 'output' ) );

			// Map shortcode to Visual Composer
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'myprefix_say_hello', array( 'MyPrefix_Say_Hello_Shortcode', 'map' ) );
			}

		}

		/**
		 * Shortcode output
		 *
		 * @since 1.0.0
		 */
		public static function output( $atts, $content = null ) {

			// Extract shortcode attributes (based on the vc_lean_map function - see next function)
			extract( vc_map_get_attributes( 'myprefix_say_hello', $atts ) );

			// Define output
			$output = '';

			// Output hello
			if ( 'yes' == $say_hello ) {
				$output = 'Hello';
			}

			// Return output
			return $output;

		}

		/**
		 * Map shortcode to VC
		 *
		 * This is an array of all your settings which become the shortcode attributes ($atts)
		 * for the output. See the link below for a description of all available parameters.
		 *
		 * @since 1.0.0
		 * @link  https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=38993922
		 */
		public static function map() {
			return array(
				'name'        => esc_html__( 'Say Hello', 'locale' ),
				'description' => esc_html__( 'Shortcode outputs Hello.', 'locale' ),
				'base'        => 'myprefix_say_hello',
				'params'      => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Say Hello', 'locale' ),
						'param_name' => 'say_hello',
						'value'      => array(
							esc_html__( 'No', 'locale' )  => 'no',
							esc_html__( 'Yes', 'locale' ) => 'yes',
						),
					),
				),
			);
		}

	}

}
new MyPrefix_Say_Hello_Shortcode;