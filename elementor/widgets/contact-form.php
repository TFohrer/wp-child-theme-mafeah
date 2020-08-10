<?php
namespace Elementor;

use Elementor\Widget_Base as Widget_Base;
use Elementor\Controls_Manager as Controls_Manager;

class Contact_Form_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'mafeah-contact-form';
    }

    public function get_title()
    {
        return 'Contact Form (7)';
    }

    public function get_icon()
    {
        return 'fa fa-envelope-o';
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

        $this->add_control('contact_form_list', [
            'label' => __('Contact Form', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'label_block' => true,
            'options' => $this->get_contact_form_7_forms(),
            'default' => '0',
        ]);

        $this->add_control('html_class', [
            'label' => __('Style', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                'default' => __('Default', 'mafeah'),
                'cf7_custom_style_1' => __('Custom Style 1', 'mafeah'),
                'cf7_custom_style_2' => __('Custom Style 2', 'mafeah'),
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        echo do_shortcode(
            '[contact-form-7 id="' . $settings['contact_form_list'] . '" html_class="' . $settings['html_class'] . '" ]'
        );

        return;
    }

    protected function _content_template()
    {
    }

    private function get_contact_form_7_forms()
    {
        if (function_exists('wpcf7')) {
            $options = [];

            $args = [
                'post_type' => 'wpcf7_contact_form',
                'posts_per_page' => -1,
            ];

            $contact_forms = get_posts($args);

            if (!empty($contact_forms) && !is_wp_error($contact_forms)) {
                $options[0] = __('Select a Contact form', 'mafeah');

                foreach ($contact_forms as $post) {
                    $options[$post->ID] = $post->post_title;
                }
            }
        } else {
            $options = [];
        }

        return $options;
    }
}
