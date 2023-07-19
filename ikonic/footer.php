<footer>
    <div class="site-logo">
        <?php
        // Retrieve the site logo from the options page
        $site_logo = get_field('site_logo', 'option');

        if ($site_logo) {
            echo '<img src="' . $site_logo . '" alt="' . get_bloginfo('name') . '">';
        } else {
            echo '<h1>' . get_bloginfo('name') . '</h1>';
        }
        ?>
    </div>

    <nav class="footer-menu">
        <?php
        // Display the footer menu
        wp_nav_menu(array(
            'theme_location' => 'footer-menu',
            'container' => false,
        ));
        ?>
    </nav>

    <div class="contact-info">
        <p><?php echo get_field('address', 'option'); ?></p>
        <p><?php echo get_field('contact_number', 'option'); ?></p>
    </div>
</footer>