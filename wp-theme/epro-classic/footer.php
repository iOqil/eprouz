<?php
/**
 * Footer: brand, link columns, social, copyright.
 *
 * @package epro-classic
 */

// Each footer column: a widget area (drop widgets to override), an optional nav
// menu, and a hard-coded fallback link set.
$columns = array(
	array(
		'sidebar'  => 'footer-1',
		'location' => 'footer_product',
		'title'    => __( 'Mahsulot', 'epro-classic' ),
		'links'    => array(
			__( 'Imkoniyatlar', 'epro-classic' ) => '#features',
			__( 'Tariflar', 'epro-classic' )     => '#pricing',
			__( 'Xavfsizlik', 'epro-classic' )   => '#',
		),
	),
	array(
		'sidebar'  => 'footer-2',
		'location' => 'footer_company',
		'title'    => __( 'Kompaniya', 'epro-classic' ),
		'links'    => array(
			__( 'Biz haqimizda', 'epro-classic' ) => '#',
			__( 'Blog', 'epro-classic' )          => esc_url( home_url( '/blog' ) ),
			__( "Bog'lanish", 'epro-classic' )    => '#cta',
		),
	),
	array(
		'sidebar'  => 'footer-3',
		'location' => 'footer_legal',
		'title'    => __( 'Huquqiy', 'epro-classic' ),
		'links'    => array(
			__( 'Foydalanish shartlari', 'epro-classic' ) => '#',
			__( 'Maxfiylik siyosati', 'epro-classic' )    => '#',
			__( 'Cookies siyosati', 'epro-classic' )      => '#',
		),
	),
);
?>
</main>

<footer class="border-t border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-950 mt-auto">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">

		<div class="grid grid-cols-2 md:grid-cols-5 gap-8">

			<div class="col-span-2">
				<?php epro_classic_brand(); ?>
				<p class="mt-4 text-sm text-neutral-600 dark:text-neutral-400 max-w-sm">
					<?php echo esc_html( epro_mod( 'footer_tagline' ) ); ?>
				</p>
				<div class="mt-6 flex items-center gap-2">
					<?php if ( epro_mod( 'footer_telegram' ) ) : ?>
						<a href="<?php echo esc_url( epro_mod( 'footer_telegram' ) ); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-sm !px-2" aria-label="Telegram"><?php echo epro_icon( 'telegram', 'size-5' ); ?></a>
					<?php endif; ?>
					<?php if ( epro_mod( 'footer_github' ) ) : ?>
						<a href="<?php echo esc_url( epro_mod( 'footer_github' ) ); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-sm !px-2" aria-label="GitHub"><?php echo epro_icon( 'github', 'size-5' ); ?></a>
					<?php endif; ?>
					<?php if ( epro_mod( 'footer_email' ) ) : ?>
						<a href="mailto:<?php echo esc_attr( antispambot( epro_mod( 'footer_email' ) ) ); ?>" class="btn btn-ghost btn-sm !px-2" aria-label="Email"><?php echo epro_icon( 'mail', 'size-5' ); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<?php foreach ( $columns as $col ) : ?>
				<div>
					<?php if ( is_active_sidebar( $col['sidebar'] ) ) : ?>
						<?php dynamic_sidebar( $col['sidebar'] ); ?>
					<?php else : ?>
						<h3 class="text-sm font-semibold text-neutral-900 dark:text-white uppercase tracking-wide"><?php echo esc_html( $col['title'] ); ?></h3>
						<?php if ( has_nav_menu( $col['location'] ) ) : ?>
							<?php
							wp_nav_menu( array(
								'theme_location' => $col['location'],
								'container'      => false,
								'menu_class'     => 'mt-4 space-y-3 epro-footer-menu',
								'depth'          => 1,
								'fallback_cb'    => false,
							) );
							?>
						<?php else : ?>
							<ul class="mt-4 space-y-3">
								<?php foreach ( $col['links'] as $label => $url ) : ?>
									<li>
										<a href="<?php echo esc_url( $url ); ?>" class="text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"><?php echo esc_html( $label ); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row justify-between items-center gap-4">
			<p class="text-sm text-neutral-500 dark:text-neutral-500">
				&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <span class="epro-site-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>. <?php echo esc_html( epro_mod( 'footer_rights' ) ); ?>
			</p>
			<p class="text-xs text-neutral-400 dark:text-neutral-600">
				<?php echo esc_html( epro_mod( 'footer_made' ) ); ?> 🇺🇿
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
