<?php
/**
 * Child-Theme functions and definitions
 */
function nelson_child_scripts() {
    wp_enqueue_style( 'nelson-parent-style', get_template_directory_uri(). '/style.css' );
}

add_action('wp_enqueue_scripts', 'nelson_child_scripts');
 
?>