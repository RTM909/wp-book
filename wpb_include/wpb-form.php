<?php
    wp_enqueue_script('wpb-ajax', plugin_dir_url( __FILE__ ) . 'js/wpb-scripts.js', array('jquery'));

    global $wpdb;
    $post_id = $GLOBALS['post_id'];
    $result = $wpdb->get_row("SELECT * FROM wpb_book_meta WHERE post_id = '$post_id'");
?>
<div>
    <style scoped>
        .form-control {
            display: block;
            width: 100%;
            margin: 5px 0 10px 0;
        }
        .row {
            display: flex;
        }
        input:disabled {
            height: fit-content;
            margin-top: 5px;
            margin-right: 5px;
            width: 30px;
            background-color: grey;
            color: white;
            font-size: 14px;
            font-weight: 600;
        }
    </style>
    <form id="author-book-info" name="author-book-info" method="post" action="">
        <div>
            <label for="wpb_author">Author Name:</label>
            <input
                type="text"
                name="wpb_author"
                id="wpb_author"
                class="form-control"
                required="true"
                value="<?php if($result){echo esc_html( sanitize_text_field($result->author_name) );} ?>" />
        </div>
        <div>
            <label for="wpb_price">Price:</label>
            <div class="row">
                <input type="text" value="<?php echo esc_attr( get_option('currency') ); ?>" disabled>
                <input
                        type="number"
                        name="wpb_price"
                        id="wpb_price"
                        class="form-control"
                        required="true"
                        step="0.10"
                        value="<?php if($result){echo esc_html( sanitize_text_field($result->price) );} ?>" />
            </div>
        </div>
        <div>
            <label for="wpb_publisher">Publisher:</label>
            <input
                type="text"
                name="wpb_publisher"
                id="wpb_publisher"
                class="form-control"
                required="true"
                value="<?php if($result){echo esc_html( sanitize_text_field($result->publisher) );} ?>" />
        </div>
        <div>
            <label for="wpb_date">Publishing Month, Year:</label>
            <input
                type="month"
                name="wpb_date"
                id="wpb_date"
                class="form-control"
                value="<?php if($result){echo esc_html( sanitize_text_field($result->year) );} ?>" />
        </div>
        <div>
            <label for="wpb_edition">Edition:</label>
            <input
                type="number"
                name="wpb_edition"
                id="wpb_edition"
                class="form-control"
                step="0.1"
                required="true"
                value="<?php if($result){echo esc_attr( sanitize_text_field($result->edition) );} ?>" />
        </div>
        <div>
            <label for="wpb_url">URL:</label>
            <input
                    type="text"
                    name="wpb_url"
                    id="wpb_url"
                    class="form-control"
                    required="true"
                    value="<?php if($result){echo esc_url( sanitize_text_field($result->url), true );} ?>" />
        </div>
    </form>
</div>