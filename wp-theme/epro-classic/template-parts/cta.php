<?php
/**
 * CTA banner (gradient). Editable via the Customizer.
 *
 * @package epro-classic
 */
?>
<section data-epro-partial="cta" id="cta" class="py-20 sm:py-24 scroll-mt-16">
	<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
		<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-purple-700 p-8 sm:p-16 text-center">
			<div class="absolute -top-24 -right-24 size-64 bg-white/10 rounded-full blur-3xl" aria-hidden="true"></div>
			<div class="absolute -bottom-24 -left-24 size-64 bg-white/5 rounded-full blur-3xl" aria-hidden="true"></div>

			<div class="relative">
				<h2 class="font-display text-3xl sm:text-4xl font-bold text-white">
					<?php echo esc_html( epro_mod( 'cta_title' ) ); ?>
				</h2>
				<p class="mt-4 text-lg text-primary-100 max-w-2xl mx-auto">
					<?php echo esc_html( epro_mod( 'cta_subtitle' ) ); ?>
				</p>
				<div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
					<a href="<?php echo esc_url( epro_mod( 'cta_primary_link' ) ); ?>" class="btn btn-xl bg-white text-primary-700 hover:bg-neutral-100">
						<?php echo esc_html( epro_mod( 'cta_primary' ) ); ?>
					</a>
					<a href="<?php echo esc_url( epro_mod( 'cta_secondary_link' ) ); ?>" class="btn btn-xl text-white hover:bg-white/10">
						<?php echo esc_html( epro_mod( 'cta_secondary' ) ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
