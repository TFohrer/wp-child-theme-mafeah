<?php

class My_Elementor_Widgets
{
    protected static $instance = null;

    const ELEMENTOR_WIDGET_BLACKLIST = [
        // pro ----------------- //
        'posts',
        'portfolio',
        'slides',
        'form',
        'login',
        'media-carousel',
        'testimonial-carousel',
        'nav-menu',
        'pricing',
        'facebook-comment',
        'nav-menu',
        'animated-headline',
        'price-list',
        'price-table',
        'facebook-button',
        'facebook-comments',
        'facebook-embed',
        'facebook-page',
        'add-to-cart',
        'categories',
        'elements',
        'products',
        'flip-box',
        'carousel',
        'countdown',
        'share-buttons',
        'author-box',
        'breadcrumbs',
        'search-form',
        'post-navigation',
        'post-comments',
        'theme-elements',
        'blockquote',
        'template',
        'wp-widget-audio',
        'woocommerce',
        'social',
        'library',

        // wp widgets ----------------- //
        'wp-widget-pages',
        'wp-widget-calendar',
        'wp-widget-archives',
        'wp-widget-media_audio',
        'wp-widget-media_image',
        'wp-widget-media_gallery',
        'wp-widget-media_video',
        'wp-widget-meta',
        'wp-widget-search',
        'wp-widget-text',
        'wp-widget-categories',
        'wp-widget-recent-posts',
        'wp-widget-recent-comments',
        'wp-widget-rss',
        'wp-widget-tag_cloud',
        'wp-widget-nav_menu',
        'wp-widget-custom_html',
        'wp-widget-eltd_instagram_widget',
        'wp-widget-eltd_twitter_widget',
        'wp-widget-rev-slider-widget',
        'wp-widget-wdi_instagram_widget',
        'wp-widget-wmc_widget',
        'wp-widget-wmc_widget_rates',
        'wp-widget-woocommerce_widget_cart',
        'wp-widget-woocommerce_layered_nav_filters',
        'wp-widget-woocommerce_layered_nav',
        'wp-widget-woocommerce_price_filter',
        'wp-widget-woocommerce_product_categories',
        'wp-widget-woocommerce_product_search',
        'wp-widget-woocommerce_product_tag_cloud',
        'wp-widget-woocommerce_products',
        'wp-widget-woocommerce_recently_viewed_products',
        'wp-widget-woocommerce_top_rated_products',
        'wp-widget-woocommerce_recent_reviews',
        'wp-widget-woocommerce_rating_filter',
        'wp-widget-eltd_full_screen_menu_opener',
        'wp-widget-eltd_latest_posts_widget',
        'wp-widget-eltd_search_opener',
        'wp-widget-eltd_side_area_opener',
        'wp-widget-eltd_sticky_sidebar',
        'wp-widget-eltd_social_icon_widget',
        'wp-widget-eltd_separator_widget',
        'wp-widget-eltd_woocommerce_dropdown_cart',
    ];

    protected $elementor;

    public static function get_instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->elementor = Elementor\Plugin::instance();

        $this->include_widgets_files();
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        add_action('elementor/widgets/widgets_registered', [$this, 'remove_widgets'], 200);
    }

    private function include_widgets_files()
    {
        //require_once 'widgets/image-overlay.php';
        //require_once 'widgets/posts-carousel.php';
        require_once 'widgets/testimonials-carousel.php';
        require_once 'widgets/product-list.php';
        require_once 'widgets/contact-form.php';
        require_once 'widgets/button.php';
        require_once 'widgets/product-carousel.php';
    }

    public function register_widgets()
    {
        //$this->elementor->widgets_manager->register_widget_type(new \Elementor\Image_Overlay_Widget());
        //$this->elementor->widgets_manager->register_widget_type(new \Elementor\Posts_Carousel_Widget());
        $this->elementor->widgets_manager->register_widget_type(new \Elementor\Testimonials_Carousel_Widget());
        $this->elementor->widgets_manager->register_widget_type(new \Elementor\Product_List_Widget());
        $this->elementor->widgets_manager->register_widget_type(new \Elementor\Contact_Form_Widget());
        $this->elementor->widgets_manager->register_widget_type(new \Elementor\Button_Widget());
        $this->elementor->widgets_manager->register_widget_type(new \Elementor\Product_Carousel_Widget());
    }

    public function remove_widgets()
    {
        $elementor = Elementor\Plugin::instance();
        foreach (self::ELEMENTOR_WIDGET_BLACKLIST as $widget_name) {
            $elementor->widgets_manager->unregister_widget_type($widget_name);
        }
    }
}

add_action('init', 'my_elementor_init');

function my_elementor_init()
{
    My_Elementor_Widgets::get_instance();
}
