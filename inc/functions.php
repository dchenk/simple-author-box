<?php

// Exit if this file is called directly
if ( !defined('ABSPATH') ) {
	exit;
}

// Add the author box to the end of your single post.
if ( !function_exists('wpsabox_author_box') ) {
	function wpsabox_author_box( $saboxmeta = null ) {
		if (apply_filters('sabox_check_if_show', is_single() || is_author() || is_archive())) {
			$sabox_options = get_option( 'saboxplugin_options' );
			$show_post_author_box = apply_filters( 'sabox_check_if_show_post_author_box', true, $sabox_options );

			ob_start();

			do_action('sabox_before_author_box', $sabox_options);

			if ($show_post_author_box) {
				include(Simple_Author_Box_Helper::get_template());
			}

			do_action('sabox_after_author_box', $sabox_options);

			$sabox = ob_get_clean();
			$return = $saboxmeta . $sabox;

			// Filter HTML being returned.
			$saboxmeta = apply_filters( 'sabox_return_html', $return, $sabox, $saboxmeta );
		}
		return $saboxmeta;
	}
}
