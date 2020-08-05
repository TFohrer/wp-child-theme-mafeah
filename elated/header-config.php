<?php

function custom_creator_elated_header_options_map()
{
    $page = creator_elated_framework()->eltdOptions->getAdminPageFromSlug('_header_page');

    $panel_header = $page->getChild('panel_header');

    creator_elated_add_admin_field([
        'name' => 'header_text_color',
        'type' => 'color',
        'default_value' => '',
        'label' => esc_html__('Menu Text Color', 'creator'),
        'description' => esc_html__('Set menu text color', 'creator'),
        'parent' => $panel_header,
    ]);

    /*creator_elated_add_admin_field(array(
        'name' => 'header_active_link_text_color',
        'type' => 'color',
        'default_value' => '',
        'label' => esc_html__('Menu Active/Hover Text Color','creator'),
        'description' =>esc_html__( 'Set menu text color for active/hover','creator'),
        'parent' => $panel_header
    ));*/
}

add_action('creator_elated_options_map', 'custom_creator_elated_header_options_map', 10);
