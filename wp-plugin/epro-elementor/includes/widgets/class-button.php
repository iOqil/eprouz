<?php
/**
 * EPRO Button widget.
 *
 * @package epro-elementor
 */

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_El_Button extends EPRO_El_Base {

	public function get_name() {
		return 'epro-button';
	}
	public function get_title() {
		return __( 'EPRO Button', 'epro-elementor' );
	}
	public function get_icon() {
		return 'eicon-button';
	}
	public function get_keywords() {
		return array( 'epro', 'button', 'tugma' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Tugma', 'epro-elementor' ) ) );

		$this->add_control( 'text', array( 'label' => __( 'Matn', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'Boshlash' ) );
		$this->add_control( 'url', array( 'label' => __( 'Havola', 'epro-elementor' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'variant', array(
			'label'   => __( 'Uslub', 'epro-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => array( 'primary' => __( 'Asosiy', 'epro-elementor' ), 'outline' => __( 'Chiziqli', 'epro-elementor' ), 'ghost' => __( 'Shaffof', 'epro-elementor' ) ),
		) );
		$this->add_control( 'size', array(
			'label'   => __( "O'lcham", 'epro-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'lg',
			'options' => array( 'sm' => 'S', 'md' => 'M', 'lg' => 'L', 'xl' => 'XL' ),
		) );
		$this->add_control( 'align', array(
			'label'   => __( 'Hizalash', 'epro-elementor' ),
			'type'    => Controls_Manager::CHOOSE,
			'default' => 'left',
			'options' => array(
				'left'   => array( 'title' => __( 'Chap', 'epro-elementor' ), 'icon' => 'eicon-text-align-left' ),
				'center' => array( 'title' => __( 'Markaz', 'epro-elementor' ), 'icon' => 'eicon-text-align-center' ),
				'right'  => array( 'title' => __( "O'ng", 'epro-elementor' ), 'icon' => 'eicon-text-align-right' ),
			),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$variants = array(
			'primary' => 'bg-primary-500 text-white hover:bg-primary-600',
			'outline' => 'border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-900',
			'ghost'   => 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800',
		);
		$sizes = array( 'sm' => 'px-3 py-1.5 text-sm', 'md' => 'px-3.5 py-2 text-sm', 'lg' => 'px-4 py-2.5 text-base', 'xl' => 'px-5 py-3 text-base' );
		$wrap  = array( 'left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right' );

		$variant = isset( $variants[ $s['variant'] ] ) ? $variants[ $s['variant'] ] : $variants['primary'];
		$size    = isset( $sizes[ $s['size'] ] ) ? $sizes[ $s['size'] ] : $sizes['lg'];
		$align   = isset( $wrap[ $s['align'] ] ) ? $wrap[ $s['align'] ] : 'text-left';

		echo '<div class="' . esc_attr( $align ) . '">';
		echo '<a href="' . esc_url( ! empty( $s['url']['url'] ) ? $s['url']['url'] : '#' ) . '" class="inline-flex items-center justify-center gap-2 rounded-md font-medium transition-colors ' . esc_attr( $variant . ' ' . $size ) . '">' . esc_html( $s['text'] ) . '</a>';
		echo '</div>';
	}
}
