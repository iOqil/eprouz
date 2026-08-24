<?php
/**
 * Single post.
 *
 * @package epro-classic
 */

get_header();
?>
<article class="py-16 sm:py-20">
	<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php if ( function_exists( 'epro_breadcrumbs' ) ) { epro_breadcrumbs(); } ?>

			<header class="mb-8">
				<?php
				$cats = get_the_category_list( ', ' );
				if ( $cats ) :
					?>
					<div class="mb-4 text-sm font-medium text-primary-600 dark:text-primary-400"><?php echo wp_kses_post( $cats ); ?></div>
				<?php endif; ?>

				<h1 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white leading-tight"><?php the_title(); ?></h1>

				<div class="mt-4">
					<?php
					if ( function_exists( 'epro_post_meta' ) ) {
						epro_post_meta();
					} else {
						echo '<time class="text-sm text-neutral-500" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
					}
					?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mb-10 rounded-2xl overflow-hidden">
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content prose dark:prose-invert prose-headings:font-display prose-a:text-primary-600 dark:prose-a:text-primary-400 max-w-none">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="mt-6 text-sm text-neutral-500">' . esc_html__( 'Sahifalar:', 'epro-classic' ),
					'after'  => '</div>',
				) );
				?>
			</div>

			<?php
			$tags = get_the_tag_list( '<div class="mt-10 flex flex-wrap gap-2">', '', '</div>' );
			if ( $tags ) {
				echo wp_kses_post( str_replace( 'rel="tag"', 'rel="tag" class="badge-soft"', $tags ) );
			}
			?>

			<?php
			if ( function_exists( 'epro_post_navigation' ) ) {
				epro_post_navigation();
			}
			?>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>

		<?php endwhile; ?>
	</div>
</article>
<?php
get_footer();
