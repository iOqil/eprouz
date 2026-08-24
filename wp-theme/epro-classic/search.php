<?php
/**
 * Search results template.
 *
 * @package epro-classic
 */

get_header();
?>
<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
		<div class="max-w-2xl mx-auto mb-14 text-center">
			<h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( '"%s" bo\'yicha natijalar', 'epro-classic' ), esc_html( get_search_query() ) );
				?>
			</h1>
			<div class="mt-8">
				<?php get_search_form(); ?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="group rounded-2xl overflow-hidden bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-lg transition-all flex flex-col">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="block aspect-[16/9] overflow-hidden">
								<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="p-6 flex flex-col flex-1">
							<div class="flex items-center gap-2 text-xs text-neutral-500 mb-3">
								<?php echo epro_icon( 'clock', 'size-4' ); ?>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</div>
							<h2 class="font-display font-semibold text-xl text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed flex-1"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary-600 dark:text-primary-400">
								<?php esc_html_e( "O'qish", 'epro-classic' ); ?>
								<?php echo epro_icon( 'arrow-right', 'size-4' ); ?>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="mt-12 flex justify-center">
				<?php
				the_posts_pagination( array(
					'mid_size'  => 1,
					'prev_text' => esc_html__( 'Oldingi', 'epro-classic' ),
					'next_text' => esc_html__( 'Keyingi', 'epro-classic' ),
					'class'     => 'epro-pagination',
				) );
				?>
			</div>
		<?php else : ?>
			<div class="max-w-xl mx-auto text-center">
				<p class="text-neutral-600 dark:text-neutral-400"><?php esc_html_e( "Hech narsa topilmadi. Boshqa so'z bilan urinib ko'ring.", 'epro-classic' ); ?></p>
				<div class="mt-8">
					<?php get_search_form(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
