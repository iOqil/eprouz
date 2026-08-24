<?php
/**
 * Theme options: defaults, the get-with-default reader, and the brand-color
 * palette generator. Every editable string the templates render flows through
 * here, so the Customizer and the templates always share one source of truth.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default values for every Customizer setting (key without the `epro_` prefix).
 *
 * @return array<string,string>
 */
function epro_defaults() {
	return array(
		// Colors.
		'primary_color' => '#6366f1',

		// Section visibility.
		'show_logos'    => '1',
		'show_features' => '1',
		'show_pricing'  => '1',
		'show_cta'      => '1',

		// Header.
		'header_signin_label' => "Kirish",
		'header_signin_link'  => '#',
		'header_cta_label'    => "Boshlash",
		'header_cta_link'     => '#cta',

		// Hero.
		'hero_badge'              => "O'quv markazlar uchun #1 SaaS",
		'hero_title1'             => "O'quv markaz boshqaruvi",
		'hero_title2'             => "yanada osonroq",
		'hero_subtitle'          => "EPRO — multi-tenant SaaS platforma. O'quvchi, o'qituvchi, kurs, davomat, baholash, kassa va real-time chat — bir joyda.",
		'hero_cta_primary'       => "14 kunlik bepul sinov",
		'hero_cta_primary_link'  => '#cta',
		'hero_cta_secondary'     => "Imkoniyatlar haqida",
		'hero_cta_secondary_link'=> '#features',
		'hero_nocard'            => "Kreditka kerak emas • 5 daqiqada o'rnatish",
		'hero_stat1_value'       => '23+',
		'hero_stat1_label'       => 'Modul',
		'hero_stat2_value'       => '99.9%',
		'hero_stat2_label'       => 'Uptime SLA',
		'hero_stat3_value'       => '< 1s',
		'hero_stat3_label'       => 'Sahifa yuklash',

		// Logos.
		'logos_title'   => 'Bizga ishongan markazlar',
		'logo1_name'    => 'School 1',  'logo1_initial' => 'S1',
		'logo2_name'    => 'EduCenter', 'logo2_initial' => 'EC',
		'logo3_name'    => 'Bilim',     'logo3_initial' => 'B',
		'logo4_name'    => 'Maktab+',   'logo4_initial' => 'M+',
		'logo5_name'    => 'TechAcademy','logo5_initial'=> 'TA',
		'logo6_name'    => 'LangPro',   'logo6_initial' => 'LP',

		// Features.
		'features_title'    => 'Bitta platforma — hammasi ichida',
		'features_subtitle' => "O'quv markaz uchun zarur barcha modullar. Excel'lardan, qog'ozlardan va alohida tizimlardan voz keching.",
		'feature1_icon'  => 'graduation-cap', 'feature1_title' => 'LMS — kurs va dars',        'feature1_desc' => "Kurslar, modullar, darslar, vazifalar, testlar, video, materiallar — bir joyda.",
		'feature2_icon'  => 'wallet',         'feature2_title' => "Kassa va to'lovlar",         'feature2_desc' => "To'lov qabul, qarz boshqaruvi, salarinda hisobot. Click va Payme integratsiyasi tayyor.",
		'feature3_icon'  => 'users',          'feature3_title' => 'Multi-tenant arxitektura',   'feature3_desc' => "Har bir maktab o'z ma'lumotlar bazasi va subdomain'iga ega. To'liq izolyatsiya, GDPR.",
		'feature4_icon'  => 'bar-chart',      'feature4_title' => 'Real-time hisobotlar',       'feature4_desc' => "O'qituvchi samaradorligi, kurs aktivligi, to'lov tahlili. Dashboard live yangilanadi.",
		'feature5_icon'  => 'message-square', 'feature5_title' => 'Real-time chat',             'feature5_desc' => "Guruh ichi muloqot, ota-ona xabarnomalari, file sharing. WebSocket asosida.",
		'feature6_icon'  => 'bell',           'feature6_title' => 'Telegram bot',               'feature6_desc' => "Davomat, baho, to'lov haqida ota-onaga avtomatik xabar. Bot orqali so'rov ham.",
		'feature7_icon'  => 'smartphone',     'feature7_title' => 'Mobile PWA',                 'feature7_desc' => "Android/iOS native ilova kerak emas. Web app, lekin ilova tajribasi.",
		'feature8_icon'  => 'shield-check',   'feature8_title' => 'Korporativ xavfsizlik',      'feature8_desc' => "2FA, audit log, RBAC, har kunlik backuplar, GDPR/Cookie Compliance.",
		'feature9_icon'  => 'globe',          'feature9_title' => "Ko'p tilli",                 'feature9_desc' => "O'zbek, rus, ingliz, qoraqalpoq. Mijozlaringiz qaysi tilda gapirishni xohlasa — shu tilda.",

		// Pricing.
		'pricing_title'    => 'Tariflar — shaffof va adolatli',
		'pricing_subtitle' => "Kichik markaz uchun ham, katta tarmoq uchun ham. To'lov sizning o'sishingiz bilan.",
		'plan1_name'     => 'Starter',
		'plan1_desc'     => "Kichik markaz, 100 gacha o'quvchi",
		'plan1_monthly'  => '290000',
		'plan1_yearly'   => '2900000',
		'plan1_featured' => '0',
		'plan1_cta'      => '14 kunlik sinov',
		'plan1_features' => "100 ta o'quvchi\n5 ta o'qituvchi\nLMS + Kassa + Davomat\nTelegram bot\nEmail yordam",
		'plan2_name'     => 'Pro',
		'plan2_desc'     => "O'rta markaz, 500 gacha o'quvchi",
		'plan2_monthly'  => '690000',
		'plan2_yearly'   => '6900000',
		'plan2_featured' => '1',
		'plan2_cta'      => '14 kunlik sinov',
		'plan2_features' => "500 ta o'quvchi\n30 ta o'qituvchi\nBarcha modullar (chat, gamification)\nReal-time hisobotlar\nCustom branding\nPriority Telegram + telefon yordam",
		'plan3_name'     => 'Enterprise',
		'plan3_desc'     => 'Katta tarmoq yoki maxsus talab',
		'plan3_monthly'  => '',
		'plan3_yearly'   => '',
		'plan3_featured' => '0',
		'plan3_cta'      => "Sotuv bilan bog'lanish",
		'plan3_features' => "Cheklanmagan o'quvchi\nCheklanmagan o'qituvchi\nMaxsus integratsiya\nSLA va alohida server\nDedicated account manager",

		// CTA.
		'cta_title'          => "Bugun boshlasangiz, ertaga farqni ko'rasiz",
		'cta_subtitle'       => '14 kun bepul sinov. Kreditka kerak emas. Istalgan paytda bekor qilish mumkin.',
		'cta_primary'        => 'Bepul sinov boshlash',
		'cta_primary_link'   => '/contact',
		'cta_secondary'      => "Tariflarni ko'rish",
		'cta_secondary_link' => '#pricing',

		// Footer.
		'footer_tagline'  => "O'quv markazlar uchun zamonaviy boshqaruv tizimi. Toshkentda 2026'da yaratildi.",
		'footer_telegram' => 'https://t.me/EproSupportBot',
		'footer_github'   => 'https://github.com/iOqil',
		'footer_email'    => 'hello@epro.uz',
		'footer_phone'    => '+998 (XX) XXX-XX-XX',
		'footer_rights'   => 'Barcha huquqlar himoyalangan.',
		'footer_made'     => "O'zbekistonda yaratildi",
	);
}

