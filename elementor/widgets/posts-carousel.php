<?php
namespace Elementor;

class Posts_Carousel_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'mafeah-posts-carousel';
    }

    public function get_title()
    {
        return 'Posts Carousel';
    }

    public function get_icon()
    {
        return 'icon-wpb-blog-list-carousel extended-custom-icon';
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

        $this->add_control('number_of_posts', [
            'label' => __('Number of Posts', 'elementor'),
            'label_block' => true,
            'type' => Controls_Manager::TEXT,
            'placeholder' => __('Leave empty to show all blog posts', 'elementor'),
        ]);

        $this->add_control('number_of_columns', [
            'label' => __('Number of Columns', 'elementor'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '2' => __('Two', 'creator'),
                '3' => __('Three', 'creator'),
                '4' => __('Four', 'creator'),
            ],
            'default' => '2',
        ]);

        $this->add_control('order_by', [
            'label' => __('Order By', 'elementor'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'title' => __('Title', 'creator'),
                'date' => __('Date', 'creator'),
                'ID' => __('ID', 'creator'),
            ],
            'default' => 'date',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $html = '';
        $settings = $this->get_settings_for_display();

        $default_atts = [
            'number_of_posts' => '-1',
            'number_of_columns' => 4,
            'order_by' => '',
            'order' => '',
            'category' => '',
            'selected_posts' => '',
            'enable_pagination' => '',
            'text_length' => '90',
        ];

        $params = shortcode_atts($default_atts, $settings);
        $posts = $this->get_posts($params);

        if ($posts->have_posts()) {
            $html .= '<p>POSTS</p>';
        } else {
            $html .= '<p>' . __('Sorry, no posts matched your criteria.', 'creator') . '</p>';
        }

        echo $html;
        //echo "<a href='$url'><div class='title'>$settings[title]</div> <div class='subtitle'>$settings[subtitle]</div></a>";
    }

    protected function _content_template()
    {
    }

    private function get_posts($params)
    {
        $queryArray = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => $params['order_by'],
            'order' => $params['order'],
            'posts_per_page' => $params['number_of_posts'],
            'category_name' => $params['category'],
        ];

        return new \WP_Query($queryArray);
    }
}
