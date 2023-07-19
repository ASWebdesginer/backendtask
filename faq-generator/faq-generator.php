<?php
/*
Plugin Name: FAQ Generator
Description: Generates FAQs using shortcodes.
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com/
*/

// Include FAQ Post Type
require_once plugin_dir_path(__FILE__) . 'admin/faq-post-type.php';
// Include FAQ Post Type
require_once plugin_dir_path(__FILE__) . 'admin/faq-meta-fields.php';
// Include FAQ Post Type
require_once plugin_dir_path(__FILE__) . 'frontend/render_shortcode.php';




function activate()
{
    flush_rewrite_rules();
}
function deactivate()
{
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'activate');
register_deactivation_hook(__FILE__, 'deactivate');
