<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <div class="site-logo">
            <?php
            // Retrieve the site logo from the options page
            $site_logo_id = get_field('site_logo', 'option');

            // Display the logo
            if (!empty($site_logo_id)) {
                echo '<img src="' . esc_url($site_logo_id) . '" alt="' . get_bloginfo('name') . '">';
            } else {
                echo '<img src="default-logo.png" alt="Default Logo">';
            }

            ?>
        </div>

        <nav>
            <?php
            // Display the header menu
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container' => false,
                'menu_class' => 'header-menu',
            ));
            ?>
        </nav>
    </header>