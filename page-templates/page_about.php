<?php
/*
Template Name: About Page
*/

get_header(); ?>
<div id="content" class="page-wrap">
    <div class="container content-wrapper">
        <div class="row">

            <div id="primary" class="fp-content-area">
                <main id="main" class="site-main" role="main">
                    <div class="entry-content">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php the_content(); ?>
                        <?php endwhile; ?>
                    </div><!-- .entry-content -->

                </main><!-- #main -->
            </div><!-- #primary -->

        </div>
    </div>
</div><!-- #content -->

<?php get_footer(); ?>
