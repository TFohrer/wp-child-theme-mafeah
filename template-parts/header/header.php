<?php

$post_id = get_the_ID();

// Get the page settings manager
$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');

// Get the settings model for current post
$page_settings_model = $page_settings_manager->get_model($post_id);

// Retrieve the color we added before
$is_header_fixed = $page_settings_model->get_settings('fixed_header') === 'yes';

$header_behavior = creator_elated_options()->getOptionValue('header_behaviour');
$show_sticky = in_array($header_behavior, ['sticky-header-on-scroll-up', 'sticky-header-on-scroll-down-up'])
    ? true
    : false;
?>

<header class="header<?php if ($is_header_fixed) {
    echo ' header--fixed';
} ?>">

    <div class="header__left-area">
        <?php creator_elated_get_left_menu(); ?>
    </div>
    <div class="header__logo">
        <a href="<?php echo get_home_url(); ?>">
            <img src="<?php echo esc_url(get_theme_mod('header_logo')); ?>" alt="Mafeah Header Logo">
        </a>
    </div>
    <div class="header__right-area">
        <?php creator_elated_get_right_menu(); ?>

        <div class="header__shop-icons">
            <?php the_widget('CreatorElatedWoocommerceDropdownCart'); ?>

            <div class="header-shop-icons__account">
                <a href="/my-account" rel="nofollow"><i class="fa fa-user"></i></a>
            </div>
        </div>
    </div>
</header>


<header class="header__sticky-container eltd-page-header">
	<?php if ($show_sticky) {
     get_template_part('template-parts/header/sticky-header');
 } ?>
</header>

<?php get_template_part('template-parts/header/mobile-header'); ?>

