<?php
/**
 * EPRO — Classic theme functions.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'EPRO_CLASSIC_VERSION', '1.0.0' );

// Theme options (defaults, readers, palette) + Customizer registration.
require_once get_theme_file_path( 'inc/options.php' );
require_once get_theme_file_path( 'inc/customizer.php' );

// Template helpers, SEO/Open-Graph output, and the contact-form handler.
require_once get_theme_file_path( 'inc/template-tags.php' );
require_once get_theme_file_path( 'inc/seo.php' );
require_once get_theme_file_path( 'inc/contact.php' );

// Dynamic content types (logos + features) managed from the admin.
require_once get_theme_file_path( 'inc/post-types.php' );

/**
 * Theme setup: supports + navigation menus.
 */
function epro_classic_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 32,
		'width'       => 32,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	// Make the block editor canvas match the front-end (fonts + content styles).
	add_theme_support( 'editor-styles' );
	add_editor_style( array(
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap',
		'assets/css/editor.css',
		'assets/css/blocks.css',
	) );

	register_nav_menus( array(
		'primary'         => __( 'Asosiy menyu', 'epro-classic' ),
		'footer_product'  => __( 'Footer — Mahsulot', 'epro-classic' ),
		'footer_company'  => __( 'Footer — Kompaniya', 'epro-classic' ),
		'footer_legal'    => __( 'Footer — Huquqiy', 'epro-classic' ),
	) );

	load_theme_textdomain( 'epro-classic', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'epro_classic_setup' );

/**
 * Optional footer widget area — only renders (in footer.php) when populated, so
 * the default footer design is unchanged.
 */
function epro_classic_widgets_init() {
	$widget_args = array(
		'before_widget' => '<div id="%1$s" class="widget %2$s mb-6 last:mb-0">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="text-sm font-semibold text-neutral-900 dark:text-white uppercase tracking-wide mb-4">',
		'after_title'   => '</h3>',
	);

	// Blog sidebar (shown on the blog index / archives / single when populated).
	register_sidebar( array_merge( $widget_args, array(
		'name'        => __( 'Blog yon paneli', 'epro-classic' ),
		'id'          => 'blog-sidebar',
		'description' => __( 'Blog ro\'yxati va maqola sahifalarida ko\'rinadi (faqat widget qo\'shilsa).', 'epro-classic' ),
	) ) );

	// Three footer columns — drop widgets here to replace the default link columns.
	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar( array_merge( $widget_args, array(
			/* translators: %d: footer column number. */
			'name'        => sprintf( __( 'Footer ustun %d', 'epro-classic' ), $i ),
			'id'          => 'footer-' . $i,
			'description' => __( 'Footerdagi ustun (bo\'sh bo\'lsa standart havolalar ko\'rsatiladi).', 'epro-classic' ),
		) ) );
	}
}
add_action( 'widgets_init', 'epro_classic_widgets_init' );

/**
 * Threaded comment-reply script on singular views.
 */
function epro_classic_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'epro_classic_comment_reply' );

/**
 * Enqueue fonts, Tailwind (CDN) and theme assets.
 */
