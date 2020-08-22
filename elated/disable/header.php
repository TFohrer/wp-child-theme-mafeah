<?php

// disable not needed elated header stuff

// admin options
function creator_elated_header_options_map()
{
    return false;
}
// dynamic styles
function creator_elated_header_centered_logo_styles()
{
    return false;
}

function remove_parent_theme_header_functions()
{
    remove_action('creator_elated_options_map', 'creator_elated_header_options_map', 7);
}

add_action('wp_loaded', 'remove_parent_theme_header_functions');
