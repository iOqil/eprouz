<?php
/**
 * Template Name: EPRO — Tariflar
 *
 * Full pricing page: hero, reusable pricing table, and a native FAQ accordion.
 *
 * @package epro-classic
 */

get_header();
?>

<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="text-center max-w-2xl mx-auto">
			<h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
				<?php esc_html_e( "Sizning markazingiz uchun to'g'ri reja", 'epro-classic' ); ?>
			</h1>
			<p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
				<?php esc_html_e( "14 kunlik bepul sinov. Kreditka kerak emas. Istalgan paytda boshqa rejaga o'tish mumkin.", 'epro-classic' ); ?>
			</p>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/pricing' ); ?>

<section class="py-20">
	<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
		<h2 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white text-center">
			<?php esc_html_e( 'Tez-tez beriladigan savollar', 'epro-classic' ); ?>
		</h2>

		<div class="mt-12">
			<?php
			$faqs = array(
				array(
					'q' => __( 'Sinov haqiqatan bepulmi?', 'epro-classic' ),
					'a' => __( "Ha. Kreditka kerak emas, hech qanday yashirin to'lov yo'q. Sinov tugagach to'lamasangiz akkaunt o'chiriladi (lekin ma'lumotlar 30 kun saqlanadi).", 'epro-classic' ),
				),
				array(
					'q' => __( "To'lovlar qanday qabul qilinadi?", 'epro-classic' ),
					'a' => __( "Click, Payme, Uzcard, Humo plastik kartalari, va bank o'tkazma. Yuridik shaxslar uchun rasmiy shartnoma va invoys beramiz.", 'epro-classic' ),
				),
				array(
					'q' => __( "Ma'lumotlarim qayerda saqlanadi?", 'epro-classic' ),
					'a' => __( "Yevropadagi serverda (Germany), kunlik backup'lar bilan. Server O'zbekistonda joylashishini xohlasangiz Enterprise rejada bu mumkin.", 'epro-classic' ),
				),
				array(
					'q' => __( "Bir rejadan boshqasiga o'tish mumkinmi?", 'epro-classic' ),
					'a' => __( "Ha, istalgan paytda yuqoriroq yoki pastroq rejaga o'tish mumkin. To'lov pro-rata hisoblanadi.", 'epro-classic' ),
				),
				array(
					'q' => __( "Ma'lumotlarni export qilsa bo'ladimi?", 'epro-classic' ),
					'a' => __( "Ha. Excel, PDF, JSON formatlarida to'liq ma'lumotni istalgan paytda yuklab olishingiz mumkin. Vendor lock-in yo'q.", 'epro-classic' ),
				),
			);

			foreach ( $faqs as $faq ) :
				?>
				<details class="group border-b border-neutral-200 dark:border-neutral-800 py-4">
					<summary class="flex justify-between items-center cursor-pointer font-medium text-neutral-900 dark:text-white list-none">
						<?php echo esc_html( $faq['q'] ); ?>
						<span class="transition-transform group-open:rotate-180"><?php echo epro_icon( 'arrow-right', 'size-4 rotate-90 text-neutral-400' ); ?></span>
					</summary>
					<p class="mt-3 text-sm text-neutral-600 dark:text-neutral-400"><?php echo esc_html( $faq['a'] ); ?></p>
				</details>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<?php
get_footer();
