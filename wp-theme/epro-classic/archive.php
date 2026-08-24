<?php
/**
 * Archive template (categories, tags, author, date).
 *
 * @package epro-classic
 */

get_header();
?>
<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
		<?php
		if ( function_exists( 'epro_breadcrumbs' ) ) {
			epro_breadcrumbs();
		}
		?>

		<header class="max-w-2xl mb-14">
			<?php
			echo '<h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">' . esc_html( wp_strip_all_tags( get_the_archive_title() ) ) . '</h1>';

			$epro_archive_description = get_the_archive_description();
			if ( $epro_archive_description ) :
				?>
				<div class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
					<?php echo wp_kses_post( $epro_archive_description ); ?>
				</div>
			<?php endif; ?>
		</header>

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
			<p class="text-center text-neutral-600 dark:text-neutral-400"><?php esc_html_e( "Bu bo'limda hozircha post yo'q.", 'epro-classic' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
