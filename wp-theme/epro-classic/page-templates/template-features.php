<?php
/**
 * Template Name: EPRO — Imkoniyatlar (batafsil)
 *
 * Full detailed features page for the EPRO marketing site.
 *
 * @package epro-classic
 */

get_header();
?>

<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

		<!-- Hero -->
		<div class="mx-auto max-w-3xl text-center">
			<span class="badge-soft"><?php esc_html_e( 'Imkoniyatlar', 'epro-classic' ); ?></span>
			<h1 class="mt-6 font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
				<?php esc_html_e( 'O\'quv markazingiz uchun barcha vositalar', 'epro-classic' ); ?>
			</h1>
			<p class="mt-6 text-lg text-neutral-600 dark:text-neutral-400">
				<?php esc_html_e( '23 ta modul, ~380 ta API endpoint, 65+ sahifa. Lekin sizga bularning hammasini bilish shart emas — interfeys o\'zi yo\'l ko\'rsatadi.', 'epro-classic' ); ?>
			</p>
		</div>

		<!-- Feature blocks -->
		<?php
		$epro_features = array(
			array(
				'icon'        => 'graduation-cap',
				'title'       => __( 'LMS — kurs va dars boshqaruvi', 'epro-classic' ),
				'description' => __( 'Klassik kursdan tortib, blended learning va onlayn-only formatlargacha. Vazifa, test, baho, sertifikat — barchasi avtomatik.', 'epro-classic' ),
				'bullets'     => array(
					__( 'Kurslar, modullar, darslar — drag & drop tartiblash', 'epro-classic' ),
					__( 'Vazifa, test, savol bank — auto-grading qo\'llab-quvvatlanadi', 'epro-classic' ),
					__( 'Video material xosting (S3/Bunny CDN)', 'epro-classic' ),
					__( 'Sertifikat PDF avtomatik generatsiya', 'epro-classic' ),
				),
			),
			array(
				'icon'        => 'wallet',
				'title'       => __( 'Kassa, qarz va to\'lov', 'epro-classic' ),
				'description' => __( 'Naqd, plastik, online to\'lov — barchasi bir kassada. O\'qituvchiga salarinda avtomatik hisoblash.', 'epro-classic' ),
				'bullets'     => array(
					__( 'Click, Payme, Uzcard integratsiyasi', 'epro-classic' ),
					__( 'Qarz xabarnomalari (Telegram + SMS)', 'epro-classic' ),
					__( 'O\'qituvchi salarinda foiz hisob-kitob', 'epro-classic' ),
					__( 'Excel/PDF hisobotlar — bir tugma', 'epro-classic' ),
				),
			),
			array(
				'icon'        => 'users',
				'title'       => __( 'Multi-tenant — har maktab o\'z olamida', 'epro-classic' ),
				'description' => __( 'Filial yoki franshiza modeli? Har biri o\'z subdomain, o\'z DB, o\'z brandingiga ega. Markaziy admin panel\'dan boshqarasiz.', 'epro-classic' ),
				'bullets'     => array(
					__( 'Subdomain per tenant (maktab1.epro.uz)', 'epro-classic' ),
					__( 'Tenant-level DB izolyatsiyasi', 'epro-classic' ),
					__( 'Markaziy super-admin panel', 'epro-classic' ),
				),
			),
			array(
				'icon'        => 'bar-chart',
				'title'       => __( 'Real-time hisobotlar', 'epro-classic' ),
				'description' => __( 'Dashboard live yangilanadi. Sotuvga aylanish, davomat, o\'qituvchi yuki — hammasi grafiklar bilan.', 'epro-classic' ),
				'bullets'     => array(
					__( '20+ widget — drag & drop layout', 'epro-classic' ),
					__( 'Custom date range, segment filter', 'epro-classic' ),
					__( 'Excel/PDF export, scheduled email', 'epro-classic' ),
				),
			),
			array(
				'icon'        => 'message-square',
				'title'       => __( 'Guruh va xabarnomalar', 'epro-classic' ),
				'description' => __( 'Slack\'simon real-time chat — guruh, kanal, DM. Ota-ona xabarnomalari, file sharing, screen capture.', 'epro-classic' ),
				'bullets'     => array(
					__( 'Guruh chati va shaxsiy xabar', 'epro-classic' ),
					__( 'Fayl, rasm, ovozli xabar', 'epro-classic' ),
					__( 'Read receipts, typing indicator', 'epro-classic' ),
				),
			),
			array(
				'icon'        => 'bell',
				'title'       => __( 'Telegram bot integratsiyasi', 'epro-classic' ),
				'description' => __( 'Ota-ona hammada Telegram bor. Davomat, baho, to\'lov haqida xabar — botda. So\'rov ham bot orqali.', 'epro-classic' ),
				'bullets'     => array(
					__( 'Real-time push xabarnoma', 'epro-classic' ),
					__( 'Mini App — login parolsiz', 'epro-classic' ),
					__( 'Bot orqali to\'lov so\'rov', 'epro-classic' ),
				),
			),
		);
		?>

		<div class="mx-auto mt-16 max-w-5xl space-y-12">
			<?php foreach ( $epro_features as $epro_feature ) : ?>
				<div class="rounded-xl bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 sm:p-8">
					<div class="flex size-12 items-center justify-center rounded-full bg-primary-50 dark:bg-primary-950 text-primary-600 dark:text-primary-400">
						<?php echo epro_icon( $epro_feature['icon'], 'size-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- epro_icon returns safe inline SVG. ?>
					</div>
					<h2 class="mt-5 font-display text-2xl font-bold text-neutral-900 dark:text-white">
						<?php echo esc_html( $epro_feature['title'] ); ?>
					</h2>
					<p class="mt-3 text-neutral-600 dark:text-neutral-400">
						<?php echo esc_html( $epro_feature['description'] ); ?>
					</p>
					<ul class="mt-4 space-y-2">
						<?php foreach ( $epro_feature['bullets'] as $epro_bullet ) : ?>
							<li class="flex items-start gap-3 text-sm text-neutral-700 dark:text-neutral-300">
								<?php echo epro_icon( 'check', 'size-5 text-primary-600 dark:text-primary-400 flex-shrink-0' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- epro_icon returns safe inline SVG. ?>
								<span><?php echo esc_html( $epro_bullet ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- CTA -->
		<div class="mx-auto mt-16 max-w-5xl text-center">
			<a href="<?php echo esc_url( epro_mod( 'cta_primary_link' ) ); ?>" class="btn btn-primary btn-lg">
				<?php esc_html_e( '14 kunlik bepul sinov', 'epro-classic' ); ?>
				<?php echo epro_icon( 'arrow-right', 'size-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- epro_icon returns safe inline SVG. ?>
			</a>
		</div>

	</div>
</section>

<?php
get_footer();
