<?php
/**
 * EPRO Hero widget.
 *
 * @package epro-elementor
 */

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_El_Hero extends EPRO_El_Base {

	public function get_name() {
		return 'epro-hero';
	}
	public function get_title() {
		return __( 'EPRO Hero', 'epro-elementor' );
	}
	public function get_keywords() {
		return array( 'epro', 'hero', 'header' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Hero', 'epro-elementor' ) ) );

		$this->add_control( 'badge', array( 'label' => 'Badge', 'type' => Controls_Manager::TEXT, 'default' => "O'quv markazlar uchun #1 SaaS" ) );
		$this->add_control( 'title', array( 'label' => __( 'Sarlavha', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => "O'quv markaz boshqaruvi" ) );
		$this->add_control( 'title_accent', array( 'label' => __( "Urg'u (gradient)", 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'yanada osonroq' ) );
		$this->add_control( 'subtitle', array( 'label' => __( 'Tavsif', 'epro-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => 'EPRO — multi-tenant SaaS platforma. O\'quvchi, o\'qituvchi, kurs, davomat, kassa — bir joyda.' ) );
		$this->add_control( 'primary_text', array( 'label' => __( 'Asosiy tugma', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => '14 kunlik bepul sinov' ) );
		$this->add_control( 'primary_url', array( 'label' => __( 'Asosiy havola', 'epro-elementor' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'secondary_text', array( 'label' => __( 'Ikkilamchi tugma', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'Imkoniyatlar haqida' ) );
		$this->add_control( 'secondary_url', array( 'label' => __( 'Ikkilamchi havola', 'epro-elementor' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'note', array( 'label' => __( 'Izoh', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => "Kreditka kerak emas • 5 daqiqada o'rnatish" ) );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		echo '<div class="text-center max-w-4xl mx-auto py-12">';

		if ( ! empty( $s['badge'] ) ) {
			echo '<span class="inline-flex items-center rounded-full bg-primary-50 dark:bg-primary-950 text-primary-700 dark:text-primary-300 px-3 py-1 text-sm font-medium mb-6"><span class="size-2 rounded-full bg-primary-500 animate-pulse mr-2"></span>' . esc_html( $s['badge'] ) . '</span>';
		}

		echo '<h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-neutral-900 dark:text-white leading-tight">' . esc_html( $s['title'] );
		if ( ! empty( $s['title_accent'] ) ) {
			echo ' <span class="bg-gradient-to-r from-primary-500 to-purple-500 bg-clip-text text-transparent">' . esc_html( $s['title_accent'] ) . '</span>';
		}
		echo '</h1>';

		if ( ! empty( $s['subtitle'] ) ) {
			echo '<p class="mt-6 text-lg sm:text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto">' . esc_html( $s['subtitle'] ) . '</p>';
		}

		echo '<div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">';
		if ( ! empty( $s['primary_text'] ) ) {
			echo '<a href="' . esc_url( ! empty( $s['primary_url']['url'] ) ? $s['primary_url']['url'] : '#' ) . '" class="inline-flex items-center justify-center gap-2 rounded-md font-medium bg-primary-500 text-white hover:bg-primary-600 px-5 py-3 text-base">' . esc_html( $s['primary_text'] ) . '</a>';
		}
		if ( ! empty( $s['secondary_text'] ) ) {
			echo '<a href="' . esc_url( ! empty( $s['secondary_url']['url'] ) ? $s['secondary_url']['url'] : '#' ) . '" class="inline-flex items-center justify-center gap-2 rounded-md font-medium border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-900 px-5 py-3 text-base">' . esc_html( $s['secondary_text'] ) . '</a>';
		}
		echo '</div>';

		if ( ! empty( $s['note'] ) ) {
			echo '<p class="mt-6 text-sm text-neutral-500">' . esc_html( $s['note'] ) . '</p>';
		}

		echo '</div>';
	}
}
