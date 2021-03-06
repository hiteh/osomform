<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

?>

		</div><!-- #content -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrap">
				<?php get_template_part( 'template-parts/site', 'info' ); ?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>