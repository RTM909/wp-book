<style scoped>
	.wrap {
        max-width: var(--responsive--aligndefault-width);
        margin-left: auto;
        margin-right: auto;
        font-size: 14px;
        /*display: flex;*/
	}
    .tag-wrap {
        display: flex;
        
    }
    .book-tag {
        border-radius: 20px;
        border: 2px solid darkblue;
        background-color: darkblue;
        margin-right: 10px;
        padding: 2px 9px;
        font-size: 12px;
        font-weight: 500;
        color: white;
        width: fit-content;
        display: flex;
        margin: 3px;
    }
</style>
<?php
    // includes
    include plugin_dir_path( __FILE__ ) . '/class/wpb_book_meta_db.php';

	global $wpdb;
	$post_id = get_the_ID();
    $wpb_book_meta_db = new wpb_book_meta_db;
    $result = $wpb_book_meta_db->get_by( 'post_id', $post_id );
    if($result) {
?>
<div class="wrap">
	<?php
        $date = esc_html( sanitize_text_field($result->year) );
        $month = substr($date, 5, 2);
        $year = substr($date, 0, 4);
        echo '<p>Post ID: ' . esc_html( sanitize_text_field($result->post_id) ) . ' </p> ';
        echo '<p><strong>By ' . esc_html( sanitize_text_field($result->author_name) ) . '</strong></p> ';
        echo '<p>Published by ' . esc_html( sanitize_text_field($result->publisher) ) . ' on '. date('F', mktime(0, 0, 0, $month, 0)) . ' '. $year . ' </p> ';

        echo '<p>Categories: ';
            foreach (get_the_terms($result->post_id, 'bookcategory') as $category) {
                echo $category->name . ' ';
            }
        echo '</p>';
    ?>
    <div class="tag-wrap">
        <?php 
            foreach (get_the_terms($result->post_id, 'booktag') as $tag) {
                echo '<p class="book-tag">' . $tag->name . '</p>';
            }
        ?>
    </div>
</div>
<hr>
<?php }