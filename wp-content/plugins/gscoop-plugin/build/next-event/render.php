<?php
global $post;

$post_id = $post->ID;
if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
    $post_id = ( array_key_exists( 'postId', $_GET ) && is_numeric( $_GET['postId'] ) )  ? $_GET['postId'] : $post->ID;
}

$committee_tag = sanitize_title( wp_strip_all_tags( get_the_title( $post_id ) ) );

$next_meeting = do_shortcode( '[events_list limit="1" scope="future" tag="' . $committee_tag . '" no_results_msg="No meetings are currently scheduled."]<a href="#_EVENTURL" target="_blank">#_EVENTDATES</a>[/events_list]' );

if ( str_contains( $next_meeting, 'No meetings are currently scheduled' ) ){
    $next_meeting = "";
} else {
    $next_meeting = strip_tags( $next_meeting, '<a>' ); // leave a tags
    $next_meeting = "<p class='has-text-align-right'>Next meeting: " . $next_meeting . "</p>";
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
    <?php echo $next_meeting; ?>
</div>