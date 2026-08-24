<?php
/**
 * Template Name: EPRO — Xavfsizlik
 *
 * Full security page for the epro-classic theme.
 *
 * @package epro-classic
 */

get_header();

$epro_security_cards = array(
	array(
		'icon'  => 'users',
		'title' => __( 'Tenant izolyatsiyasi', 'epro-classic' ),
		'desc'  => __( 'Har maktab o\'z alohida MySQL bazasiga ega. Ma\'lumotlar boshqa tenant\'lar bilan aralashmaydi.', 'epro-classic' ),
	),
	array(
		'icon'  => 'shield-check',
		'title' => __( 'TLS + at-rest encryption', 'epro-classic' ),
		'desc'  => __( 'Barcha trafik HTTPS (Let\'s Encrypt). DB-da maxfiy maydonlar AES-256 bilan shifrlangan.', 'epro-classic' ),
	),
	array(
		'icon'  => 'clock',
		'title' => __( 'Avtomatik backuplar', 'epro-classic' ),
		'desc'  => __( 'Har kuni 02:00 UTC. 30 kun saqlanadi. Geografik replikatsiya bilan.', 'epro-classic' ),
	),
	array(
		'icon'  => 'check',
		'title' => __( '2FA va sanctum tokens', 'epro-classic' ),
		'desc'  => __( 'Google Authenticator yoki TOTP-compatible. SaaS admin uchun majburiy 2FA opsiyasi.', 'epro-classic' ),
	),
	array(
		'icon'  => 'bar-chart',
		'title' => __( 'To\'liq audit log', 'epro-classic' ),
		'desc'  => __( 'Har bir muhim amal yoziladi (kim, qachon, nimani o\'zgartirdi). 90 kun saqlanadi.', 'epro-classic' ),
	),
	array(
		'icon'  => 'globe',
		'title' => __( 'Infrastruktura', 'epro-classic' ),
		'desc'  => __( 'Hetzner DC (Germany), DDoS protection, WAF, regular security audit.', 'epro-classic' ),
	),
);
?>

<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 text-center">
		<span class="badge-soft"><?php esc_html_e( 'Enterprise-grade Security', 'epro-classic' ); ?></span>
		<h1 class="mt-6 font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
			<?php esc_html_e( 'Sizning ma\'lumotlaringiz — sizniki', 'epro-classic' ); ?>
		</h1>
		<p class="mt-6 text-lg text-neutral-600 dark:text-neutral-400">
			<?php esc_html_e( 'Biz xavfsizlikni mahsulotning birinchi xususiyati deb hisoblaymiz, oxirgi emas. Audit, encryption, backup — barchasi standart.', 'epro-classic' ); ?>
		</p>
	</div>

	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="mt-16 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ( $epro_security_cards as $epro_card ) : ?>
				<div class="rounded-xl bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6">
					<div class="size-12 rounded-lg bg-primary-100 dark:bg-primary-950 text-primary-600 dark:text-primary-400 flex items-center justify-center">
						<?php echo epro_icon( $epro_card['icon'], 'size-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- epro_icon returns safe inline SVG. ?>
					</div>
					<h3 class="mt-5 font-display text-lg font-semibold text-neutral-900 dark:text-white">
						<?php echo esc_html( $epro_card['title'] ); ?>
					</h3>
					<p class="mt-2 text-neutral-600 dark:text-neutral-400">
						<?php echo esc_html( $epro_card['desc'] ); ?>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
