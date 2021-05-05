<?php
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
  
function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;
    
    wp_add_dashboard_widget('custom_help_widget', 'Book Categories', 'custom_dashboard_help');
}
    
function custom_dashboard_help() {
    echo 'Book categories have been displayed in descending order of number of times they have been used. </br>';
    wp_list_categories( array(
        'echo'              => 1,
        'title_li'          => '',
        'style'             => '',
        'separator'         => '<br />',
        'show_option_none'  => __( 'No categories' ),
        'hierarchical'      => true,
        'orderby'           => 'count',
        'order'             => 'DESC',
        'show_count'        => true,
        'taxonomy'          => 'bookcategory',
        'number'            => 5
    ) );
}