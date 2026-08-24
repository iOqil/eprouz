<?php
/**
 * The template for displaying 404 (Not Found) pages.
 *
 * @package epro-classic
 */

get_header();
?>

<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 text-center">
		<p class="bg-gradient-to-r from-primary-500 to-purple-500 bg-clip-text text-transparent font-display text-7xl font-bold">404</p>

		<h1 class="mt-6 font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
			<?php esc_html_e( 'Sahifa topilmadi', 'epro-classic' ); ?>
		</h1>

		<p class="mt-4 text-neutral-600 dark:text-neutral-400">
			<?php esc_html_e( 'Bu sahifa mavjud emas yoki ko\'chirilgan.', 'epro-classic' ); ?>
		</p>

		<div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">
				<?php esc_html_e( 'Bosh sahifaga', 'epro-classic' ); ?>
				<?php echo epro_icon( 'arrow-right', 'size-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>

			<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn-outline btn-lg">
				<?php esc_html_e( 'Blogni ko\'rish', 'epro-classic' ); ?>
			</a>
		</div>

		<div class="mt-10 mx-auto max-w-md">
			<?php get_search_form(); ?>
		</div>
	</div>
</section>

<?php
get_footer();
