<?php
/**
 * Customizer: full live-editing support for every section of the design.
 *
 * All settings live under one "EPRO sozlamalari" panel. Content sections use
 * selective refresh (the section re-renders in place — no full reload); colour,
 * links and toggles use a normal preview refresh.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The full Customizer structure. Each section lists its fields; a `partial` key
 * (matching a file in template-parts/ and a `data-epro-partial` attribute in the
 * markup) enables selective refresh for that section's text fields.
 *
 * @return array
 */
function epro_customizer_config() {
	return array(
		'colors' => array(
			'title'  => __( 'Ranglar', 'epro-classic' ),
			'fields' => array(
				'primary_color' => array( 'label' => __( 'Brend rangi', 'epro-classic' ), 'type' => 'color', 'description' => __( 'Tugmalar, urg\'u va gradientlar shu rangdan hosil bo\'ladi.', 'epro-classic' ) ),
			),
		),
		'header' => array(
			'title'  => __( 'Header (yuqori panel)', 'epro-classic' ),
			'fields' => array(
				'header_signin_label' => array( 'label' => __( '"Kirish" tugmasi matni', 'epro-classic' ), 'type' => 'text' ),
				'header_signin_link'  => array( 'label' => __( '"Kirish" havolasi', 'epro-classic' ), 'type' => 'url' ),
				'header_cta_label'    => array( 'label' => __( '"Boshlash" tugmasi matni', 'epro-classic' ), 'type' => 'text' ),
				'header_cta_link'     => array( 'label' => __( '"Boshlash" havolasi', 'epro-classic' ), 'type' => 'text' ),
			),
		),
		'hero' => array(
			'title'   => __( 'Hero (asosiy blok)', 'epro-classic' ),
			'partial' => 'hero',
			'fields'  => array(
				'hero_badge'               => array( 'label' => __( 'Badge', 'epro-classic' ), 'type' => 'text' ),
				'hero_title1'              => array( 'label' => __( 'Sarlavha (1-qism)', 'epro-classic' ), 'type' => 'text' ),
				'hero_title2'              => array( 'label' => __( 'Sarlavha (gradient qism)', 'epro-classic' ), 'type' => 'text' ),
				'hero_subtitle'            => array( 'label' => __( 'Tavsif', 'epro-classic' ), 'type' => 'textarea' ),
				'hero_cta_primary'         => array( 'label' => __( 'Asosiy tugma matni', 'epro-classic' ), 'type' => 'text' ),
				'hero_cta_primary_link'    => array( 'label' => __( 'Asosiy tugma havolasi', 'epro-classic' ), 'type' => 'text', 'transport' => 'refresh' ),
				'hero_cta_secondary'       => array( 'label' => __( 'Ikkilamchi tugma matni', 'epro-classic' ), 'type' => 'text' ),
				'hero_cta_secondary_link'  => array( 'label' => __( 'Ikkilamchi tugma havolasi', 'epro-classic' ), 'type' => 'text', 'transport' => 'refresh' ),
				'hero_nocard'              => array( 'label' => __( 'Tugmalar ostidagi matn', 'epro-classic' ), 'type' => 'text' ),
				'hero_stat1_value'         => array( 'label' => __( 'Statistika 1 — qiymat', 'epro-classic' ), 'type' => 'text' ),
				'hero_stat1_label'         => array( 'label' => __( 'Statistika 1 — izoh', 'epro-classic' ), 'type' => 'text' ),
				'hero_stat2_value'         => array( 'label' => __( 'Statistika 2 — qiymat', 'epro-classic' ), 'type' => 'text' ),
				'hero_stat2_label'         => array( 'label' => __( 'Statistika 2 — izoh', 'epro-classic' ), 'type' => 'text' ),
				'hero_stat3_value'         => array( 'label' => __( 'Statistika 3 — qiymat', 'epro-classic' ), 'type' => 'text' ),
				'hero_stat3_label'         => array( 'label' => __( 'Statistika 3 — izoh', 'epro-classic' ), 'type' => 'text' ),
			),
		),
		'logos' => array(
			'title'   => __( 'Logotiplar', 'epro-classic' ),
			'partial' => 'logos',
			'fields'  => array(
				'show_logos'  => array(
					'label'       => __( 'Bo\'limni ko\'rsatish', 'epro-classic' ),
					'type'        => 'checkbox',
					'transport'   => 'refresh',
					'description' => sprintf(
						/* translators: %s: admin edit-screen URL for the logo post type. */
						__( 'Logolar alohida menyuda boshqariladi — rasm = Featured image (Media kutubxona). <a href="%s" target="_blank" rel="noopener"><strong>&#128064; Logotiplarni ochish &#8599;</strong></a>', 'epro-classic' ),
						esc_url( admin_url( 'edit.php?post_type=epro_logo' ) )
					),
				),
				'logos_title' => array( 'label' => __( 'Sarlavha', 'epro-classic' ), 'type' => 'text' ),
			),
		),
		'features' => array(
			'title'   => __( 'Imkoniyatlar', 'epro-classic' ),
			'partial' => 'features',
			'fields'  => array(
				'show_features'     => array(
					'label'       => __( 'Bo\'limni ko\'rsatish', 'epro-classic' ),
					'type'        => 'checkbox',
					'transport'   => 'refresh',
					'description' => sprintf(
						/* translators: %s: admin edit-screen URL for the feature post type. */
						__( 'Kartalar alohida menyuda boshqariladi — istalgancha qo\'shing. <a href="%s" target="_blank" rel="noopener"><strong>&#11088; Imkoniyatlarni ochish &#8599;</strong></a>', 'epro-classic' ),
						esc_url( admin_url( 'edit.php?post_type=epro_feature' ) )
					),
				),
				'features_title'    => array( 'label' => __( 'Sarlavha', 'epro-classic' ), 'type' => 'text' ),
				'features_subtitle' => array( 'label' => __( 'Tavsif', 'epro-classic' ), 'type' => 'textarea' ),
			),
		),
		'pricing' => array(
			'title'   => __( 'Tariflar', 'epro-classic' ),
			'partial' => 'pricing',
			'fields'  => array_merge(
				array(
					'show_pricing'     => array( 'label' => __( 'Bo\'limni ko\'rsatish', 'epro-classic' ), 'type' => 'checkbox', 'transport' => 'refresh' ),
					'pricing_title'    => array( 'label' => __( 'Sarlavha', 'epro-classic' ), 'type' => 'text' ),
					'pricing_subtitle' => array( 'label' => __( 'Tavsif', 'epro-classic' ), 'type' => 'textarea' ),
				),
				epro_plan_fields()
			),
		),
		'cta' => array(
			'title'   => __( 'CTA banner', 'epro-classic' ),
			'partial' => 'cta',
			'fields'  => array(
				'show_cta'           => array( 'label' => __( 'Bo\'limni ko\'rsatish', 'epro-classic' ), 'type' => 'checkbox', 'transport' => 'refresh' ),
				'cta_title'          => array( 'label' => __( 'Sarlavha', 'epro-classic' ), 'type' => 'text' ),
				'cta_subtitle'       => array( 'label' => __( 'Tavsif', 'epro-classic' ), 'type' => 'textarea' ),
				'cta_primary'        => array( 'label' => __( 'Asosiy tugma matni', 'epro-classic' ), 'type' => 'text' ),
				'cta_primary_link'   => array( 'label' => __( 'Asosiy tugma havolasi', 'epro-classic' ), 'type' => 'text', 'transport' => 'refresh' ),
				'cta_secondary'      => array( 'label' => __( 'Ikkilamchi tugma matni', 'epro-classic' ), 'type' => 'text' ),
				'cta_secondary_link' => array( 'label' => __( 'Ikkilamchi tugma havolasi', 'epro-classic' ), 'type' => 'text', 'transport' => 'refresh' ),
			),
		),
		'footer' => array(
			'title'  => __( 'Footer (quyi panel)', 'epro-classic' ),
			'fields' => array(
				'footer_tagline'  => array( 'label' => __( 'Tavsif', 'epro-classic' ), 'type' => 'textarea' ),
				'footer_telegram' => array( 'label' => __( 'Telegram havolasi', 'epro-classic' ), 'type' => 'url' ),
				'footer_github'   => array( 'label' => __( 'GitHub havolasi', 'epro-classic' ), 'type' => 'url' ),
				'footer_email'    => array( 'label' => __( 'Email', 'epro-classic' ), 'type' => 'text' ),
				'footer_phone'    => array( 'label' => __( 'Telefon', 'epro-classic' ), 'type' => 'text' ),
				'footer_rights'   => array( 'label' => __( 'Mualliflik matni', 'epro-classic' ), 'type' => 'text' ),
				'footer_made'     => array( 'label' => __( 'Pastki o\'ng matn', 'epro-classic' ), 'type' => 'text' ),
			),
		),
	);
}