/**
 * Default for a single key.
 *
 * @param string $key Setting key (no prefix).
 * @return string
 */
function epro_default( $key ) {
	$d = epro_defaults();
	return isset( $d[ $key ] ) ? $d[ $key ] : '';
}

/**
 * Read a theme mod, falling back to the registered default.
 *
 * @param string $key Setting key (no prefix).
 * @return string
 */
function epro_mod( $key ) {
	return get_theme_mod( 'epro_' . $key, epro_default( $key ) );
}

/**
 * Boolean reader for visibility toggles.
 *
 * @param string $key Setting key (no prefix).
 * @return bool
 */
function epro_is_on( $key ) {
	return '1' === (string) epro_mod( $key );
}

/**
 * Icons available for the feature cards (Customizer select choices).
 *
 * @return array<string,string>
 */
function epro_icon_choices() {
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
		'clock'          => 'Clock',
		'mail'           => 'Mail',
		'phone'          => 'Phone',
		'send'           => 'Send',
	);
}

/* -------------------------------------------------------------------------- *
 * Brand-colour palette generation
 * -------------------------------------------------------------------------- */

/**
 * The canonical Tailwind "indigo" ramp — used verbatim while the brand colour
 * is left at its default, so the out-of-the-box look stays pixel-perfect.
 *
 * @return array<int,string>
 */
