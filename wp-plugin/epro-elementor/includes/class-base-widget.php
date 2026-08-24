<?php
/**
 * Base class for EPRO Elementor widgets: shared category + inline-SVG icon set
 * (lucide) so feature/preset widgets match the theme exactly.
 *
 * @package epro-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class EPRO_El_Base extends \Elementor\Widget_Base {

	/**
	 * All EPRO widgets live under the "EPRO" category.
	 *
	 * @return string[]
	 */
	public function get_categories() {
		return array( 'epro' );
	}

	/**
	 * Editor panel icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-star';
	}

	/**
	 * Icon name => label, for SELECT controls.
	 *
	 * @return array<string,string>
	 */
	public static function icon_options() {
		return array(
			'graduation-cap' => 'Graduation cap',
			'wallet'         => 'Wallet',
			'users'          => 'Users',
			'bar-chart'      => 'Bar chart',
			'message-square' => 'Message',
			'bell'           => 'Bell',
			'smartphone'     => 'Smartphone',
			'shield-check'   => 'Shield',
			'globe'          => 'Globe',
			'check'          => 'Check',
			'clock'          => 'Clock',
			'mail'           => 'Mail',
			'phone'          => 'Phone',
			'rocket'         => 'Rocket',
			'sparkles'       => 'Sparkles',
		);
	}

	/**
	 * Return an inline SVG (lucide) for a name.
	 *
	 * @param string $name  Icon name.
	 * @param string $class CSS classes.
	 * @return string
	 */
	public static function icon( $name, $class = 'size-6' ) {
		$paths = array(
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
			'clock'          => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
			'mail'           => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
			'phone'          => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
			'rocket'         => '<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91 0z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>',
			'sparkles'       => '<path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3z"/>',
		);
		if ( ! isset( $paths[ $name ] ) ) {
			$name = 'check';
		}
		return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="' . esc_attr( $class ) . '" aria-hidden="true">' . $paths[ $name ] . '</svg>';
	}

	/**
	 * Tailwind alignment class from an Elementor align value.
	 *
	 * @param string $align left|center|right.
	 * @return string
	 */
	protected function align_class( $align ) {
		$map = array( 'left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right' );
		return isset( $map[ $align ] ) ? $map[ $align ] : 'text-left';
	}
}
