<?php /* Template Name: homepage */

get_header();
?>
<div class="content" id="homepage">


    <div class="main">
        <div class="heading">
            <h1>Lorem ipsum</h1>
            <h1 class="up">__________</h1>
            <p class="text">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque voluptatem quae illo, eaque amet quod quibusdam rem omnis, exercitationem voluptatum, quaerat eius quo. Facere, excepturi ipsum illum ullam fugit accusamus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, eum eligendi quaerat nisi odio et qui ipsam harum perspiciatis iure corporis necessitatibus, sint ipsum recusandae eaque nulla tempore fugiat adipisci?
            </p>
        </div>
    </div>
    <div class="flages">
        <?php echo do_shortcode('[country_flags]'); ?>
    </div>
</div>

<?php get_footer(); ?>