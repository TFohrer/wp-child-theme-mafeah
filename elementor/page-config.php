<?php

function add_elementor_page_settings_controls(\Elementor\Core\DocumentTypes\PageBase $page)
{
    // Header Options
    $page->start_controls_section('header_section', [
        'label' => __('Header', 'elementor'),
        'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
    ]);

    $page->add_control('fixed_header', [
        'label' => __('Fixed Header', 'elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'default' => '',
        'return_value' => 'yes',
        'description' => __('Check to display header on top of the content.', 'elementor'),
    ]);

    $page->end_controls_section();
}

add_action('elementor/element/post/document_settings/after_section_end', 'add_elementor_page_settings_controls', 10, 2);
