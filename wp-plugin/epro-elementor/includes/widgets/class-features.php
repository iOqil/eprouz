<?php
/**
 * EPRO Features grid widget (repeater of icon + title + description cards).
 *
 * @package epro-elementor
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_El_Features extends EPRO_El_Base {

	public function get_name() {
		return 'epro-features';
	}
	public function get_title() {
		return __( 'EPRO Features', 'epro-elementor' );
	}
	public function get_keywords() {
		return array( 'epro', 'features', 'imkoniyatlar', 'grid' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Imkoniyatlar', 'epro-elementor' ) ) );

		$this->add_control( 'heading', array( 'label' => __( 'Sarlavha', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'Bitta platforma — hammasi ichida' ) );
		$this->add_control( 'subheading', array( 'label' => __( 'Tavsif', 'epro-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => "O'quv markaz uchun zarur barcha modullar." ) );
		$this->add_control( 'columns', array(
			'label'   => __( 'Ustunlar', 'epro-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '3',
			'options' => array( '2' => '2', '3' => '3', '4' => '4' ),
		) );

		$repeater = new Repeater();
		$repeater->add_control( 'icon', array(
			'label'   => __( 'Ikona', 'epro-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'graduation-cap',
			'options' => self::icon_options(),
		) );
		$repeater->add_control( 'title', array( 'label' => __( 'Sarlavha', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Imkoniyat', 'epro-elementor' ) ) );
		$repeater->add_control( 'desc', array( 'label' => __( 'Tavsif', 'epro-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => '' ) );

		$this->add_control( 'items', array(
			'label'       => __( 'Kartalar', 'epro-elementor' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => array(
				array( 'icon' => 'graduation-cap', 'title' => 'LMS — kurs va dars', 'desc' => 'Kurslar, modullar, darslar, testlar, video — bir joyda.' ),
				array( 'icon' => 'wallet', 'title' => "Kassa va to'lovlar", 'desc' => "To'lov qabul, qarz boshqaruvi. Click va Payme tayyor." ),
				array( 'icon' => 'users', 'title' => 'Multi-tenant', 'desc' => "Har maktab o'z bazasi va subdomainiga ega." ),
			),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$cols = in_array( $s['columns'], array( '2', '3', '4' ), true ) ? $s['columns'] : '3';
		$grid = array( '2' => 'md:grid-cols-2', '3' => 'md:grid-cols-2 lg:grid-cols-3', '4' => 'md:grid-cols-2 lg:grid-cols-4' );

		echo '<div class="py-4">';
		if ( ! empty( $s['heading'] ) || ! empty( $s['subheading'] ) ) {
			echo '<div class="text-center max-w-2xl mx-auto mb-12">';
			if ( ! empty( $s['heading'] ) ) {
				echo '<h2 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white">' . esc_html( $s['heading'] ) . '</h2>';
			}
			if ( ! empty( $s['subheading'] ) ) {
				echo '<p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">' . esc_html( $s['subheading'] ) . '</p>';
			}
			echo '</div>';
		}

		echo '<div class="grid grid-cols-1 ' . esc_attr( $grid[ $cols ] ) . ' gap-6">';
		if ( ! empty( $s['items'] ) && is_array( $s['items'] ) ) {
			foreach ( $s['items'] as $item ) {
				echo '<div class="group p-6 rounded-xl bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-lg transition-all">';
				echo '<div class="size-12 rounded-lg bg-primary-100 dark:bg-primary-950 flex items-center justify-center text-primary-600 dark:text-primary-400 group-hover:scale-110 transition-transform">';
				echo self::icon( isset( $item['icon'] ) ? $item['icon'] : 'check', 'size-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</div>';
				echo '<h3 class="mt-4 font-display font-semibold text-lg text-neutral-900 dark:text-white">' . esc_html( $item['title'] ) . '</h3>';
				if ( ! empty( $item['desc'] ) ) {
					echo '<p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">' . esc_html( $item['desc'] ) . '</p>';
				}
				echo '</div>';
			}
		}
		echo '</div>';
		echo '</div>';
	}
}
