<?php
/**
 * Header: <head>, sticky navbar, mobile menu.
 *
 * @package epro-classic
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#6366f1" media="(prefers-color-scheme: light)">
	<meta name="theme-color" content="#0b0d12" media="(prefers-color-scheme: dark)">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'min-h-screen flex flex-col bg-white dark:bg-neutral-950 font-sans text-neutral-900 dark:text-white antialiased' ); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:rounded-md focus:bg-primary-600 focus:px-4 focus:py-2 focus:text-white" href="#content">
	<?php esc_html_e( 'Asosiy kontentga o\'tish', 'epro-classic' ); ?>
</a>

<header class="sticky top-0 z-40 w-full border-b border-neutral-200/60 dark:border-neutral-800/60 bg-white/80 dark:bg-neutral-950/80 backdrop-blur">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

		<!-- Brand -->
		<?php epro_classic_brand(); ?>

		<!-- Desktop nav -->
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => 'nav',
				'container_class'=> 'hidden md:flex items-center gap-6',
				'menu_class'     => 'flex items-center gap-6',
				'depth'          => 1,
				'link_before'    => '',
				'fallback_cb'    => false,
			) );
		} else {
			epro_classic_default_nav();
		}
		?>

		<!-- Actions -->
		<div class="flex items-center gap-1 sm:gap-2">

			<!-- Language switcher -->
			<div class="relative hidden sm:block" data-epro-dropdown>
				<button type="button" class="btn btn-ghost btn-sm" data-epro-dropdown-toggle aria-haspopup="true" aria-expanded="false">
					<?php echo epro_icon( 'languages', 'size-4' ); ?>
					<span>UZ</span>
				</button>
				<div class="hidden absolute right-0 mt-2 w-32 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 shadow-lg py-1" data-epro-dropdown-menu>
					<?php
					$langs = array( 'uz' => "O'zbekcha", 'ru' => 'Русский', 'en' => 'English' );
					foreach ( $langs as $code => $label ) {
						printf(
							'<a href="#" class="block px-3 py-1.5 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800">%s</a>',
							esc_html( $label )
						);
					}
					?>
				</div>
			</div>

			<!-- Theme toggle -->
			<button type="button" class="btn btn-ghost btn-sm !px-2" data-epro-theme-toggle aria-label="<?php esc_attr_e( 'Toggle theme', 'epro-classic' ); ?>">
				<span class="hidden dark:inline"><?php echo epro_icon( 'sun', 'size-5' ); ?></span>
				<span class="inline dark:hidden"><?php echo epro_icon( 'moon', 'size-5' ); ?></span>
			</button>

			<!-- Sign in -->
			<a href="<?php echo esc_url( epro_mod( 'header_signin_link' ) ); ?>" class="btn btn-ghost btn-sm hidden sm:inline-flex"><?php echo esc_html( epro_mod( 'header_signin_label' ) ); ?></a>

			<!-- Get started -->
			<a href="<?php echo esc_url( epro_mod( 'header_cta_link' ) ); ?>" class="btn btn-primary btn-sm hidden sm:inline-flex"><?php echo esc_html( epro_mod( 'header_cta_label' ) ); ?></a>

			<!-- Mobile toggle -->
			<button type="button" class="btn btn-ghost btn-sm !px-2 md:hidden" data-epro-mobile-toggle aria-label="<?php esc_attr_e( 'Menu', 'epro-classic' ); ?>">
				<?php echo epro_icon( 'menu', 'size-5' ); ?>
			</button>
		</div>
	</div>

	<!-- Mobile nav -->
	<div class="hidden md:hidden border-t border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950" data-epro-mobile-menu>
		<div class="px-4 py-4 space-y-1">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'space-y-1',
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
			} else {
				$items = array(
					__( 'Imkoniyatlar', 'epro-classic' ) => '#features',
					__( 'Tariflar', 'epro-classic' )     => '#pricing',
					__( 'Blog', 'epro-classic' )         => esc_url( home_url( '/blog' ) ),
					__( "Bog'lanish", 'epro-classic' )   => '#cta',
				);
				foreach ( $items as $label => $url ) {
					printf(
						'<a href="%s" class="block px-3 py-2 rounded-md text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-900">%s</a>',
						esc_url( $url ),
						esc_html( $label )
					);
				}
			}
			?>
			<div class="pt-3 border-t border-neutral-200 dark:border-neutral-800 flex flex-col gap-2">
				<a href="<?php echo esc_url( epro_mod( 'header_signin_link' ) ); ?>" class="btn btn-outline btn-md w-full"><?php echo esc_html( epro_mod( 'header_signin_label' ) ); ?></a>
				<a href="<?php echo esc_url( epro_mod( 'header_cta_link' ) ); ?>" class="btn btn-primary btn-md w-full"><?php echo esc_html( epro_mod( 'header_cta_label' ) ); ?></a>
			</div>
		</div>
	</div>
</header>

<main id="content" tabindex="-1" class="flex-1">
