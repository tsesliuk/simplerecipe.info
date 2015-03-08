<?php get_header(); ?>

    <?php global $wp_query; ?>

    <div class="content">
        <div class="container">
            <div class="row">

                <?php get_template_part( 'cfg/templates/loop' ); ?>

            </div>
        </div>
    </div>

<?php get_footer(); ?>