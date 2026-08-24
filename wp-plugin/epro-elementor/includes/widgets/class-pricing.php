<?php
/**
 * EPRO Pricing widget (repeater of plans).
 *
 * @package epro-elementor
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_El_Pricing extends EPRO_El_Base {

	public function get_name() {
		return 'epro-pricing';
	}
	public function get_title() {
		return __( 'EPRO Pricing', 'epro-elementor' );
	}
	public function get_icon() {
		return 'eicon-price-table';
	}
	public function get_keywords() {
		return array( 'epro', 'pricing', 'tariflar', 'plans' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Tariflar', 'epro-elementor' ) ) );

		$this->add_control( 'heading', array( 'label' => __( 'Sarlavha', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'Tariflar — shaffof va adolatli' ) );
		$this->add_control( 'subheading', array( 'label' => __( 'Tavsif', 'epro-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => 'Kichik markaz uchun ham, katta tarmoq uchun ham.' ) );

		$repeater = new Repeater();
		$repeater->add_control( 'name', array( 'label' => __( 'Nom', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'Starter' ) );
		$repeater->add_control( 'desc', array( 'label' => __( 'Tavsif', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => '' ) );
		$repeater->add_control( 'price', array( 'label' => __( 'Narx', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => '290 000', 'description' => __( "Bo'sh qoldirsangiz 'Maxsus' chiqadi", 'epro-elementor' ) ) );
		$repeater->add_control( 'period', array( 'label' => __( 'Davr', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => "so'm/oy" ) );
		$repeater->add_control( 'featured', array( 'label' => __( 'Ajratib ko\'rsatish', 'epro-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => '' ) );
		$repeater->add_control( 'features', array( 'label' => __( 'Xususiyatlar (har qatorda bittadan)', 'epro-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => "100 ta o'quvchi\nTelegram bot\nEmail yordam" ) );
		$repeater->add_control( 'cta_text', array( 'label' => __( 'Tugma matni', 'epro-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => '14 kunlik sinov' ) );
		$repeater->add_control( 'cta_url', array( 'label' => __( 'Tugma havolasi', 'epro-elementor' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );

		$this->add_control( 'items', array(
			'label'       => __( 'Tariflar', 'epro-elementor' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ name }}}',
			'default'     => array(
				array( 'name' => 'Starter', 'desc' => "100 gacha o'quvchi", 'price' => '290 000', 'period' => "so'm/oy", 'featured' => '', 'features' => "100 ta o'quvchi\nTelegram bot\nEmail yordam", 'cta_text' => '14 kunlik sinov' ),
				array( 'name' => 'Pro', 'desc' => "500 gacha o'quvchi", 'price' => '690 000', 'period' => "so'm/oy", 'featured' => 'yes', 'features' => "500 ta o'quvchi\nBarcha modullar\nPriority yordam", 'cta_text' => '14 kunlik sinov' ),
				array( 'name' => 'Enterprise', 'desc' => 'Katta tarmoq', 'price' => '', 'period' => '', 'featured' => '', 'features' => "Cheklanmagan\nSLA\nDedicated manager", 'cta_text' => "Bog'lanish" ),
			),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

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

		echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">';
		if ( ! empty( $s['items'] ) && is_array( $s['items'] ) ) {
			foreach ( $s['items'] as $plan ) {
				$featured = ! empty( $plan['featured'] ) && 'yes' === $plan['featured'];
				$card     = $featured
					? 'bg-gradient-to-b from-primary-50 to-white dark:from-primary-950/50 dark:to-neutral-950 border-2 border-primary-500 shadow-xl shadow-primary-500/10'
					: 'bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800';

				echo '<div class="relative rounded-2xl p-8 flex flex-col ' . esc_attr( $card ) . '">';
				if ( $featured ) {
					echo '<span class="absolute -top-3 left-1/2 -translate-x-1/2 inline-flex items-center rounded-full bg-primary-500 text-white px-3 py-0.5 text-xs font-semibold">ENG MASHHUR</span>';
				}
				echo '<h3 class="font-display text-2xl font-bold text-neutral-900 dark:text-white">' . esc_html( $plan['name'] ) . '</h3>';
				if ( ! empty( $plan['desc'] ) ) {
					echo '<p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">' . esc_html( $plan['desc'] ) . '</p>';
				}

				echo '<div class="mt-6">';
				if ( '' !== trim( (string) $plan['price'] ) ) {
					echo '<div class="flex items-baseline gap-1"><span class="text-4xl font-display font-bold text-neutral-900 dark:text-white">' . esc_html( $plan['price'] ) . '</span>';
					if ( ! empty( $plan['period'] ) ) {
						echo '<span class="text-sm text-neutral-500">' . esc_html( $plan['period'] ) . '</span>';
					}
					echo '</div>';
				} else {
					echo '<div class="text-3xl font-display font-bold text-neutral-900 dark:text-white">Maxsus</div>';
				}
				echo '</div>';

				$features = preg_split( '/\r\n|\r|\n/', (string) $plan['features'] );
				echo '<ul class="mt-8 space-y-3 flex-1">';
				foreach ( $features as $feat ) {
					$feat = trim( $feat );
					if ( '' === $feat ) {
						continue;
					}
					echo '<li class="flex items-start gap-3 text-sm text-neutral-700 dark:text-neutral-300"><span class="text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5">' . self::icon( 'check', 'size-5' ) . '</span><span>' . esc_html( $feat ) . '</span></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				echo '</ul>';

				if ( ! empty( $plan['cta_text'] ) ) {
					$btn = $featured ? 'bg-primary-500 text-white hover:bg-primary-600' : 'border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-900';
					echo '<a href="' . esc_url( ! empty( $plan['cta_url']['url'] ) ? $plan['cta_url']['url'] : '#' ) . '" class="inline-flex items-center justify-center gap-2 rounded-md font-medium transition-colors px-4 py-2.5 text-base w-full mt-8 ' . esc_attr( $btn ) . '">' . esc_html( $plan['cta_text'] ) . '</a>';
				}
				echo '</div>';
			}
		}
		echo '</div>';
		echo '</div>';
	}
}
