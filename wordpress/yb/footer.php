			<?php global $ybwp_data; ?>

			<footer id="footer" class="site-footer">

				<div class="container">

					<?php get_template_part('assets/inc/footer/footer', 'widgets'); ?>

					<div class="sixteen columns">

						<?php get_template_part('assets/inc/footer/footer', 'navigation'); ?>
						
						<?php get_template_part('assets/inc/footer/footer', 'social_icons'); ?>

						<?php get_template_part('assets/inc/footer/footer', 'copyright'); ?>


					</div>

				</div>
				
			</footer> <!-- #footer -->

		</div><!-- #wrapper -->

		<?php if( !empty($ybwp_data['opt-textarea-analyticscode'])) { echo $ybwp_data['opt-textarea-analyticscode']; } ?>

		<?php wp_footer(); ?>

		<?php get_template_part('assets/inc/footer/footer', 'chromeframe'); ?>

	</body>
</html>