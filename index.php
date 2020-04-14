<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Wypełnij formularz', 'osomform' ); ?></h1>
	</header>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php get_template_part( 'template-parts/contact', 'form' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();