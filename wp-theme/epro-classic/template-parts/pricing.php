<?php
/**
 * Pricing table (3 tiers, monthly/yearly toggle). Editable via the Customizer.
 *
 * @package epro-classic
 */

$fmt = function ( $n ) {
	return number_format( (int) $n, 0, '.', ' ' );
};

$plans = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$monthly = epro_mod( "plan{$i}_monthly" );
	$yearly  = epro_mod( "plan{$i}_yearly" );
	$plans[] = array(
		'name'     => epro_mod( "plan{$i}_name" ),
		'desc'     => epro_mod( "plan{$i}_desc" ),
		'monthly'  => '' === $monthly ? null : (int) $monthly,
		'yearly'   => '' === $yearly ? null : (int) $yearly,
		'featured' => '1' === (string) epro_mod( "plan{$i}_featured" ),
		'cta'      => epro_mod( "plan{$i}_cta" ),
		'features' => array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) epro_mod( "plan{$i}_features" ) ) ) ),
	);
}
?>
<section data-epro-partial="pricing" id="pricing" class="py-20 sm:py-28 scroll-mt-16">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="text-center max-w-2xl mx-auto mb-12">
			<h2 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white">
				<?php echo esc_html( epro_mod( 'pricing_title' ) ); ?>
			</h2>
			<p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
				<?php echo esc_html( epro_mod( 'pricing_subtitle' ) ); ?>
			</p>

			<!-- Billing toggle -->
			<div class="mt-8 inline-flex rounded-full bg-neutral-100 dark:bg-neutral-900 p-1" data-epro-billing>
				<button type="button" class="px-4 py-1.5 text-sm font-medium rounded-full transition-colors" data-billing="monthly" aria-pressed="true"><?php esc_html_e( 'Oylik', 'epro-classic' ); ?></button>
				<button type="button" class="px-4 py-1.5 text-sm font-medium rounded-full transition-colors text-neutral-600 dark:text-neutral-400" data-billing="yearly" aria-pressed="false"><?php esc_html_e( 'Yillik • 2 oy bepul', 'epro-classic' ); ?></button>
			</div>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
			<?php foreach ( $plans as $plan ) : ?>
				<?php if ( '' === $plan['name'] ) { continue; } ?>
				<div class="relative rounded-2xl p-8 flex flex-col <?php echo $plan['featured']
					? 'bg-gradient-to-b from-primary-50 to-white dark:from-primary-950/50 dark:to-neutral-950 border-2 border-primary-500 shadow-xl shadow-primary-500/10'
					: 'bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800'; ?>">

					<?php if ( $plan['featured'] ) : ?>
						<span class="absolute -top-3 left-1/2 -translate-x-1/2 inline-flex items-center rounded-full bg-primary-500 text-white px-3 py-0.5 text-xs font-semibold"><?php esc_html_e( 'ENG MASHHUR', 'epro-classic' ); ?></span>
					<?php endif; ?>

					<h3 class="font-display text-2xl font-bold text-neutral-900 dark:text-white"><?php echo esc_html( $plan['name'] ); ?></h3>
					<p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400"><?php echo esc_html( $plan['desc'] ); ?></p>

					<div class="mt-6">
						<?php if ( null !== $plan['monthly'] ) : ?>
							<div class="flex items-baseline gap-1">
								<span class="text-4xl font-display font-bold text-neutral-900 dark:text-white"
									data-price
									data-monthly="<?php echo esc_attr( $fmt( $plan['monthly'] ) ); ?>"
									data-yearly="<?php echo esc_attr( $fmt( null !== $plan['yearly'] ? (int) round( $plan['yearly'] / 12 ) : $plan['monthly'] ) ); ?>"><?php echo esc_html( $fmt( $plan['monthly'] ) ); ?></span>
								<span class="text-sm text-neutral-500"><?php esc_html_e( "so'm/oy", 'epro-classic' ); ?></span>
							</div>
							<?php if ( null !== $plan['yearly'] ) : ?>
								<p class="text-xs text-primary-600 dark:text-primary-400 mt-1 hidden" data-yearly-hint>
									<?php
									/* translators: %s: total yearly price. */
									printf( esc_html__( 'Yiliga %s so\'m — 2 oy bepul', 'epro-classic' ), '<span>' . esc_html( $fmt( $plan['yearly'] ) ) . '</span>' );
									?>
								</p>
							<?php endif; ?>
						<?php else : ?>
							<div class="text-3xl font-display font-bold text-neutral-900 dark:text-white"><?php esc_html_e( 'Maxsus', 'epro-classic' ); ?></div>
							<p class="text-sm text-neutral-500 mt-1"><?php esc_html_e( 'Talab asosida narx', 'epro-classic' ); ?></p>
						<?php endif; ?>
					</div>

					<ul class="mt-8 space-y-3 flex-1">
						<?php foreach ( $plan['features'] as $feat ) : ?>
							<li class="flex items-start gap-3 text-sm text-neutral-700 dark:text-neutral-300">
								<span class="text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5"><?php echo epro_icon( 'check', 'size-5' ); ?></span>
								<span><?php echo esc_html( $feat ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>

					<a href="<?php echo esc_url( epro_mod( 'cta_primary_link' ) ); ?>" class="btn btn-lg w-full mt-8 <?php echo $plan['featured'] ? 'btn-primary' : 'btn-outline'; ?>">
						<?php echo esc_html( $plan['cta'] ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
