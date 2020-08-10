<?php
namespace Elementor;

use Elementor\Widget_Base as Widget_Base;
use Elementor\Controls_Manager as Controls_Manager;

class Button_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'mafeah-button';
    }

    public function get_title()
    {
        return 'Button';
    }

    public function get_icon()
    {
        return 'eicon-button';
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

        $this->add_control('size', [
            'label' => __('Contact Form', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'label_block' => true,
            'options' => [
                '' => esc_html__('Default', 'mafeah'),
                'small' => esc_html__('Small', 'mafeah'),
                'medium' => esc_html__('Medium', 'mafeah'),
                'large' => esc_html__('Large', 'mafeah'),
                'huge' => esc_html__('Extra Large', 'mafeah'),
                'huge-full-width' => esc_html__('Extra Large Full Width', 'mafeah'),
            ],
        ]);

        $this->add_control('type', [
            'label' => __('Type', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'label_block' => true,
            'options' => [
                '' => esc_html__('Default', 'mafeah'),
                'outline' => esc_html__('Outline', 'mafeah'),
                'solid' => esc_html__('Solid', 'mafeah'),
                'transparent' => esc_html__('Transparent', 'mafeah'),
            ],
        ]);

        $this->add_control('text', [
            'label' => __('Text', 'mafeah'),
            'label_block' => true,
            'type' => Controls_Manager::TEXT,
        ]);

        $this->add_control('link', [
            'label' => __('Link', 'mafeah'),
            'label_block' => true,
            'type' => Controls_Manager::TEXT,
        ]);

        $this->add_control('target', [
            'label' => __('Target', 'mafeah'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '_self' => esc_html__('Self', 'mafeah'),
                '_blank' => esc_html__('Blank', 'mafeah'),
            ],
        ]);

        $this->add_control('custom_class', [
            'label' => __('Custom CSS class', 'mafeah'),
            'label_block' => true,
            'type' => Controls_Manager::TEXT,
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $default_atts = [
            'size' => '',
            'type' => '',
            'text' => '',
            'link' => '',
            'target' => '',
            'color' => '',
            'hover_color' => '',
            'background_color' => '',
            'hover_background_color' => '',
            'border_color' => '',
            'hover_border_color' => '',
            'font_size' => '',
            'font_weight' => '',
            'margin' => '',
            'custom_class' => '',
            'html_type' => 'anchor',
            'input_name' => '',
            'hover_animation' => '',
            'border_overlay_color' => '',
            'custom_attrs' => [],
        ];

        $default_atts = array_merge($default_atts, creator_elated_icon_collections()->getShortcodeParams());
        $params = shortcode_atts($default_atts, $settings);

        if ($params['html_type'] !== 'input') {
            $iconPackName = creator_elated_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
            $params['icon'] = $iconPackName ? $params[$iconPackName] : '';
        }

        $params['size'] = !empty($params['size']) ? $params['size'] : 'medium';
        $params['type'] = !empty($params['type']) ? $params['type'] : 'outline';

        $params['link'] = !empty($params['link']) ? $params['link'] : '#';
        $params['target'] = !empty($params['target']) ? $params['target'] : '_self';

        //prepare params for template
        $params['button_classes'] = $this->getButtonClasses($params);
        $params['button_custom_attrs'] = !empty($params['custom_attrs']) ? $params['custom_attrs'] : [];
        $params['button_styles'] = $this->getButtonStyles($params);
        $params['button_data'] = $this->getButtonDataAttr($params);
        $params['overlay_style'] = $this->getButtonOverlayColor($params);

        echo creator_elated_get_shortcode_module_template_part(
            'templates/' . $params['html_type'],
            'button',
            $params['hover_animation'],
            $params
        );
    }

    protected function _content_template()
    {
    }

    /**
     * Returns array of button styles
     *
     * @param $params
     *
     * @return array
     */
    private function getButtonStyles($params)
    {
        $styles = [];

        if (!empty($params['color'])) {
            $styles[] = 'color: ' . $params['color'];
        }

        if (!empty($params['background_color']) && $params['type'] !== 'outline') {
            $styles[] = 'background-color: ' . $params['background_color'];
        }

        if (!empty($params['border_color'])) {
            $styles[] = 'border-color: ' . $params['border_color'];
        }

        if (!empty($params['font_size'])) {
            $styles[] = 'font-size: ' . creator_elated_filter_px($params['font_size']) . 'px';
        }

        if (!empty($params['font_weight'])) {
            $styles[] = 'font-weight: ' . $params['font_weight'];
        }

        if (!empty($params['margin'])) {
            $styles[] = 'margin: ' . $params['margin'];
        }

        if (!empty($params['border_overlay_color'])) {
            $styles[] = 'border-bottom-color: ' . $params['border_overlay_color'];
        }

        return $styles;
    }

    private function getButtonDataAttr($params)
    {
        $data = [];

        if (!empty($params['hover_background_color'])) {
            $data['data-hover-bg-color'] = $params['hover_background_color'];
        }

        if (!empty($params['hover_color'])) {
            $data['data-hover-color'] = $params['hover_color'];
        }

        if (!empty($params['hover_color'])) {
            $data['data-hover-color'] = $params['hover_color'];
        }

        if (!empty($params['hover_border_color'])) {
            $data['data-hover-border-color'] = $params['hover_border_color'];
        }

        return $data;
    }

    private function getButtonOverlayColor($params)
    {
        $style = '';

        if (!empty($params['border_overlay_color'])) {
            $style .= 'background-color: ' . $params['border_overlay_color'];
        }

        return $style;
    }

    private function getButtonClasses($params)
    {
        $buttonClasses = ['eltd-btn', 'eltd-btn-' . $params['size'], 'eltd-btn-' . $params['type']];

        if (!empty($params['hover_background_color'])) {
            $buttonClasses[] = 'eltd-btn-custom-hover-bg';
        }

        if (!empty($params['hover_border_color'])) {
            $buttonClasses[] = 'eltd-btn-custom-border-hover';
        }

        if (!empty($params['hover_color'])) {
            $buttonClasses[] = 'eltd-btn-custom-hover-color';
        }

        if (!empty($params['icon'])) {
            $buttonClasses[] = 'eltd-btn-icon';
        }

        if (!empty($params['custom_class'])) {
            $buttonClasses[] = $params['custom_class'];
        }

        if (!empty($params['hover_animation'])) {
            $buttonClasses[] = 'eltd-btn-' . $params['hover_animation'];
        }

        return $buttonClasses;
    }
}
