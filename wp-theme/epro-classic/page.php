<?php
/**
 * Generic page template.
 *
 * @package epro-classic
 */

get_header();
?>
<article class="py-16 sm:py-20">
	<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
		<?php while ( have_posts() ) : the_post(); ?>
			<header class="mb-10 text-center">
				<h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white"><?php the_title(); ?></h1>
			</header>

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
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		<?php endwhile; ?>
	</div>
</article>
<?php
get_footer();
