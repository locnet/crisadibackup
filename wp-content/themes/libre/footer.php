<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Libre
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>

			<div class="footer-widgets clear">

				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'footer-1' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'footer-2' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'footer-3' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

			</div><!-- .footer-widgets -->

		<?php endif; ?>

		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'libre' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'libre' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'libre' ), 'Libre', '<a href="http://wordpress.com/themes/" rel="designer">Automattic</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
