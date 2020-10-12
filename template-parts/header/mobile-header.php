<?php do_action('creator_elated_before_mobile_header');

$menu_opener_icon = creator_elated_icon_collections()->getMobileMenuIcon(
    creator_elated_options()->getOptionValue('mobile_icon_pack'),
    true
);
?>

<header class="eltd-mobile-header header__mobile-container">
    <div class="eltd-mobile-header-inner">
        <?php do_action('creator_elated_after_mobile_header_html_open'); ?>
        <div class="eltd-mobile-header-holder">
            <div class="eltd-grid">
                <div class="eltd-vertical-align-containers">
                    <div class="eltd-mobile-menu-opener">
                        <a href="javascript:void(0)">
                            <span class="eltd-mobile-opener-icon-holder">
                                <?php echo creator_elated_get_module_part($menu_opener_icon); ?>
                            </span>
                        </a>
                    </div>
                    <div class="eltd-position-center">
                        <div class="eltd-position-center-inner">
                            <div class="eltd-mobile-logo-wrapper">
                                <a href="<?php echo get_home_url(); ?>">
                                    <img src="<?php echo esc_url(get_theme_mod('header_logo')); ?>" alt="Mobile Logo">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="eltd-position-right">
                        <div class="eltd-position-right-inner">
                        <div class="header__shop-icons">
                                <?php the_widget('CreatorElatedWoocommerceDropdownCart'); ?>

                                <div class="header-shop-icons__account">
                                    <a href="/my-account" rel="nofollow"><i class="fa fa-user"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- close .eltd-vertical-align-containers -->
            </div>
        </div>
        <?php do_action('creator_elated_before_mobile_navigation'); ?>
        
        <nav class="eltd-mobile-nav" role="navigation" aria-label="<?php esc_attr_e('Mobile Menu', 'creator'); ?>">
            <div class="eltd-grid">
                <?php wp_nav_menu([
                    'theme_location' => 'left-navigation',
                    'container' => '',
                    'container_class' => '',
                    'menu_class' => '',
                    'menu_id' => '',
                    'fallback_cb' => 'top_navigation_fallback',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                    'walker' => new CreatorElatedMobileNavigationWalker(),
                ]); ?>
                <?php wp_nav_menu([
                    'theme_location' => 'right-navigation',
                    'container' => '',
                    'container_class' => '',
                    'menu_class' => '',
                    'menu_id' => '',
                    'fallback_cb' => 'top_navigation_fallback',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                    'walker' => new CreatorElatedMobileNavigationWalker(),
                ]); ?>
            </div>
        </nav>

<?php do_action('creator_elated_after_mobile_navigation'); ?>
    </div>
</header> <!-- close .eltd-mobile-header -->

<?php do_action('creator_elated_after_mobile_header'); ?>
