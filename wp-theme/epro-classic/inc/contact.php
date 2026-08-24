<?php
/**
 * Contact form: asset enqueue + AJAX submission handler.
 *
 * Enqueues the contact form script only on the contact page template,
 * localizes the admin-ajax endpoint, and processes submissions via
 * a nonce-protected, honeypot-guarded AJAX handler that emails the
 * site administrator.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue and localize the contact form script on the contact template.
 *
 * @return void
 */
function epro_contact_enqueue_assets() {
	if ( ! is_page_template( 'page-templates/template-contact.php' ) ) {
		return;
	}

	wp_enqueue_script(
		'epro-contact',
		get_theme_file_uri( 'assets/js/contact.js' ),
		array(),
		defined( 'EPRO_CLASSIC_VERSION' ) ? EPRO_CLASSIC_VERSION : '1.0.0',
		true
	);

	wp_localize_script(
		'epro-contact',
		'eproContact',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'epro_contact_enqueue_assets' );

/**
 * Handle a contact form AJAX submission.
 *
 * @return void
 */
function epro_handle_contact() {
	check_ajax_referer( 'epro_contact', 'epro_contact_nonce' );

	// Honeypot: silently accept bot submissions without sending mail.
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success( array( 'message' => 'ok' ) );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if (
		mb_strlen( $name ) < 2
		|| ! is_email( $email )
		|| mb_strlen( $phone ) < 7
		|| mb_strlen( $message ) < 10
	) {
		wp_send_json_error( array( 'message' => esc_html__( 'Maydonlarni to\'g\'ri to\'ldiring.', 'epro-classic' ) ), 422 );
	}

	$to      = get_option( 'admin_email' );
	/* translators: %s: sender name. */
	$subject = sprintf( __( '[EPRO] Yangi murojaat — %s', 'epro-classic' ), $name );

	$body  = __( 'Ism', 'epro-classic' ) . ': ' . $name . "\n";
	$body .= __( 'Email', 'epro-classic' ) . ': ' . $email . "\n";
	$body .= __( 'Telefon', 'epro-classic' ) . ': ' . $phone . "\n";
	$body .= __( 'Xabar', 'epro-classic' ) . ":\n" . $message . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	wp_mail( $to, $subject, $body, $headers );

	wp_send_json_success( array( 'message' => 'ok' ) );
}
add_action( 'wp_ajax_epro_contact', 'epro_handle_contact' );
add_action( 'wp_ajax_nopriv_epro_contact', 'epro_handle_contact' );
