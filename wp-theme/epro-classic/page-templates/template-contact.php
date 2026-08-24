<?php
/**
 * Template Name: EPRO — Bog'lanish
 *
 * Full "Contact" page with a working AJAX contact form for the epro-classic theme.
 *
 * @package epro-classic
 */

get_header();

$epro_email = epro_mod( 'footer_email' );
$epro_phone = epro_mod( 'footer_phone' );
$epro_tel   = preg_replace( '/[^0-9+]/', '', (string) $epro_phone );
?>

<section class="py-20 sm:py-28">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

		<!-- HERO -->
		<div class="mx-auto max-w-2xl text-center">
			<h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
				<?php esc_html_e( 'Bog\'lanish', 'epro-classic' ); ?>
			</h1>
			<p class="mt-6 text-lg sm:text-xl text-neutral-600 dark:text-neutral-400">
				<?php esc_html_e( 'Demo so\'rov, sotuv, yordam — bir necha daqiqa ichida javob beramiz.', 'epro-classic' ); ?>
			</p>
		</div>

		<!-- LAYOUT -->
		<div class="mx-auto mt-16 grid max-w-6xl gap-10 lg:grid-cols-5">

			<!-- LEFT: channels -->
			<div class="space-y-4 lg:col-span-2">

				<!-- Telegram -->
				<a
					href="<?php echo esc_url( epro_mod( 'footer_telegram' ) ); ?>"
					class="flex items-start gap-4 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 transition hover:border-primary-300 dark:hover:border-primary-700"
				>
					<span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-400">
						<?php echo epro_icon( 'telegram', 'size-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					<span class="min-w-0">
						<span class="block text-sm font-medium text-neutral-500 dark:text-neutral-400">
							<?php esc_html_e( 'Telegram', 'epro-classic' ); ?>
						</span>
						<span class="mt-0.5 block font-semibold text-neutral-900 dark:text-white">
							<?php esc_html_e( '@EproSupportBot', 'epro-classic' ); ?>
						</span>
					</span>
				</a>

				<!-- Email -->
				<a
					href="<?php echo esc_url( 'mailto:' . antispambot( $epro_email ) ); ?>"
					class="flex items-start gap-4 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 transition hover:border-primary-300 dark:hover:border-primary-700"
				>
					<span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-400">
						<?php echo epro_icon( 'mail', 'size-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					<span class="min-w-0">
						<span class="block text-sm font-medium text-neutral-500 dark:text-neutral-400">
							<?php esc_html_e( 'Email', 'epro-classic' ); ?>
						</span>
						<span class="mt-0.5 block break-words font-semibold text-neutral-900 dark:text-white">
							<?php echo esc_html( $epro_email ); ?>
						</span>
					</span>
				</a>

				<!-- Phone -->
				<a
					href="<?php echo esc_url( 'tel:' . $epro_tel ); ?>"
					class="flex items-start gap-4 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 transition hover:border-primary-300 dark:hover:border-primary-700"
				>
					<span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-400">
						<?php echo epro_icon( 'phone', 'size-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					<span class="min-w-0">
						<span class="block text-sm font-medium text-neutral-500 dark:text-neutral-400">
							<?php esc_html_e( 'Telefon', 'epro-classic' ); ?>
						</span>
						<span class="mt-0.5 block font-semibold text-neutral-900 dark:text-white">
							<?php echo esc_html( $epro_phone ); ?>
						</span>
					</span>
				</a>

			</div>

			<!-- RIGHT: form -->
			<div class="lg:col-span-3">
				<form
					id="epro-contact-form"
					class="space-y-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-8"
					data-success-title="<?php esc_attr_e( 'Yuborildi!', 'epro-classic' ); ?>"
					data-success-body="<?php esc_attr_e( '24 soat ichida siz bilan bog\'lanamiz.', 'epro-classic' ); ?>"
					data-error-title="<?php esc_attr_e( 'Xatolik', 'epro-classic' ); ?>"
					data-error-body="<?php esc_attr_e( 'Yuborishda muammo bo\'ldi. Iltimos, Telegram orqali yozing.', 'epro-classic' ); ?>"
				>
					<?php wp_nonce_field( 'epro_contact', 'epro_contact_nonce' ); ?>

					<!-- Honeypot (anti-spam): keep hidden from users -->
					<input
						type="text"
						name="website"
						class="sr-only"
						tabindex="-1"
						autocomplete="off"
						aria-hidden="true"
					/>

					<!-- Name -->
					<div>
						<label for="epro-contact-name" class="text-sm font-medium text-neutral-900 dark:text-white">
							<?php esc_html_e( 'Ism', 'epro-classic' ); ?>
						</label>
						<input
							type="text"
							id="epro-contact-name"
							name="name"
							required
							class="mt-1.5 w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-950 px-4 py-2.5 text-sm text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500/40"
						/>
					</div>

					<!-- Email + Phone -->
					<div class="grid gap-4 sm:grid-cols-2">
						<div>
							<label for="epro-contact-email" class="text-sm font-medium text-neutral-900 dark:text-white">
								<?php esc_html_e( 'Email', 'epro-classic' ); ?>
							</label>
							<input
								type="email"
								id="epro-contact-email"
								name="email"
								required
								class="mt-1.5 w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-950 px-4 py-2.5 text-sm text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500/40"
							/>
						</div>
						<div>
							<label for="epro-contact-phone" class="text-sm font-medium text-neutral-900 dark:text-white">
								<?php esc_html_e( 'Telefon', 'epro-classic' ); ?>
							</label>
							<input
								type="tel"
								id="epro-contact-phone"
								name="phone"
								required
								placeholder="<?php esc_attr_e( '+998 ...', 'epro-classic' ); ?>"
								class="mt-1.5 w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-950 px-4 py-2.5 text-sm text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500/40"
							/>
						</div>
					</div>

					<!-- Message -->
					<div>
						<label for="epro-contact-message" class="text-sm font-medium text-neutral-900 dark:text-white">
							<?php esc_html_e( 'Xabar (markaz haqida, qanday yordam kerak)', 'epro-classic' ); ?>
						</label>
						<textarea
							id="epro-contact-message"
							name="message"
							rows="5"
							required
							class="mt-1.5 w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-950 px-4 py-2.5 text-sm text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500/40"
						></textarea>
					</div>

					<!-- Status region -->
					<p id="epro-contact-status" role="status" aria-live="polite" class="hidden text-sm"></p>

					<!-- Submit -->
					<button type="submit" class="btn btn-primary btn-lg w-full">
						<?php esc_html_e( 'Yuborish', 'epro-classic' ); ?>
						<?php echo epro_icon( 'send', 'size-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>

					<!-- Note -->
					<p class="text-sm text-neutral-600 dark:text-neutral-400">
						<?php esc_html_e( 'Yuborish orqali siz maxfiylik siyosatiga rozilik bildirasiz.', 'epro-classic' ); ?>
					</p>
				</form>
			</div>

		</div>
	</div>
</section>

<?php
get_footer();
