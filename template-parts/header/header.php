<?php

$post_id = get_the_ID();

// Get the page settings manager
$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');

// Get the settings model for current post
$page_settings_model = $page_settings_manager->get_model($post_id);

// Retrieve the color we added before
$is_header_fixed = $page_settings_model->get_settings('fixed_header') === 'yes';
?>
<header class="eltd-page-header <?php if ($is_header_fixed) {
    echo 'header--fixed';
} ?>">
	<?php if ($show_fixed_wrapper): ?>
	<div class="eltd-fixed-wrapper">
		<?php endif; ?>
		<div class="eltd-menu-area eltd-menu-area-divided" <?php creator_elated_inline_style($menu_area_background_color); ?>>
			<?php do_action('creator_elated_after_header_menu_area_html_open'); ?>
			<?php if ($menu_area_in_grid): ?>
				<div class="eltd-grid" <?php creator_elated_inline_style($menu_area_grid_background_color); ?>>
			<?php endif; ?>
			<div class="eltd-vertical-align-containers">
				<div class="eltd-position-left">
					<div class="eltd-position-left-inner">
						<?php creator_elated_get_left_menu(); ?>
					</div>
				</div>
				<?php if (!$hide_logo) { ?>
				<div class="eltd-position-center" <?php creator_elated_inline_style($logo_holder_width); ?>>
					<div class="eltd-position-center-inner">
						<?php creator_elated_get_logo('divided'); ?>
					</div>
				</div>
				<?php } ?>
					<div class="eltd-position-right">
						<div class="eltd-position-right-inner">
							<?php creator_elated_get_right_menu(); ?>
						</div>
					</div>
				</div>
			</div>
			<?php if ($menu_area_in_grid): ?>
			</div>
			<?php endif; ?>
		<?php if ($show_fixed_wrapper): ?>
	</div>
<?php endif; ?>
	<?php if ($show_sticky) {
     creator_elated_get_sticky_header();
 } ?>
</header>

<?php do_action('creator_elated_after_page_header'); ?>

