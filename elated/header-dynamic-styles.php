<?php
// creator theme dynamic css
/**
 * Generates styles for header centered logo
 */
function creator_elated_header_centered_logo_styles()
{
    $logo_area_type_2_styles = [];

    if (creator_elated_options()->getOptionValue('logo_area_height_header_centered') !== '') {
        $logo_area_type_2_styles['height'] =
            creator_elated_filter_px(creator_elated_options()->getOptionValue('logo_area_height_header_centered')) .
            'px';
    }

    $logo_area_selector = '.eltd-header-centered .eltd-page-header .eltd-logo-area';
    echo creator_elated_dynamic_css($logo_area_selector, $logo_area_type_2_styles);
}

// newly added options dynamic css
function mafeah_creator_elated_header_navigation_styles()
{
    if (creator_elated_options()->getOptionValue('header_text_color') !== '') {
        $navigation_menu_item_color_styles = [];

        $navigation_menu_item_color_styles['color'] =
            creator_elated_options()->getOptionValue('header_text_color') . ' !important';

        $header_navigation_selector = '.eltd-page-header > div:not(.eltd-sticky-header) .eltd-main-menu .menu-item a';
        echo creator_elated_dynamic_css($header_navigation_selector, $navigation_menu_item_color_styles);
    }

    // active/hover item
    /*if (creator_elated_options()->getOptionValue('header_active_link_text_color') !== '') {

        $navigation_menu_active_item_color_styles = [];
        $navigation_menu_active_item_color_styles['color'] =
            creator_elated_options()->getOptionValue('header_active_link_text_color') . ' !important';

        $header_navigation_active_item_selector = '.eltd-page-header > div:not(.eltd-sticky-header) .eltd-main-menu .eltd-active-item a .item_text, .eltd-page-header > div:not(.eltd-sticky-header) .eltd-main-menu .menu-item > a:hover .item_text';
        echo creator_elated_dynamic_css($header_navigation_active_item_selector, $navigation_menu_active_item_color_styles);
    }*/
}

add_action('creator_elated_style_dynamic', 'creator_elated_header_centered_logo_styles', 15);
add_action('creator_elated_style_dynamic', 'mafeah_creator_elated_header_navigation_styles', 15);
