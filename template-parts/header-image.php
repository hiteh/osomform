<?php
/**
 * Displays header media
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

?>
<div class="custom-header">
	<?php if ( has_custom_logo() ) : ?>
		<div class="site-logo"><?php the_custom_logo(); ?></div>
	<?php endif; ?>
</div><!-- .custom-header -->