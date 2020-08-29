<?php

// prettier-ignore-start
use WPTRT\Customize\Control\ColorAlpha;
// prettier-ignore-end

class Mafeah_Customizer
{
    private $wp_customize;

    private $defaults = [
        'header' => [
            'text-color' => '#96664d',
            'font-size' => 16,
            'logo-width' => 150,
        ],
        'footer' => [
            'bg-color' => '#333',
            'text-color' => '#b79c7d',
        ],
    ];

    function __construct($wp_customize)
    {
        $this->wp_customize = $wp_customize;
    }

    public function add_header_options()
    {
        $this->wp_customize->add_section('mafeah_header_options', [
            'title' => __('Header', 'mafeah'),
            'priority' => 1,
        ]);

        $this->wp_customize->add_setting('header_logo', [
            'transport' => 'refresh',
            'height' => 150,
        ]);

        $this->wp_customize->add_control(
            new WP_Customize_Image_Control($this->wp_customize, 'header_logo', [
                'label' => __('Header Logo', 'mafeah'),
                'section' => 'mafeah_header_options',
                'settings' => 'header_logo',
            ])
        );

        $this->wp_customize->add_setting('header_logo_width', [
            'sanitize_callback' => 'mafeah_sanitize_number_absint',
            'default' => $this->defaults['header']['logo-width'],
            'transport' => 'refresh',
        ]);

        $this->wp_customize->add_control('header_logo_width', [
            'type' => 'number',
            'label' => 'Header Logo Width (px)',
            'section' => 'mafeah_header_options',
            'settings' => 'header_logo_width',
        ]);

        $this->wp_customize->add_setting('header_text_color', [
            'default' => $this->defaults['header']['text-color'],
            'transport' => 'refresh',
        ]);

        $this->wp_customize->add_control(
            new WP_Customize_Color_Control($this->wp_customize, 'header_text_color', [
                'label' => 'Text Color',
                'section' => 'mafeah_header_options',
                'settings' => 'header_text_color',
            ])
        );

        $this->wp_customize->add_setting('header_font_size', [
            'sanitize_callback' => 'mafeah_sanitize_number_absint',
            'default' => 16,
        ]);

        $this->wp_customize->add_control('header_font_size', [
            'type' => 'number',
            'settings' => 'header_font_size',
            'section' => 'mafeah_header_options',
            'label' => __('Font Size (px)'),
        ]);

        function mafeah_sanitize_number_absint($number, $setting)
        {
            $number = absint($number);

            return $number ? $number : $setting->default;
        }

        $this->wp_customize->add_setting('header_background_color', [
            'default' => 'rgba(255,255,255,0)',
            'transport' => 'postMessage',
        ]);

        $this->wp_customize->add_control(
            new ColorAlpha($this->wp_customize, 'header_background_color', [
                'label' => __('Header Background Color', 'mafeah'),
                'section' => 'mafeah_header_options',
                'settings' => 'header_background_color',
            ])
        );
    }

    public function add_button_options()
    {
    }

    public function add_footer_options()
    {
        $this->wp_customize->add_section('mafeah_footer_options', [
            'title' => __('Footer', 'mafeah'),
            'priority' => 2,
        ]);

        $this->wp_customize->add_setting('footer_background_color', [
            'default' => $this->defaults['footer']['bg-color'],
            'transport' => 'postMessage',
        ]);

        $this->wp_customize->add_control(
            new WP_Customize_Color_Control($this->wp_customize, 'footer_background_color', [
                'label' => 'Background Color',
                'section' => 'mafeah_footer_options',
                'settings' => 'footer_background_color',
            ])
        );

        $this->wp_customize->add_setting('footer_text_color', [
            'default' => $this->defaults['footer']['text-color'],
            'transport' => 'postMessage',
        ]);

        $this->wp_customize->add_control(
            new WP_Customize_Color_Control($this->wp_customize, 'footer_text_color', [
                'label' => 'Text Color',
                'section' => 'mafeah_footer_options',
                'settings' => 'footer_text_color',
            ])
        );
    }
}

function mafeah_customize_register($wp_customize)
{
    $mafeah_customizer = new Mafeah_Customizer($wp_customize);

    $mafeah_customizer->add_header_options();
    $mafeah_customizer->add_footer_options();
}

add_action('customize_register', 'mafeah_customize_register');

function mafeah_customizer_header_output()
{
    ?>
    <style type="text/css">

        header,
        .header{
            --header-text-color: <?php echo esc_attr(get_theme_mod('header_text_color')); ?>; 
            --header-bg-color: <?php echo esc_attr(get_theme_mod('header_background_color')); ?>;
            --header-font-size: <?php echo esc_attr(get_theme_mod('header_font_size')) . 'px'; ?>;
            --header-logo-width: <?php echo esc_attr(get_theme_mod('header_logo_width')) . 'px'; ?>;
        }

        footer{
            --footer-bg-color: <?php echo esc_attr(get_theme_mod('footer_background_color')); ?>;
            --footer-text-color: <?php echo esc_attr(get_theme_mod('footer_text_color')); ?>;
        }

    </style>
    <?php
}
add_action('wp_head', 'mafeah_customizer_header_output', -10);

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mafeah_customize_preview_js()
{
    wp_enqueue_script(
        'mafeah-customizer-preview-script',
        get_stylesheet_directory_uri() . '/assets/js/admin/customizer-preview.js',
        ['customize-preview']
    );
}
add_action('customize_preview_init', 'mafeah_customize_preview_js');