/**
 * Build the 3 pricing-plan field groups.
 *
 * @return array
 */
function epro_plan_fields() {
	$fields = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[ "plan{$i}_name" ]     = array( 'label' => sprintf( __( 'Tarif %d — nom', 'epro-classic' ), $i ), 'type' => 'text' );
		$fields[ "plan{$i}_desc" ]     = array( 'label' => sprintf( __( 'Tarif %d — tavsif', 'epro-classic' ), $i ), 'type' => 'text' );
		$fields[ "plan{$i}_monthly" ]  = array( 'label' => sprintf( __( 'Tarif %d — oylik narx (bo\'sh = Maxsus)', 'epro-classic' ), $i ), 'type' => 'number' );
		$fields[ "plan{$i}_yearly" ]   = array( 'label' => sprintf( __( 'Tarif %d — yillik narx', 'epro-classic' ), $i ), 'type' => 'number' );
		$fields[ "plan{$i}_featured" ] = array( 'label' => sprintf( __( 'Tarif %d — ajratib ko\'rsatish', 'epro-classic' ), $i ), 'type' => 'checkbox', 'transport' => 'refresh' );
		$fields[ "plan{$i}_cta" ]      = array( 'label' => sprintf( __( 'Tarif %d — tugma matni', 'epro-classic' ), $i ), 'type' => 'text' );
		$fields[ "plan{$i}_features" ] = array( 'label' => sprintf( __( 'Tarif %d — xususiyatlar (har qatorda bittadan)', 'epro-classic' ), $i ), 'type' => 'textarea' );
	}
	return $fields;
}

