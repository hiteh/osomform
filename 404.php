<?php
/**
 * Displays 404 Error page
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

?>

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title leading-title"><?php esc_html_e( 'Oops! Strona, której szukasz nie istnieje w tym serwisie!', 'osomform' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( '404 (Page Not Found)', 'osomform' ); ?></p>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();