<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php
    /**
     * @see creator_elated_header_meta() - hooked with 10
     * @see eltd_user_scalable - hooked with 10
     */
    if (!creator_elated_is_ajax_request()) {
        do_action('creator_elated_header_meta');
    }

    if (!creator_elated_is_ajax_request()) {
        wp_head();
    }
    ?>
</head>

<body <?php body_class(); ?>>
<?php
if (!creator_elated_is_ajax_request()) {
    creator_elated_get_side_area();
}

if (!creator_elated_is_ajax_request() && creator_elated_options()->getOptionValue('smooth_page_transitions') == 'yes') {
    $creator_elated_ajax_class = 'eltd-mimic-ajax'; ?>
<div class="eltd-smooth-transition-loader <?php echo esc_attr($creator_elated_ajax_class); ?>">
    <div class="eltd-st-loader">
        <div class="eltd-st-loader1">
            <?php creator_elated_loading_spinners(); ?>
        </div>
    </div>
</div>
<?php
}
?>
<div class="eltd-wrapper">
    <div class="eltd-wrapper-inner">
        <?php if (!creator_elated_is_ajax_request()) {
            get_template_part('template-parts/header/header');
            //creator_elated_get_header();
        } ?>

        <?php
        if (
            !creator_elated_is_ajax_request() &&
            creator_elated_options()->getOptionValue('show_back_button') == 'yes'
        ) { ?>
            <a id='eltd-back-to-top'  href='#'>
                <span class="eltd-icon-stack">
                     <?php creator_elated_icon_collections()->getBackToTopIcon('font_elegant'); ?>
                </span>
            </a>
        <?php }
        creator_elated_get_full_screen_menu();
        ?>

        <div class="eltd-content" <?php creator_elated_content_elem_style_attr(); ?>>
            <?php if (creator_elated_is_ajax_enabled()) { ?>
            <div class="eltd-meta">
                <?php do_action('creator_elated_ajax_meta'); ?>
                <span id="eltd-page-id"><?php echo esc_html(get_queried_object_id()); ?></span>
                <div class="eltd-body-classes"><?php echo esc_html(implode(',', get_body_class())); ?></div>
            </div>
            <?php } ?>
            <div class="eltd-content-inner">