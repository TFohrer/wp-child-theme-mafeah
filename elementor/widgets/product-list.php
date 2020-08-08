<?php
namespace Elementor;

use Elementor\Widget_Base as Widget_Base;
use Elementor\Controls_Manager as Controls_Manager;

class Product_List_Widget extends Widget_Base
{
    const TESTIMONIALS_TAXONOMY = 'testimonials_category';

    public function get_name()
    {
        return 'mafeah-product-list';
    }

    public function get_title()
    {
        return 'Product List';
    }

    public function get_icon()
    {
        return 'fa fa-list';
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

        $this->add_control('type', [
            'label' => __('Type', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'type1' => __('Type 1', 'creator'),
                'type2' => __('Type 2', 'creator'),
            ],
        ]);

        $this->add_control('column_number', [
            'label' => esc_html__('Columns', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                '2' => esc_html__('2', 'mafeah'),
                '3' => esc_html__('3', 'mafeah'),
                '4' => esc_html__('4', 'mafeah'),
                '5' => esc_html__('5', 'mafeah'),
                '6' => esc_html__('6', 'mafeah'),
            ],
        ]);

        $this->add_control('category', [
            'label' => __('Product category', 'elementor'),
            'label_block' => true,
            'type' => Controls_Manager::SELECT,
            'options' => $this->build_categories_options(),
        ]);

        $this->add_control('limit', [
            'label' => __('Limit Number of Products', 'mafeah'),
            'description' => __('Leave empty to show all products', 'mafeah'),
            'type' => Controls_Manager::TEXT,
        ]);

        $this->add_control('enable_filter', [
            'type' => Controls_Manager::SWITCHER,
            'label' => __('Show Filter', 'mafeah'),
            'default' => '',
            'return_value' => 'yes',
            'description' => __('Check to show filter options on top of the product list.', 'mafeah'),
        ]);

        $this->add_control('skin', [
            'label' => __('Skin', 'elementor'),
            'label_block' => true,
            'type' => Controls_Manager::SELECT,
            'options' => [
                'light' => __('Light', 'creator'),
                'dark' => __('Dark', 'creator'),
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $html = '';
        $settings = $this->get_settings_for_display();

        $args = [
            'type' => 'type1',
            'limit' => '-1',
            'column_number' => '4',
            'enable_filter' => '',
            'order_by' => '',
            'order' => '',
            'category' => '',
        ];

        $params = shortcode_atts($args, $settings);
        extract($params);

        $products = $this->get_products($settings);

        $classes = $this->getHolderClasses($params);
        $filter_params['filter_categories'] = $this->getFilterCategories($params);
        $inner_classes = $this->getHolderInnerClasses($params);

        $html = '<div class="eltd-product-list-holder woocommerce ' . esc_attr($classes) . '">';

        if ($enable_filter == 'yes') {
            $html .= creator_elated_get_shortcode_module_template_part(
                'templates/product-list-filter',
                'product-list',
                '',
                $filter_params
            );
        }

        if ($products->have_posts()) {
            $html .= '<ul class="eltd-product-list-items products clearfix ' . $inner_classes . ' ">';

            while ($products->have_posts()) {
                $products->the_post();
                $params['product'] = creator_elated_woocommerce_global_product();

                $html .= creator_elated_get_shortcode_module_template_part(
                    'templates/' . $params['type'],
                    'product-list',
                    '',
                    $params
                );
            }
            wp_reset_postdata();
            $html .= '</ul>';
        } else {
            $html .= esc_html__('No products found', 'creator');
        }
        $html .= '</div>'; //close eltd-product-list-holder

        echo $html;
    }

    protected function _content_template()
    {
    }

    function getHolderInnerClasses($params)
    {
        $class = 'eltd-type-1';

        if (isset($params['type'])) {
            if ($params['type'] === 'type2') {
                $class = 'eltd-type-2';
            }
        }

        return $class;
    }

    /**
     * Generate Column Number css class
     *
     * @param $params
     * @return string
     */
    private function getHolderClasses($params)
    {
        $class = [];

        if (!empty($params['column_number'])) {
            $class[] = 'columns-' . $params['column_number'];
        }

        if (!empty($params['enable_filter']) && $params['enable_filter'] == 'yes') {
            $class[] = 'eltd-product-list-with-filter';
        }

        return implode(' ', $class);
    }

    private function build_categories_options()
    {
        $options[''] = 'All';

        $categories = get_terms('product_cat', $args);

        //$categories = $this->get_testimonials_categories();
        /** @var WP_TERM $category */
        foreach ($categories as $category) {
            $options[$category->slug] = $category->name;
        }

        return $options;
    }

    private function get_testimonials_categories()
    {
        return get_categories(['taxonomy' => self::TESTIMONIALS_TAXONOMY]);
    }

    private function get_products($params)
    {
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $params['limit'],
            'order_by' => $params['order_by'],
            'order' => $params['order'],
            'ignore_sticky_posts' => true,
        ];

        if (!empty($params['category'])) {
            $args['product_cat'] = $params['category'];
        }

        return new \WP_Query($args);
    }

    public function getFilterCategories($params)
    {
        $cat_id = 0;
        $top_category = '';

        if (!empty($params['category'])) {
            $top_category = get_term_by('slug', $params['category'], 'product_cat');
            if (isset($top_category->term_id)) {
                $cat_id = $top_category->term_id;
            }
        }

        $args = [
            'child_of' => $cat_id,
        ];

        $filter_categories = get_terms('product_cat', $args);

        return $filter_categories;
    }
}
