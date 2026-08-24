<?php
/**
 * EPRO CTA banner widget.
 *
 * @package epro-elementor
 */

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_El_CTA extends EPRO_El_Base {

	public function get_name() {
		return 'epro-cta';
	}
	public function get_title() {
		return __( 'EPRO CTA', 'epro-elementor' );
	}
	public function get_keywords() {
		return array( 'epro', 'cta', 'call to action', 'banner' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'CTA', 'epro-elementor' ) ) );

		$this->add_control( 'title', array( 'label' => __( 'Sarlavha', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => "Bugun boshlasangiz, ertaga farqni ko'rasiz" ) );
		$this->add_control( 'subtitle', array( 'label' => __( 'Tavsif', 'epro-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => '14 kun bepul sinov. Kreditka kerak emas.' ) );
		$this->add_control( 'button_text', array( 'label' => __( 'Tugma matni', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bepul sinov boshlash' ) );
		$this->add_control( 'button_url', array( 'label' => __( 'Tugma havolasi', 'epro-elementor' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		echo '<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-purple-700 p-8 sm:p-16 text-center">';
		echo '<h2 class="font-display text-3xl sm:text-4xl font-bold text-white">' . esc_html( $s['title'] ) . '</h2>';
		if ( ! empty( $s['subtitle'] ) ) {
			echo '<p class="mt-4 text-lg text-primary-100 max-w-2xl mx-auto">' . esc_html( $s['subtitle'] ) . '</p>';
		}
		if ( ! empty( $s['button_text'] ) ) {
			echo '<div class="mt-8"><a href="' . esc_url( ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#' ) . '" class="inline-flex items-center justify-center gap-2 rounded-md font-medium bg-white text-primary-700 hover:bg-neutral-100 px-5 py-3 text-base">' . esc_html( $s['button_text'] ) . '</a></div>';
		}
		echo '</div>';
	}
}
