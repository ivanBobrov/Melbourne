<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sydney
 */
?>

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php get_sidebar('footer'); ?>
	<?php endif; ?>

	<?php if (!is_front_page()) : ?>

    <a class="go-top"><i class="fa fa-angle-up"></i></a>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info container">
			<a href="<?php echo esc_url('http://askkm.org/'); ?>"><?php echo "Ассоциация студенческих клубов классической музыки"; ?></a>
			<span class="sep"> | </span>
			<?php echo "2016"; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

	<?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
