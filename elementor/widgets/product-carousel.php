<?php
namespace Elementor;

use Elementor\Widget_Base as Widget_Base;
use Elementor\Controls_Manager as Controls_Manager;

class Product_Carousel_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'mafeah-product-carousel';
    }

    public function get_title()
    {
        return 'Product Carousel';
    }

    public function get_icon()
    {
        return 'eicon-carousel';
    }

    public function get_categories()
    {
        return ['mafeah'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section('section_title', [
            'label' => __('Content', 'elementor'),
        ]);

        $this->add_control('products_per_page', [
            'label' => __('Products per Page', 'mafeah'),
            'type' => Controls_Manager::NUMBER,
        ]);

        $this->add_control('items_to_show', [
            'label' => esc_html__('Items to show', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '3' => esc_html__('3', 'mafeah'),
                '4' => esc_html__('4', 'mafeah'),
                '5' => esc_html__('5', 'mafeah'),
            ],
        ]);

        $this->add_control('order_by', [
            'label' => esc_html__('Oder by', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'date' => esc_html__('Date', 'mafeah'),
                'author' => esc_html__('Author', 'mafeah'),
                'title' => esc_html__('Title', 'mafeah'),
            ],
        ]);

        $this->add_control('order', [
            'label' => __('Product category', 'elementor'),
            'label_block' => true,
            'type' => Controls_Manager::SELECT,
            'options' => [
                'asc' => __('Asc', 'mafeah'),
                'desc' => __('Desc', 'mafeah'),
            ],
        ]);

        $this->add_control('category', [
            'label' => __('Product category', 'elementor'),
            'label_block' => true,
            'type' => Controls_Manager::SELECT,
            'options' => $this->build_categories_options(),
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = [
            'products_per_page' => '-1',
            'order_by' => '',
            'order' => '',
            'category' => '',
            'items_to_show' => '',
        ];

        $params = shortcode_atts($args, $settings);
        extract($params);

        $query = $this->get_products($params);

        $html = '';

        if ($query->have_posts()) {
            $html .=
                '<div class="eltd-product-carousel-holder eltd-woocommerce woocommerce clearfix" data-items-to-show="' .
                esc_attr($items_to_show) .
                ' ">';
            $html .= '<div class = "eltd-product-carousel">';
            while ($query->have_posts()) {
                $query->the_post();
                $params['product_carousel_image'] = $this->getProductCarouselImage(get_the_ID());

                $html .= creator_elated_get_shortcode_module_template_part(
                    'templates/product-carousel-template',
                    'product-carousel',
                    '',
                    $params
                );
            }
            $html .= '</div>';
            $html .= '</div>';
        } else {
            $html .= esc_html__('No products found', 'creator');
        }
        echo $html;
    }

    protected function _content_template()
    {
    }

    // init product carousel manually in preview mode
    private function previewJS()
    {
        $response = '';

        if (Plugin::$instance->editor->is_edit_mode()) {
            $response .= '<script>eltd.modules.shortcodes.eltdInitProductCarousel();</script>';
        }
        return $response;
    }

    private function getProductCarouselImage($id)
    {
        $image_url = get_post_meta($id, 'eltd_image_product_carousel_meta', true);
        if (!$image_url || $image_url === '') {
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full')[0];
        }
        return $image_url;
    }

    private function build_categories_options()
    {
        $options[''] = 'All';

        $categories = get_terms('product_cat', $args);

        /** @var WP_TERM $category */
        foreach ($categories as $category) {
            $options[$category->slug] = $category->name;
        }

        return $options;
    }

    private function get_products($params)
    {
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $params['products_per_page'],
            'order_by' => $params['order_by'],
            'order' => $params['order'],
            'ignore_sticky_posts' => true,
        ];

        if (!empty($params['category'])) {
            $args['product_cat'] = $params['category'];
        }

        return new \WP_Query($args);
    }
}
