<?php
/**
 * The template for displaying comments.
 *
 * @package epro-classic
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="mt-16 max-w-3xl mx-auto">
	<?php if ( have_comments() ) : ?>
		<h2 class="font-display text-2xl sm:text-3xl font-bold text-neutral-900 dark:text-white">
			<?php
			printf(
				/* translators: %s: comment count. */
				esc_html__( 'Izohlar (%s)', 'epro-classic' ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>

		<ol class="space-y-6 mt-8">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'avatar_size' => 44,
					'short_ping'  => true,
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'class'     => 'epro-pagination',
				'prev_text' => esc_html__( 'Oldingi', 'epro-classic' ),
				'next_text' => esc_html__( 'Keyingi', 'epro-classic' ),
			)
		);
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="mt-8 text-neutral-600 dark:text-neutral-400">
			<?php esc_html_e( 'Izohlar yopilgan.', 'epro-classic' ); ?>
		</p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'  => esc_html__( 'Izoh qoldirish', 'epro-classic' ),
			'label_submit' => esc_html__( 'Yuborish', 'epro-classic' ),
			'class_submit' => 'btn btn-primary btn-lg',
		)
	);
	?>
</div>
