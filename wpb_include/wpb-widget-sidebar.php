<?php
// Creating the widget 
class wpb_widget extends WP_Widget {
  
    function __construct() {
    parent::__construct(
    
    // Base ID of your widget
    'book-selector', 
    
    // Widget name will appear in UI
    __('Books', 'wpb_widget_domain'), 
    
    // Widget description
    array( 'description' => __( 'Display books based on selected category.', 'wpb_widget_domain' ), ) );
    }
    
    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
        
        // This is where you run the code and display the output
        ?>
        <style>
            .book-category-select {
                padding: 14.6px 10px;
                width: 69%;
                margin: 0;
                position: relative;
                bottom: 1.08px;
            }
        </style>

        <form name="book-category" id="book-category" action="">
            <select name="book-category" class="book-category-select" id="book-category">
                <?php
                    foreach (get_terms('bookcategory', array('hide_empty' => false)) as $category) {
                        if($_GET['book-category'] == $category->name) {
                            ?>
                                <option id="book=category" value="<?php echo $category->name ?>" selected="selected"><?php echo $category->name ?></option>
                            <?php
                        } else {
                        ?>
                            <option id="book=category" value="<?php echo $category->name ?>"><?php echo $category->name ?></option>
                        <?php }
                    } ?>
            </select>
            <input type="submit" value="View" />
        </form>
        <!-- The Loop -->
        <?php 
        if(isset($_GET['book-category']) == 1) {
            $selected_category = $_GET['book-category'];
            $arg = array(
                'post_type' => 'book',
                'tax_query' => array(
                    array(
                        'taxonomy'  => 'bookcategory',
                        'field'     => 'slug',
                        'terms'     => $selected_category
                    )
                )
            );
           
            $posts = get_posts($arg); 
            if($posts != null) {
                foreach ($posts as $post) {
                    ?>
                    <a href="<?php echo esc_html(sanitize_text_field(get_permalink($post))); ?>" class="url">
                        <?php echo esc_html( sanitize_text_field(get_the_title($post))); ?>
                    </a></br>
                    <?php
                }
            } else {
                echo 'No posts found.';
            }
        }
        echo $args['after_widget'];
    }
            
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wpb_widget_domain' );
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
    
// Class wpb_widget ends here
} 
 
 
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );