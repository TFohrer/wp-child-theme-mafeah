<?php
namespace Elementor;

class Testimonials_Carousel_Widget extends Widget_Base
{
    const TESTIMONIALS_TAXONOMY = 'testimonials_category';

    public function get_name()
    {
        return 'mafeah-testimonials-carousel';
    }

    public function get_title()
    {
        return 'Testimonials Carousel';
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

        $this->add_control('category', [
            'label' => __('Testimonial category', 'elementor'),
            'label_block' => true,
            'type' => Controls_Manager::SELECT,
            'options' => $this->build_categories_options(),
        ]);

        $this->add_control('number', [
            'label' => __('Number of Testimonials', 'elementor'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __('Number of Testimonials', 'elementor'),
        ]);

        $this->add_control('skin', [
            'label' => __('Skin', 'elementor'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'light' => __('Light', 'creator'),
                'dark' => __('Dark', 'creator'),
            ],
        ]);

        $this->add_control('carousel_items', [
            'label' => __('Carousel Items', 'elementor'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ],
        ]);

        $this->add_control('navigation', [
            'label' => __('Navigation', 'elementor'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'no' => __('No', 'creator'),
                'yes' => __('Yes', 'creator'),
            ],
        ]);

        $this->add_control('autoplay_speed', [
            'label' => __('Autoplay speed', 'elementor'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __('Autoplay speed (ms)', 'elementor'),
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $html = '';
        $settings = $this->get_settings_for_display();

        $args = [
            'number' => '-1',
            'category' => '',
            'type' => 'with_icon',
            'skin' => '',
            'carousel_items' => '2',
            'two_rows' => 'no',
            'navigation' => 'no',
            'pagination' => 'no',
            'autoplay_speed' => '',
        ];

        $params = shortcode_atts($args, $settings);
        $posts = $this->get_testimonials($params);
        $data_attr = $this->getDataParams($params);

        $html = '';

        if ($posts->have_posts()) {
            $html .= '<div class="eltd-testimonials-holder clearfix">';
            $html .=
                '<div class="eltd-testimonials eltd-standard' .
                ' ' .
                $params['skin'] .
                '" ' .
                creator_elated_get_inline_attrs($data_attr) .
                '>';

            while ($posts->have_posts()) {
                $posts->the_post();

                $params['current_id'] = get_the_ID();
                $params['title'] = get_post_meta(get_the_ID(), 'eltd_testimonial_title', true);
                $params['text'] = get_post_meta(get_the_ID(), 'eltd_testimonial_text', true);
                $params['author'] = get_post_meta(get_the_ID(), 'eltd_testimonial_author', true);
                $params['position'] = get_post_meta(get_the_ID(), 'eltd_testimonial_author_position', true);
                $params['social_network_objects'] = $this->getTestimonialSocialNetworks(get_the_ID());

                if (has_post_thumbnail()) {
                    $params['image'] = get_the_post_thumbnail(null, [70, 70]);
                } else {
                    $params['image'] = false;
                }

                if ($params['two_rows'] == 'yes' && $posts->current_post % 2 == 0) {
                    $html .= '<div class="eltd-testimonial-items-holder">';
                }

                $html .= eltd_core_get_shortcode_module_template_part(
                    'testimonials',
                    'testimonials-standard',
                    '',
                    $params
                );

                if ($params['two_rows'] == 'yes' && $posts->current_post % 2 !== 0) {
                    $html .= '</div>';
                }
            }

            $html .= '</div>';
            $html .= '</div>';
        } else {
            $html .= '<p>' . __('Sorry, no posts matched your criteria.', 'creator') . '</p>';
        }

        echo $html;
    }

    protected function _content_template()
    {
    }

    private function getTestimonialSocialNetworks($id)
    {
        $social_icons = [];
        $social_networks_array = ['vimeo', 'instagram', 'twitter', 'facebook'];
        foreach ($social_networks_array as $network) {
            $link = get_post_meta($id, 'eltd_testimonial_author_' . $network . '_url', true);

            $icon_params = [];
            $icon_params['icon_pack'] = 'font_elegant';
            $icon_params['fe_icon'] = 'social_' . $network;
            $icon_params['link'] = $link;
            $icon_params['type'] = 'square';

            $social_icons[] = creator_elated_execute_shortcode('eltd_icon', $icon_params);
        }

        return $social_icons;
    }

    /**
     * Generates testimonial data attribute array
     *
     * @param $params
     *
     * @return array
     */
    private function getDataParams($params)
    {
        $data_attr = [];

        if ($params['carousel_items'] !== '') {
            $data_attr['data-items'] = $params['carousel_items'];
        }
        if ($params['autoplay_speed'] !== '') {
            $data_attr['data-autoplay-speed'] = $params['autoplay_speed'];
        }
        if ($params['navigation'] !== '') {
            $data_attr['data-navigation'] = $params['navigation'];
        }
        if ($params['pagination'] !== '') {
            $data_attr['data-pagination'] = $params['pagination'];
        }

        return $data_attr;
    }

    private function build_categories_options()
    {
        $options[''] = 'All';

        $categories = $this->get_testimonials_categories();
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
    private function get_testimonials($params)
    {
        $queryArray = [
            'post_type' => 'testimonials',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $params['number'],
        ];

        if ($params['category'] != '') {
            $args['testimonials_category'] = $params['category'];
        }

        return new \WP_Query($queryArray);
    }
}
