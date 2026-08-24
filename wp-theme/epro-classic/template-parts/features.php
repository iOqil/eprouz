<?php
/**
 * Features grid. Items are managed dynamically as "Imkoniyat" posts
 * (Imkoniyatlar menu); falls back to demo defaults when none exist yet.
 *
 * @package epro-classic
 */

// Pull feature cards from the CPT (manually orderable via Page Attributes).
$epro_feature_q = new WP_Query( array(
	'post_type'      => 'epro_feature',
	'posts_per_page' => 100,
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	'no_found_rows'  => true,
) );

$features = array();
if ( $epro_feature_q->have_posts() ) {
	while ( $epro_feature_q->have_posts() ) {
		$epro_feature_q->the_post();
		$features[] = array(
			'icon'  => epro_feature_icon( get_the_ID() ),
			'title' => get_the_title(),
			'desc'  => wp_strip_all_tags( get_the_excerpt() ),
		);
	}
	wp_reset_postdata();
} else {
	// Fallback: the original 9 demo cards.
	for ( $i = 1; $i <= 9; $i++ ) {
		$title = epro_mod( "feature{$i}_title" );
		if ( '' === $title ) {
			continue;
		}
		$features[] = array(
			'icon'  => epro_mod( "feature{$i}_icon" ),
			'title' => $title,
			'desc'  => epro_mod( "feature{$i}_desc" ),
		);
	}
}
?>
<section data-epro-partial="features" id="features" class="py-20 sm:py-28 bg-neutral-50/50 dark:bg-neutral-900/30 border-y border-neutral-200 dark:border-neutral-800 scroll-mt-16">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="text-center max-w-2xl mx-auto mb-16">
			<h2 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white">
				<?php echo esc_html( epro_mod( 'features_title' ) ); ?>
			</h2>
			<p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
				<?php echo esc_html( epro_mod( 'features_subtitle' ) ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ( $features as $f ) : ?>
				<div class="group p-6 rounded-xl bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-lg transition-all">
					<div class="size-12 rounded-lg bg-primary-100 dark:bg-primary-950 flex items-center justify-center text-primary-600 dark:text-primary-400 group-hover:scale-110 transition-transform">
						<?php echo epro_icon( $f['icon'], 'size-6' ); ?>
					</div>
					<h3 class="mt-4 font-display font-semibold text-lg text-neutral-900 dark:text-white"><?php echo esc_html( $f['title'] ); ?></h3>
					<p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed"><?php echo esc_html( $f['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
