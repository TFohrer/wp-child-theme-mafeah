<?php

/*** Child Theme Function  ***/
if ( ! function_exists( 'creator_elated_child_theme_enqueue_scripts' ) ) {
	function creator_elated_child_theme_enqueue_scripts()
	{
		$parent_style = 'creator-elated-default-style';

		wp_enqueue_style('creator-elated-handle-child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style));
	}

	add_action('wp_enqueue_scripts', 'creator_elated_child_theme_enqueue_scripts');
}

//include_once 'elements/image-overlay.php';

require_once('elementor/categories.php');
require_once('elementor/widgets.php');