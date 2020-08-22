<?php

require __DIR__ . '/vendor/autoload.php';

$manifestStr = file_get_contents(dirname(__FILE__) . '/build/manifest.json');
$manifest = json_decode($manifestStr, true);

/*** Child Theme Function  ***/
if (!function_exists('creator_elated_child_theme_enqueue_scripts')) {
    function creator_elated_child_theme_enqueue_scripts()
    {
        $parent_style = 'creator-elated-default-style';

        wp_enqueue_style('creator-elated-handle-child-style', get_stylesheet_directory_uri() . '/style.css', [
            $parent_style,
        ]);
    }

    add_action('wp_enqueue_scripts', 'creator_elated_child_theme_enqueue_scripts');
}

//include_once 'elements/image-overlay.php';
require_once 'admin/customizer.php';

// Custom JS/CSS styles
/** additional styles */
function load_style_files($manifest)
{
    $child_theme = 'creator-elated-handle-child-style';
    $cssFileURI = get_stylesheet_directory_uri() . '/build/' . $manifest['main.css'];
    wp_enqueue_style('main_css', $cssFileURI, [$child_theme]);

    //remove plugin styles
    wp_dequeue_style('wpuf-css');
}

add_action(
    'wp_enqueue_scripts',
    function () use ($manifest) {
        load_style_files($manifest);
    },
    99
);

/** additional js **/

function load_javascript_files($manifest)
{
    $mainJsFileName = $manifest['main.js'];

    wp_register_script('main_js', get_stylesheet_directory_uri() . '/build/' . $mainJsFileName, ['jquery'], true, true);
    wp_enqueue_script('main_js');
}

add_action(
    'wp_enqueue_scripts',
    function () use ($manifest) {
        load_javascript_files($manifest);
    },
    99
);

// custom admin styles
function admin_style()
{
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/style-admin.css');
}

add_action('admin_enqueue_scripts', 'admin_style');

add_action('elementor/editor/before_enqueue_scripts', function () {
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/style-admin.css');
});

// Custom Elementor stuff
require_once 'elementor/categories.php';
require_once 'elementor/widgets.php';
require_once 'elementor/page-config.php';

// Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

// Parallax (TODO move to js file and optimize)

function jquery_parallax()
{
    ?>
    <script language="JavaScript" type="text/javascript">
    
;(function($) {
   'use strict'
    var testMobile;
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
  var parallax = function() {
    testMobile = isMobile.any();
    if (testMobile == null) {
      $(".parallax").parallax("50%", 0.3);
    }
  };
  // Dom Ready
  $(function() {
    parallax();
     });
})(jQuery);
/*
jQuery Parallax 1.1.3
Author: Ian Lunn
Plugin URL: https://www.ianlunn.co.uk/plugins/jquery-parallax/
Dual licensed under the MIT and GPL licenses:
https://www.opensource.org/licenses/mit-license.php
https://www.gnu.org/licenses/gpl.html
*/
!function(n){var t=n(window),e=t.height();t.resize(function(){e=t.height()}),n.fn.parallax=function(o,r,i){function u(){var i=t.scrollTop();l.each(function(t,u){var l=n(u),f=l.offset().top,s=a(l);i>f+s||f>i+e||l.css("backgroundPosition",o+" "+Math.round((l.data("firstTop")-i)*r)+"px")})}var a,l=n(this);l.each(function(t,e){$element=n(e),$element.data("firstTop",$element.offset().top)}),a=i?function(n){return n.outerHeight(!0)}:function(n){return n.height()},(arguments.length<1||null===o)&&(o="50%"),(arguments.length<2||null===r)&&(r=.1),(arguments.length<3||null===i)&&(i=!0),t.bind("scroll",u).resize(u),u()}}(jQuery);
    </script>
    <?php
}
if (!is_admin()) {
    wp_enqueue_script('jquery');
    add_action('wp_head', 'jquery_parallax');
}

// ELATED parent theme
// disable stuff
include_once 'elated/disable/header.php';

add_action('customize_register', function ($wp_customize) {
    $wp_customize->register_control_type('\WPTRT\Customize\Control\ColorAlpha');
});
