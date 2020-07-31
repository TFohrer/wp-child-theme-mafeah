<?php

class My_Elementor_Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
        $this->include_widgets_files();
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
    }
    
    private function include_widgets_files(){
        require_once('widgets/image-overlay.php');
    }

	public function register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Image_Overlay_Widget() );
	}

}

add_action( 'init', 'my_elementor_init' );
function my_elementor_init() {
	My_Elementor_Widgets::get_instance();
}