function epro_indigo_palette() {
	return array(
		50 => '#eef2ff', 100 => '#e0e7ff', 200 => '#c7d2fe', 300 => '#a5b4fc', 400 => '#818cf8',
		500 => '#6366f1', 600 => '#4f46e5', 700 => '#4338ca', 800 => '#3730a3', 900 => '#312e81', 950 => '#1e1b4b',
	);
}

/**
 * Mix two hex colours.
 *
 * @param string $hex    Base colour.
 * @param string $with   Colour to mix toward (#ffffff or #000000).
 * @param float  $weight Amount of $with, 0..1.
 * @return string Hex colour.
 */
function epro_mix_hex( $hex, $with, $weight ) {
	$a = epro_hex_to_rgb( $hex );
	$b = epro_hex_to_rgb( $with );
	if ( ! $a || ! $b ) {
		return $hex;
	}
	$weight = max( 0, min( 1, $weight ) );
	$r = (int) round( $a[0] + ( $b[0] - $a[0] ) * $weight );
	$g = (int) round( $a[1] + ( $b[1] - $a[1] ) * $weight );
	$bl = (int) round( $a[2] + ( $b[2] - $a[2] ) * $weight );
	return sprintf( '#%02x%02x%02x', $r, $g, $bl );
}

/**
 * Convert #rrggbb (or #rgb) to an [r,g,b] array.
 *
 * @param string $hex Colour.
 * @return array{0:int,1:int,2:int}|null
 */
function epro_hex_to_rgb( $hex ) {
	$hex = ltrim( (string) $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( 6 !== strlen( $hex ) || ! ctype_xdigit( $hex ) ) {
		return null;
	}
	return array(
		hexdec( substr( $hex, 0, 2 ) ),
		hexdec( substr( $hex, 2, 2 ) ),
		hexdec( substr( $hex, 4, 2 ) ),
	);
}

/**
 * Build the active primary palette: indigo by default, or a generated ramp from
 * the chosen brand colour.
 *
 * @return array<int,string>
 */
function epro_primary_palette() {
	$color = epro_mod( 'primary_color' );
	if ( ! $color || '#6366f1' === strtolower( $color ) ) {
		return epro_indigo_palette();
	}
	$w = '#ffffff';
	$k = '#000000';
	return array(
		50  => epro_mix_hex( $color, $w, 0.92 ),
		100 => epro_mix_hex( $color, $w, 0.84 ),
		200 => epro_mix_hex( $color, $w, 0.70 ),
		300 => epro_mix_hex( $color, $w, 0.52 ),
		400 => epro_mix_hex( $color, $w, 0.28 ),
		500 => $color,
		600 => epro_mix_hex( $color, $k, 0.12 ),
		700 => epro_mix_hex( $color, $k, 0.26 ),
		800 => epro_mix_hex( $color, $k, 0.40 ),
		900 => epro_mix_hex( $color, $k, 0.52 ),
		950 => epro_mix_hex( $color, $k, 0.72 ),
	);
}
