<?php
/**
 * Search form template.
 *
 * Output by get_search_form(). Styled to match the epro-classic theme.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="flex items-center gap-2" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="epro-search-field" class="sr-only"><?php esc_html_e( 'Qidirish', 'epro-classic' ); ?></label>
	<input
		type="search"
		id="epro-search-field"
		name="s"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="<?php esc_attr_e( 'Qidirish...', 'epro-classic' ); ?>"
		class="w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-950 px-4 py-2.5 text-sm text-neutral-900 dark:text-white placeholder:text-neutral-500 dark:placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500/40"
	/>
	<button type="submit" class="btn btn-primary btn-md">
		<?php esc_html_e( 'Qidirish', 'epro-classic' ); ?>
	</button>
</form>
