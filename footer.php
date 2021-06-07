<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="container clearfix">
				<?php
					if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
						//get_template_part( 'includes/social_icons', 'footer' );
					}
				?>

						<p id="footer-info">&copy; copyright <?php echo date("Y") ?> - Airsled, INC. - All Rights Reserved | <a href="/privacy-policy/">Privacy Policy</a> | <a href="/returns-policy/">Returns Policy</a> </p>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
<script type="text/javascript" src="https://app.getjess.com/fi.js"></script><script type="text/javascript">
    new JessCRMForm({integration_key: '7cdf6805-de0b-4d7f-a5c0-c573924c9559'})
</script>

<script src="https://chatbot.textchat.ai/client/shopify/js/widget.js?clientToken=a7369989-189e-4538-9701-be52787036db&basePath=https://chatbot.textchat.ai&iFramePath=https://chatbot.textchat.ai/root"></script>


</body>
</html>