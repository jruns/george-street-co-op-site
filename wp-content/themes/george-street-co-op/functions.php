<?php

// Disable autop
function remove_the_wpautop_function() {
    remove_filter( 'the_content', 'wpautop' );
    remove_filter( 'the_excerpt', 'wpautop' );
}
add_action( 'after_setup_theme', 'remove_the_wpautop_function' );

// Disable auto-generated Read More links on blog index pages
add_filter( 'the_content_more_link', '__return_empty_string' );


// Add custom styles
function gscoop_enqueue_scripts() {
    wp_enqueue_style( 'coop-style', esc_url( get_stylesheet_uri() ), array(), '1.0', 'all' );

    if ( is_page( 'contact' ) ) {
        // Add contact_form.js to Contact page
        wp_enqueue_script( 'coop-script-contact', esc_url( get_stylesheet_directory_uri() . '/assets/js/contact_form.js' ), array( 'jquery' ), null, array('strategy' => 'defer', 'in_footer' => true ) );
    }
}
add_action( 'wp_enqueue_scripts', 'gscoop_enqueue_scripts' );


// Add fields to Block Bindings API
add_action(
    'init',
    function () {
        register_block_bindings_source(
            'george-street-co-op/committee-contact-url',
            array(
                'label'              => __( 'Committee Contact URL', 'custom-bindings' ),
                'get_value_callback' => function ( array $source_args, $block_instance ) {
                    $post_id = $block_instance->context['postId'];
                    return get_the_title( $post_id );
                },
                'uses_context'       => array( 'postId' ),
            )
        );
    }
);

// Format contact url for buttons
function gscoop_format_committee_contact_button_url( $value, $source, $args ) {
    // Only process if the source and key are correct.
    if ( $source !== 'george-street-co-op/committee-contact-url' ) {
        return $value;
    }

    $value = wp_strip_all_tags( $value );

    $value = '/contact/?dest=' . urlencode( $value );

    return $value;
}
add_filter( 'block_bindings_source_value', 'gscoop_format_committee_contact_button_url', 10, 3 );


// Get Committee page events list
function gsc_get_committee_events_list( $atts ) {
    global $post;

    $committee_tag = $post->post_name . '-committee';

	$atts = shortcode_atts( array(
		'limit' => '10'
	), $atts );

    return do_shortcode( '[events_list limit="' . $atts['limit'] . '" scope="future" tag="' . $committee_tag . '" no_results_msg="No meetings are currently scheduled."]<a href="#_EVENTURL" target="_blank">#_EVENTDATES #_EVENTNAME</a>[/events_list]' );
}
add_shortcode( 'gsc_committee_events_list', 'gsc_get_committee_events_list' );

// Get next meeting for a committee
// Modifies a Title block with the committee name as the content and the 'gsc_get_next_event' class added
function gsc_filter_block_get_next_committee_event( $block_content, $block ) {

    // Check if the block is a Title block with the 'gsc_get_next_event' class added
    if ( 'core/post-title' === $block['blockName'] && array_key_exists( 'attrs', $block ) && array_key_exists( 'className', $block['attrs'] ) && 'gsc_get_next_event' === $block['attrs']['className'] ) {
        $committee_tag = sanitize_title( wp_strip_all_tags( $block_content ) );

        $next_meeting = do_shortcode( '[events_list limit="1" scope="future" tag="' . $committee_tag . '" no_results_msg="No meetings are currently scheduled."]<a href="#_EVENTURL" target="_blank">#_EVENTDATES</a>[/events_list]' );

        if ( str_contains( $next_meeting, 'No meetings are currently scheduled' ) ){
            $next_meeting = "";
        } else {
            $next_meeting = strip_tags( $next_meeting, '<a>' ); // leave a tags
            $next_meeting = "<p class='has-text-align-right'>Next meeting: " . $next_meeting . "</p>";
        }

        return $next_meeting;
    }

    return $block_content;
}
add_filter( 'render_block', 'gsc_filter_block_get_next_committee_event', 10, 2 );
/*
function gsc_get_next_committee_event( $atts ) {
    global $post;

    $committee_tag = $post->post_name . '-committee';

	$atts = shortcode_atts( array(
		'limit' => '1'
	), $atts );
return get_the_ID();
    return do_shortcode( '[events_list limit="' . $atts['limit'] . '" scope="future" tag="' . $committee_tag . '" no_results_msg="No meetings are currently scheduled."]<a href="#_EVENTURL" target="_blank">#_EVENTDATES #_EVENTNAME</a>[/events_list]' );
}
add_shortcode( 'gsc_next_committee_event', 'gsc_get_next_committee_event' );*/
