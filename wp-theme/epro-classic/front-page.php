<?php
/**
 * Front page: the full marketing landing (hero → logos → features → pricing → CTA).
 *
 * @package epro-classic
 */

get_header();

get_template_part( 'template-parts/hero' );

if ( epro_is_on( 'show_logos' ) ) {
	get_template_part( 'template-parts/logos' );
}
if ( epro_is_on( 'show_features' ) ) {
	get_template_part( 'template-parts/features' );
}
if ( epro_is_on( 'show_pricing' ) ) {
	get_template_part( 'template-parts/pricing' );
}
if ( epro_is_on( 'show_cta' ) ) {
	get_template_part( 'template-parts/cta' );
}

get_footer();
