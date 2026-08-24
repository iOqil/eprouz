<?php
/**
 * Logo cloud. Logos are managed dynamically as "Logotip" posts with a Media
 * Library image (Featured image); falls back to demo initials when none exist.
 *
 * @package epro-classic
 */

$epro_logo_q = new WP_Query( array(
	'post_type'      => 'epro_logo',
	'posts_per_page' => 100,
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	'no_found_rows'  => true,
) );

$has_logos = $epro_logo_q->have_posts();
?>
<section data-epro-partial="logos" class="py-12 border-y border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/20">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<p class="text-center text-sm font-medium text-neutral-500 uppercase tracking-wider">
			<?php echo esc_html( epro_mod( 'logos_title' ) ); ?>
		</p>
		<div class="mt-8 grid grid-cols-3 sm:grid-cols-6 gap-6 items-center">
			<?php if ( $has_logos ) : ?>
				<?php
				while ( $epro_logo_q->have_posts() ) :
					$epro_logo_q->the_post();
					$name = get_the_title();
					?>
					<div class="flex flex-col items-center gap-2 grayscale hover:grayscale-0 opacity-70 hover:opacity-100 transition-all">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php
							the_post_thumbnail( 'medium', array(
								'class' => 'h-12 w-auto max-w-[120px] object-contain',
								'alt'   => esc_attr( $name ),
								'loading' => 'lazy',
							) );
							?>
						<?php else : ?>
							<div class="size-12 rounded-lg bg-neutral-300 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 font-bold">
								<?php echo esc_html( mb_strtoupper( mb_substr( $name, 0, 2 ) ) ); ?>
							</div>
						<?php endif; ?>
						<?php if ( $name ) : ?>
							<span class="text-xs text-neutral-500"><?php echo esc_html( $name ); ?></span>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<?php
					$name    = epro_mod( "logo{$i}_name" );
					$initial = epro_mod( "logo{$i}_initial" );
					if ( '' === $name && '' === $initial ) {
						continue;
					}
					?>
					<div class="flex flex-col items-center gap-2 grayscale hover:grayscale-0 opacity-70 hover:opacity-100 transition-all">
						<div class="size-12 rounded-lg bg-neutral-300 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 font-bold"><?php echo esc_html( $initial ); ?></div>
						<span class="text-xs text-neutral-500"><?php echo esc_html( $name ); ?></span>
					</div>
				<?php endfor; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
