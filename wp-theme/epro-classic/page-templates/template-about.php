<?php
/**
 * Template Name: EPRO — Biz haqimizda
 *
 * Full "About" page for the epro-classic theme.
 *
 * @package epro-classic
 */

get_header();
?>

<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

		<!-- HERO -->
		<div class="mx-auto max-w-3xl text-center">
			<h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
				<?php esc_html_e( 'Biz haqimizda', 'epro-classic' ); ?>
			</h1>
			<p class="mt-6 text-lg sm:text-xl text-neutral-600 dark:text-neutral-400">
				<?php esc_html_e( 'EPRO — Toshkentdan, O\'zbekiston bo\'ylab. Repetitorlik markazlari uchun, ulardan bir o\'sgan jamoa tomonidan.', 'epro-classic' ); ?>
			</p>
		</div>

		<!-- TWO CARDS: Vazifamiz / Tariximiz -->
		<div class="mx-auto mt-16 grid max-w-5xl gap-6 md:grid-cols-2">
			<div class="rounded-2xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-8">
				<h2 class="font-display text-2xl font-bold text-neutral-900 dark:text-white">
					<?php esc_html_e( 'Vazifamiz', 'epro-classic' ); ?>
				</h2>
				<p class="mt-4 text-neutral-600 dark:text-neutral-400">
					<?php esc_html_e( 'O\'quv markaz egalariga texnologiya muammosini hal qilib berib, ular asl ish — sifatli ta\'lim berishga vaqt sarflashlariga imkon yaratish.', 'epro-classic' ); ?>
				</p>
			</div>

			<div class="rounded-2xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-8">
				<h2 class="font-display text-2xl font-bold text-neutral-900 dark:text-white">
					<?php esc_html_e( 'Tariximiz', 'epro-classic' ); ?>
				</h2>
				<p class="mt-4 text-neutral-600 dark:text-neutral-400">
					<?php esc_html_e( '2026-yil bahorida boshlandi. Mahalliy repetitorlik markaz egasidan eshitilgan og\'riq — har oy 3 kun Excel ko\'paytirishga ketadi — bizga bu loyihani boshlashga turtki bo\'ldi. Hozir biz multi-tenant SaaS qurganmiz, bir yil ichida 100+ markazni xizmat ko\'rsatishga shaymiz.', 'epro-classic' ); ?>
				</p>
			</div>
		</div>

		<!-- VALUES -->
		<div class="mx-auto mt-20 max-w-5xl">
			<h2 class="text-center font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white">
				<?php esc_html_e( 'Qadriyatlarimiz', 'epro-classic' ); ?>
			</h2>

			<div class="mt-12 grid gap-6 md:grid-cols-2">
				<?php
				$epro_about_values = array(
					__( 'Mahalliy birinchi — Yevropalik SaaS\'larni nusxalamaymiz, O\'zbek bozoriga ishlaydigan narsa quryapmiz', 'epro-classic' ),
					__( 'Tezlik — sahifa 1 soniyadan ortiq yuklasa, biz uyatchanmiz', 'epro-classic' ),
					__( 'Shaffoflik — narxlar ochiq, ma\'lumotlar siznilki', 'epro-classic' ),
					__( 'Yordam — har mijoz Telegram\'da bevosita biz bilan gaplasha oladi', 'epro-classic' ),
				);

				foreach ( $epro_about_values as $epro_about_value ) :
					?>
					<div class="flex items-start gap-4 rounded-2xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-6">
						<span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-950 text-primary-600 dark:text-primary-400" aria-hidden="true">
							<?php echo epro_icon( 'check', 'size-5' ); ?>
						</span>
						<p class="text-neutral-600 dark:text-neutral-400">
							<?php echo esc_html( $epro_about_value ); ?>
						</p>
					</div>
					<?php
				endforeach;
				?>
			</div>
		</div>

	</div>
</section>

<?php
get_footer();
