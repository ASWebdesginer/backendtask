<?php
function custom_theme_enqueue_styles()
{
    $style_file_path = get_stylesheet_directory() . '/style.css';

    // Enqueue your custom style file with the dynamic version number
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime($style_file_path), 'all');
    wp_enqueue_style('home-style', get_stylesheet_directory_uri() . '/assets/home.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');



function custom_theme_register_menus()
{
    register_nav_menus(array(
        'primary-menu' => 'Primary Menu',
        'footer-menu' => 'Footer Menu'
    ));
}
add_action('after_setup_theme', 'custom_theme_register_menus');

// to enable acf options page

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}
// to save contact number and address
function save_global_settings()
{
    // Check if ACF is active and the required function exists
    if (function_exists('acf_add_options_page') && function_exists('update_field')) {
        // Check if the necessary fields are present in the global settings
        if (get_field('address', 'option') && get_field('contact_number', 'option') && get_field('site_logo', 'option')) {
            // Get the address and contact number values from the global settings
            $address = get_field('address', 'option');
            $contact_number = get_field('contact_number', 'option');
            $sitelogo = get_field('site_logo', 'option');

            // Store the address and contact number as options using update_field
            update_field('site_address', $address, 'option');
            update_field('site_contact_number', $contact_number, 'option');
            update_field('site_logo', $sitelogo, 'option');
            // Display the custom logo
            if (function_exists('the_custom_logo')) {
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

                if ($logo) {
                    echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
                } else {
                    echo '<img src="default-logo.png" alt="Default Logo">';
                }
            }
        }
    }
}
add_action('acf/save_post', 'save_global_settings', 20);

// Display the custom logo
if (function_exists('the_custom_logo')) {
    the_custom_logo();
}
// shortcode for  flags api
function country_flags_shortcode()
{
    $api_url = 'https://restcountries.com/v3.1/all?fields=name,flags';

    // Call the API and fetch the response
    $response = wp_remote_get($api_url);

    // Check if the API request was successful
    if (is_wp_error($response)) {
        return 'Failed to fetch country data.';
    }

    // Parse the response body as JSON
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Check if the JSON data is valid
    if (!is_array($data)) {
        return 'Invalid country data.';
    }

    // Prepare the output HTML
    $output = '<ul>';

    foreach ($data as $country) {
        $country_name = $country['name']['common'];
        $country_flag = isset($country['flags']['png']) ? $country['flags']['png'] : '';

        if (!empty($country_name) && !empty($country_flag)) {
            $output .= '<li>';
            $output .= '<img src="' . esc_url($country_flag) . '" alt="' . esc_attr($country_name) . ' Flag" />';
            $output .= '<span>' . esc_html($country_name) . '</span>';
            $output .= '</li>';
        }
    }

    $output .= '</ul>';

    return $output;
}
add_shortcode('country_flags', 'country_flags_shortcode');
