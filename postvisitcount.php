<?php

/*
Plugin Name: Post Visit Count
Plugin URI: https://profiles.wordpress.org/kinjaldalwadi/#content-plugins
Description: This plugin is used for view post visitor.
Version: 4.1.8
Author: Kinjal Dalwadi
Author URI: https://profiles.wordpress.org/kinjaldalwadi/
License: GPLv2 or later
Text Domain: postvisitcount
*/

/* THIS FUNCTION RETURS NUMBER OF VIEWS FOR A POST */
function pvc_gt_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'pvc_post_views_count', true );
    return "$count ";
}
function pvc_gt_set_post_view() {
    $key = 'pvc_post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}

add_filter( 'the_content', 'PVC_filter_the_content_in_the_main_loop', 1 );
 
function PVC_filter_the_content_in_the_main_loop( $content ) {
 
    // Check if we're inside the main loop in a single Post.
    if ( is_singular() && in_the_loop() && is_main_query() ) {
       // return $content . esc_html__( 'I’m filtering the content inside the main loop', 'wporg');
        return $content . esc_html__( pvc_gt_set_post_view(), 'wporg');
    }
 
    return $content;
}
function PVC_single_file_result( $content ) {
    if ( is_single() ) {
        $custom_contents = '<h5 style="color:green">'.pvc_gt_get_post_view().' Views'.'</h5>';
        $custom_contents .= $content;
		return $custom_contents;
    } else {
        return $content;
    }      
}
add_filter( 'the_content', 'PVC_single_file_result' );