/**
 * Pick the right sanitize callback for a field type.
 *
 * @param string $type Field type.
 * @return callable
 */
function epro_sanitize_for( $type ) {
	switch ( $type ) {
		case 'textarea':
			return 'sanitize_textarea_field';
		case 'url':
			return 'esc_url_raw';
		case 'color':
			return 'sanitize_hex_color';
		case 'number':
			return 'epro_sanitize_number';
		case 'checkbox':
			return 'epro_sanitize_checkbox';
		case 'select':
			return 'sanitize_key';
		default:
			return 'sanitize_text_field';
	}
}

/**
 * Sanitize an optional integer (empty allowed → "Maxsus" pricing).
 *
 * @param mixed $value Raw value.
 * @return string
 */
function epro_sanitize_number( $value ) {
	$value = trim( (string) $value );
	return '' === $value ? '' : (string) absint( $value );
}

/**
 * Sanitize a checkbox to '1' or '0'.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function epro_sanitize_checkbox( $value ) {
	return ( '1' === (string) $value || 1 === $value || true === $value ) ? '1' : '0';
}

/**
 * Register the panel, sections, settings, controls and partials.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function epro_customize_register( $wp_customize ) {
	// Live-preview the core blog name / description (used in the brand + footer).
	if ( $wp_customize->get_setting( 'blogname' ) ) {
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	}

	$wp_customize->add_panel( 'epro', array(
		'title'    => __( 'EPRO sozlamalari', 'epro-classic' ),
		'priority' => 5,
	) );

	$priority = 10;

	foreach ( epro_customizer_config() as $section_id => $section ) {
		$priority += 10;
		$wp_customize->add_section( "epro_{$section_id}", array(
			'title'    => $section['title'],
			'panel'    => 'epro',
			'priority' => $priority,
		) );

		$partial_settings = array();

		foreach ( $section['fields'] as $key => $field ) {
			$setting_id = "epro_{$key}";
			$transport  = isset( $field['transport'] )
				? $field['transport']
				: ( isset( $section['partial'] ) ? 'postMessage' : 'refresh' );

			$wp_customize->add_setting( $setting_id, array(
				'default'           => epro_default( $key ),
				'sanitize_callback' => epro_sanitize_for( $field['type'] ),
				'transport'         => $transport,
			) );

			$control_args = array(
				'label'   => $field['label'],
				'section' => "epro_{$section_id}",
				'type'    => 'color' === $field['type'] ? 'text' : $field['type'],
			);
			if ( ! empty( $field['description'] ) ) {
				$control_args['description'] = $field['description'];
			}
			if ( 'select' === $field['type'] && ! empty( $field['choices'] ) ) {
				$control_args['choices'] = $field['choices'];
			}

			if ( 'color' === $field['type'] ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting_id, array(
					'label'       => $field['label'],
					'section'     => "epro_{$section_id}",
					'description' => isset( $field['description'] ) ? $field['description'] : '',
				) ) );
			} else {
				$wp_customize->add_control( $setting_id, $control_args );
			}

			if ( 'postMessage' === $transport ) {
				$partial_settings[] = $setting_id;
			}
		}

		// Selective refresh for content sections.
		if ( isset( $section['partial'] ) && ! empty( $partial_settings ) && isset( $wp_customize->selective_refresh ) ) {
			$part = $section['partial'];
			$wp_customize->selective_refresh->add_partial( "epro_{$section_id}", array(
				'selector'            => '[data-epro-partial="' . $part . '"]',
				'container_inclusive' => true,
				'settings'            => $partial_settings,
				'render_callback'     => function () use ( $part ) {
					ob_start();
					get_template_part( 'template-parts/' . $part );
					return ob_get_clean();
				},
			) );
		}
	}
}
add_action( 'customize_register', 'epro_customize_register' );

/**
 * Live-preview the site title without a reload.
 */
function epro_customize_preview_js() {
	wp_enqueue_script(
		'epro-customize-preview',
		get_theme_file_uri( 'assets/js/customizer-preview.js' ),
		array( 'customize-preview', 'jquery' ),
		EPRO_CLASSIC_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'epro_customize_preview_js' );
