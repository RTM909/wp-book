<?php
    wp_enqueue_script('wpb-ajax', plugin_dir_url( __FILE__ ) . 'js/wpb-scripts.js', array('jquery'));
?>
<div>
    <style scoped>
        .form-control {
            display: block;
            width: 100%;
            margin: 5px 0 10px 0;
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
                value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'wpb_author', true ) ); ?>" />
        </div>
        <div>
            <label for="wpb_publisher">Publisher:</label>
            <input
                type="text"
                name="wpb_publisher"
                id="wpb_publisher"
                class="form-control"
                required="true"
                value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'wpb_publisher', true ) ) ?>" />
        </div>
        <div>
            <label for="wpb_date">Publishing Month, Year:</label>
            <input
                type="month"
                name="wpb_date"
                id="wpb_date"
                class="form-control"
                value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'wpb_date', true ) )?>" />
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
                value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'wpb_edition', true ) ) ?>" />
        </div>
    </form>
</div>