function epro_classic_assets() {
	// Google Fonts — Inter (body) + Manrope (display), matching the Nuxt design.
	wp_enqueue_style(
		'epro-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap',
		array(),
		null
	);

	// Tailwind Play CDN (with the typography + forms first-party plugins).
	// NOTE: the Play CDN is great for prototyping and "trying" the design. For
	// production you would swap this for a compiled stylesheet (see README).
	wp_enqueue_script(
		'tailwind-cdn',
		'https://cdn.tailwindcss.com?plugins=forms,typography',
		array(),
		null,
		false // load in <head> so utilities are ready before paint.
	);
	wp_add_inline_script( 'tailwind-cdn', epro_classic_tailwind_config(), 'after' );

	// Local theme styles (prose tweaks, dropdowns, animations).
	wp_enqueue_style(
		'epro-classic',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		EPRO_CLASSIC_VERSION
	);

	// Front-end styling for Gutenberg/core blocks in post & page content.
	wp_enqueue_style(
		'epro-blocks',
		get_theme_file_uri( 'assets/css/blocks.css' ),
		array( 'epro-classic' ),
		EPRO_CLASSIC_VERSION
	);

	// Interactivity: dark-mode toggle, mobile menu, dropdowns.
	wp_enqueue_script(
		'epro-classic',
		get_theme_file_uri( 'assets/js/theme.js' ),
		array(),
		EPRO_CLASSIC_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'epro_classic_assets' );

/**
 * Tailwind runtime config — maps `primary` to the (Customizer-driven) brand
 * palette and `neutral` to slate so utilities match the original Nuxt UI look.
 */
function epro_classic_tailwind_config() {
	$pairs = array();
	foreach ( epro_primary_palette() as $shade => $hex ) {
		$pairs[] = $shade . ":'" . $hex . "'";
	}
	$primary = implode( ',', $pairs );

	return "tailwind.config={darkMode:'class',theme:{extend:{colors:{"
		. "primary:{{$primary}},"
		. "neutral:{50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#020617'}"
		. "},fontFamily:{sans:['Inter','ui-sans-serif','system-ui','sans-serif'],display:['Manrope','Inter','ui-sans-serif','system-ui','sans-serif']}}}};";
}

/**
 * Expose the brand palette to plain CSS (footer/menu/pagination accents) so a
 * Customizer colour change recolours those bits too.
 */
function epro_classic_dynamic_css() {
	$p = epro_primary_palette();
	printf(
		'<style id="epro-dynamic-css">:root{--epro-primary-400:%1$s;--epro-primary-500:%2$s;--epro-primary-600:%3$s;}</style>' . "\n",
		esc_html( $p[400] ),
		esc_html( $p[500] ),
		esc_html( $p[600] )
	);
}
add_action( 'wp_head', 'epro_classic_dynamic_css', 2 );

/**
 * Reusable component classes (buttons, badges) defined via Tailwind's
 * `@layer components`. Printed as a `text/tailwindcss` block the Play CDN reads.
 */
function epro_classic_tailwind_components() {
	echo <<<'HTML'
<style type="text/tailwindcss">
  @layer components {
    .btn { @apply inline-flex items-center justify-center gap-2 rounded-md font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500/50; }
    .btn-sm { @apply px-3 py-1.5 text-sm; }
    .btn-md { @apply px-3.5 py-2 text-sm; }
    .btn-lg { @apply px-4 py-2.5 text-base; }
    .btn-xl { @apply px-5 py-3 text-base; }
    .btn-primary { @apply bg-primary-500 text-white hover:bg-primary-600; }
    .btn-ghost { @apply text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800; }
    .btn-outline { @apply border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-900; }
    .badge-soft { @apply inline-flex items-center rounded-full bg-primary-50 dark:bg-primary-950 text-primary-700 dark:text-primary-300 px-3 py-1 text-sm font-medium; }
    .nav-link { @apply text-sm text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors; }
  }
</style>
HTML;
}
add_action( 'wp_head', 'epro_classic_tailwind_components', 20 );

/**
 * No-flash dark mode: set the `dark` class on <html> before first paint.
 */
function epro_classic_color_mode_boot() {
	echo <<<'HTML'
<script>
  (function () {
    try {
      var s = localStorage.getItem('epro-theme');
      var dark = s ? s === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
      document.documentElement.classList.toggle('dark', dark);
    } catch (e) {}
  })();
</script>
HTML;
}
add_action( 'wp_head', 'epro_classic_color_mode_boot', 1 );

/**
 * Inline SVG icon helper (lucide outline icons + a couple of brand glyphs).
 *
 * @param string $name  Icon name.
 * @param string $class CSS classes for the <svg>.
 */
function epro_icon( $name, $class = 'size-6' ) {
	$stroke = array(
		'graduation-cap' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
		'wallet'         => '<path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>',
		'users'          => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'bar-chart'      => '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>',
		'message-square' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
		'bell'           => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
		'smartphone'     => '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/>',
		'shield-check'   => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
		'globe'          => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
		'check'          => '<path d="M20 6 9 17l-5-5"/>',
		'arrow-right'    => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'menu'           => '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
		'x'              => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
		'sun'            => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>',
		'moon'           => '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>',
		'languages'      => '<path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/>',
		'mail'           => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'phone'          => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
		'send'           => '<path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>',
		'arrow-up-right' => '<path d="M7 7h10v10"/><path d="M7 17 17 7"/>',
		'clock'          => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
	);

	$fill = array(
		'telegram' => '<path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.139-5.061 3.345-.479.329-.913.489-1.302.481-.428-.009-1.252-.242-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>',
		'github'   => '<path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23a11.5 11.5 0 0 1 3-.405c1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>',
	);

	$cls = esc_attr( $class );

	if ( isset( $stroke[ $name ] ) ) {
		return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . $cls . '" aria-hidden="true">' . $stroke[ $name ] . '</svg>';
	}
	if ( isset( $fill[ $name ] ) ) {
		return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="' . $cls . '" aria-hidden="true">' . $fill[ $name ] . '</svg>';
	}
	return '';
}

/**
 * Default primary navigation when the user has not assigned a menu yet.
 */
function epro_classic_default_nav() {
	$items = array(
		__( 'Imkoniyatlar', 'epro-classic' ) => '#features',
		__( 'Tariflar', 'epro-classic' )     => '#pricing',
		__( 'Xavfsizlik', 'epro-classic' )   => '#',
		__( 'Blog', 'epro-classic' )         => esc_url( home_url( '/blog' ) ),
		__( "Bog'lanish", 'epro-classic' )   => '#cta',
	);
	echo '<nav class="hidden md:flex items-center gap-6">';
	foreach ( $items as $label => $url ) {
		printf( '<a href="%s" class="nav-link">%s</a>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</nav>';
}

/**
 * Brand mark (gradient "E" + wordmark). Honours a custom logo if one is set.
 */
function epro_classic_brand() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	$name    = get_bloginfo( 'name' );
	$initial = $name ? mb_strtoupper( mb_substr( $name, 0, 1 ) ) : 'E';
	?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 font-display font-bold text-xl">
		<span class="epro-brand-mark size-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white"><?php echo esc_html( $initial ); ?></span>
		<span class="epro-brand-name text-neutral-900 dark:text-white"><?php echo esc_html( $name ); ?></span>
	</a>
	<?php
}
