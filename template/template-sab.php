<?php
if (isset($sabox_options['sab_colored'])) {
	$sabox_color = 'sabox-colored';
} else {
	$sabox_color = '';
}

if (isset($sabox_options['sab_web_position']) && '0' != $sabox_options['sab_web_position']) {
	$sab_web_align = 'sab-web-position';
} else {
	$sab_web_align = '';
}

if (isset($sabox_options['sab_web_target'])) {
	$sab_web_target = '_blank';
} else {
	$sab_web_target = '_self';
}

if (isset($sabox_options['sab_web_rel'])) {
	$sab_web_rel = 'rel="nofollow"';
} else {
	$sab_web_rel = '';
}

if (get_the_author_meta('description') != '' || !isset($sabox_options['sab_no_description'])) {
	if (!isset($sabox_author_id) || !$sabox_author_id) {
		$sabox_author_id = get_the_author_meta('ID');
	}

	$authorDisplayName = esc_html(get_the_author_meta('display_name', $sabox_author_id));
	$authorPostsURL = esc_url(get_author_posts_url($sabox_author_id));
	$sab_author_link = sprintf('<a href="%s" class="vcard author"><span class="fn">About %s</span></a>', $authorPostsURL, $authorDisplayName);

	echo '<div class="saboxplugin-wrap">';

	echo '<div class="saboxplugin-gravatar">';
	$custom_profile_image = get_the_author_meta( 'sabox-profile-image', $sabox_author_id );
	if ( '' != $custom_profile_image ) {
		echo '<img src="' . esc_url( $custom_profile_image ) . '">';
	} else {
		echo get_avatar( get_the_author_meta( 'user_email', $sabox_author_id ), '100' );
	}
	echo '</div>';

	echo '<div class="saboxplugin-authorname">';
	echo apply_filters('sabox_author_html', $sab_author_link, $sabox_options, $sabox_author_id);
	echo '</div>';

	// author box description
	echo '<div class="saboxplugin-desc">';
	$description = get_the_author_meta( 'description', $sabox_author_id );
	$description = wptexturize( $description );
	$description = wpautop($description . sprintf('<br><a href="%s" class="author-all-posts">View all posts by %s &#x2192;</a>', $authorPostsURL, $authorDisplayName));
	echo wp_kses_post( $description );
	echo '</div>';

	if (is_single() || is_author() || is_archive()) {
		// Show author's website on single if enabled, or if on author.php or archive.php.
		$userURL = get_the_author_meta('user_url');
		if ($userURL != '' && (is_single() && isset($sabox_options['sab_web']) || (is_author() || is_archive()))) {
			echo '<div class="saboxplugin-web ' . esc_attr( $sab_web_align ) . '">' .
				'<a href="' . esc_url($userURL) . '" target="' . esc_attr( $sab_web_target ) . '" ' . esc_attr( $sab_web_rel ) . '>' .
				esc_html( get_the_author_meta( 'user_url', $sabox_author_id ) ) .
				'</a></div>';
		}
	}

	echo '</div>'; // end of saboxplugin-wrap div
}
