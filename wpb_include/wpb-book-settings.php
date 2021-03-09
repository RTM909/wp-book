<?php
/**
 * Add sub menu page to the custom post type Book
 */
function wpb_add_submenu_to_custom_post_type()
{
	add_submenu_page(
		'edit.php?post_type=book',
		__('Book settings page', 'wpb'),
		__('Book settings', 'wpb'),
		'manage_options',
		'book-settings',
		'wpb_render_book_settings');
	add_action( 'admin_init', 'wpb_register_book_settings' );
}
add_action( 'admin_menu', 'wpb_add_submenu_to_custom_post_type' );

/**
 * function to register a setting and its data
 */
function wpb_register_book_settings() {
	//register settings
	register_setting( 'book-settings-group', 'currency' );
	register_setting( 'book-settings-group', 'books_per_page' );
}

/**
 * function renders the html elements on the front end for the custom settings page
 */
function wpb_render_book_settings() {
    $currency_words = array( 'INR - Indian Rupee', 'USD - United States Dollar', 'EUR - European Euro', 'GBP - British Pound Sterling' );
    $currency_symbol = array('₹', '$', '€', '£');
    $i = 0;
	?>
    <div class="wrap">
        <h2><?php _e('Book settings page', 'wpb') ?></h2>
        <?php
	        settings_errors();
	        ?>
        <section class="book_settings">
            <form name="book_settings" method="post" action="options.php">
                <?php settings_fields( 'book-settings-group' ); ?>
                <?php do_settings_sections( 'book-settings-group' ); ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th><label for="currency"><?php _e( 'Currency' ); ?></label></th>
                        <td>
                            <select name="currency" id="currency">
                                <option value="" selected disabled hidden>Select currency</option>
                                <option value="">None</option>
                                <?php
                                    $currency_in_db = esc_attr( get_option('currency') );
                                    foreach ( $currency_words as $currency ) {
                                        if ( $currency_in_db == $currency_symbol[$i] ) { ?>
                                                <option value="<?php echo $currency_symbol[$i] ?>" selected="selected"><?php echo $currency ?></option>
                                        <?php } else { ?>
	                                        <option value="<?php echo $currency_symbol[$i] ?>"><?php echo $currency  ?></option>
                                        <?php }
                                        $i += 1;
                                    } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="books_per_page"><?php _e( 'Books per page' ); ?></label></th>
                        <td><input
                                type="number"
                                name="books_per_page"
                                min="0"
                                value="<?php echo esc_attr( get_option('books_per_page') ); ?>"
                            /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </section>
    </div>
<?php }