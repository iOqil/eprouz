<?php
/**
 * EPRO Logos widget (repeater of Media-Library logo images).
 *
 * @package epro-elementor
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_El_Logos extends EPRO_El_Base {

	public function get_name() {
		return 'epro-logos';
	}
	public function get_title() {
		return __( 'EPRO Logos', 'epro-elementor' );
	}
	public function get_icon() {
		return 'eicon-gallery-grid';
	}
	public function get_keywords() {
		return array( 'epro', 'logos', 'logotiplar', 'clients' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Logotiplar', 'epro-elementor' ) ) );

		$this->add_control( 'heading', array( 'label' => __( 'Sarlavha', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bizga ishongan markazlar' ) );

		$repeater = new Repeater();
		$repeater->add_control( 'image', array( 'label' => __( 'Logo', 'epro-elementor' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => '' ) ) );
		$repeater->add_control( 'name', array( 'label' => __( 'Nom', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => '' ) );

		$this->add_control( 'items', array(
			'label'       => __( 'Logolar', 'epro-elementor' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ name }}}',
			'default'     => array(
				array( 'name' => 'School 1' ),
				array( 'name' => 'EduCenter' ),
				array( 'name' => 'Bilim' ),
			),
		) );

		$this->add_control( 'grayscale', array(
			'label'        => __( 'Kulrang (hover\'da rangli)', 'epro-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$gray = 'yes' === $s['grayscale'] ? 'grayscale hover:grayscale-0 opacity-70 hover:opacity-100' : '';

		echo '<div class="py-4">';
		if ( ! empty( $s['heading'] ) ) {
			echo '<p class="text-center text-sm font-medium text-neutral-500 uppercase tracking-wider">' . esc_html( $s['heading'] ) . '</p>';
		}
		echo '<div class="mt-8 grid grid-cols-3 sm:grid-cols-6 gap-6 items-center">';
		if ( ! empty( $s['items'] ) && is_array( $s['items'] ) ) {
			foreach ( $s['items'] as $item ) {
				$url  = ! empty( $item['image']['url'] ) ? $item['image']['url'] : '';
				$name = isset( $item['name'] ) ? $item['name'] : '';
				echo '<div class="flex flex-col items-center gap-2 ' . esc_attr( $gray ) . ' transition-all">';
				if ( $url ) {
					echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $name ) . '" loading="lazy" class="h-12 w-auto max-w-[120px] object-contain" />';
				} else {
					echo '<div class="size-12 rounded-lg bg-neutral-300 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 font-bold">' . esc_html( mb_strtoupper( mb_substr( $name, 0, 2 ) ) ) . '</div>';
				}
				if ( $name ) {
					echo '<span class="text-xs text-neutral-500">' . esc_html( $name ) . '</span>';
				}
				echo '</div>';
			}
		}
		echo '</div>';
		echo '</div>';
	}
}
