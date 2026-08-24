<?php
/**
 * Hero section. All copy is Customizer-editable (see inc/customizer.php).
 *
 * @package epro-classic
 */

$stats = array(
	array( epro_mod( 'hero_stat1_value' ), epro_mod( 'hero_stat1_label' ) ),
	array( epro_mod( 'hero_stat2_value' ), epro_mod( 'hero_stat2_label' ) ),
	array( epro_mod( 'hero_stat3_value' ), epro_mod( 'hero_stat3_label' ) ),
);
?>
<section data-epro-partial="hero" class="relative overflow-hidden">
	<!-- Background gradient -->
	<div class="absolute inset-0 -z-10" aria-hidden="true">
		<div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-primary-500/10 rounded-full blur-3xl"></div>
		<div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-purple-500/5 rounded-full blur-3xl"></div>
	</div>

	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-20 pb-24 sm:pt-28 sm:pb-32">
		<div class="text-center max-w-4xl mx-auto">
			<?php if ( epro_mod( 'hero_badge' ) ) : ?>
				<span class="badge-soft mb-6">
					<span class="size-2 rounded-full bg-primary-500 animate-pulse mr-2"></span>
					<?php echo esc_html( epro_mod( 'hero_badge' ) ); ?>
				</span>
			<?php endif; ?>

			<h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-neutral-900 dark:text-white leading-tight">
				<?php echo esc_html( epro_mod( 'hero_title1' ) ); ?>
				<span class="bg-gradient-to-r from-primary-500 to-purple-500 bg-clip-text text-transparent">
					<?php echo esc_html( epro_mod( 'hero_title2' ) ); ?>
				</span>
			</h1>

			<p class="mt-6 text-lg sm:text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto leading-relaxed">
				<?php echo esc_html( epro_mod( 'hero_subtitle' ) ); ?>
			</p>

			<div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">
				<a href="<?php echo esc_url( epro_mod( 'hero_cta_primary_link' ) ); ?>" class="btn btn-primary btn-xl">
					<?php echo esc_html( epro_mod( 'hero_cta_primary' ) ); ?>
					<?php echo epro_icon( 'arrow-right', 'size-5' ); ?>
				</a>
				<a href="<?php echo esc_url( epro_mod( 'hero_cta_secondary_link' ) ); ?>" class="btn btn-outline btn-xl">
					<?php echo esc_html( epro_mod( 'hero_cta_secondary' ) ); ?>
				</a>
			</div>

			<?php if ( epro_mod( 'hero_nocard' ) ) : ?>
				<p class="mt-6 text-sm text-neutral-500 dark:text-neutral-500">
					<?php echo esc_html( epro_mod( 'hero_nocard' ) ); ?>
				</p>
			<?php endif; ?>
		</div>

		<!-- Stats -->
		<div class="mt-16 grid grid-cols-3 gap-4 sm:gap-8 max-w-3xl mx-auto">
			<?php foreach ( $stats as $s ) : ?>
				<div class="text-center">
					<div class="text-3xl sm:text-4xl font-display font-bold text-primary-600 dark:text-primary-400"><?php echo esc_html( $s[0] ); ?></div>
					<div class="mt-1 text-sm text-neutral-600 dark:text-neutral-400"><?php echo esc_html( $s[1] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
