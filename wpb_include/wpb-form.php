<?php include plugin_dir_path( __FILE__ ) . 'js/wpb_scripts.js'; ?>
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
                value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'wpb_author', true ) ); ?>" />
        </div>
        <div>
            <label for="wpb_publisher">Publisher:</label>
            <input
                type="text"
                name="wpb_publisher"
                id="wpb_publisher"
                class="form-control"
                value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'wpb_publisher', true ) ) ?>" />
        </div>
        <div>
            <label for="wpb_date">Month, Year:</label>
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
                value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'wpb_edition', true ) ) ?>" />
        </div>
    </form>
</div>