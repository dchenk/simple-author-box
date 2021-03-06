<?php

/**
 * The main plugin class
 */
class Simple_Author_Box {

	private static $instance = null;
	private $options;

	function __construct() {
		$this->options = get_option( 'saboxplugin_options', [] );
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Singleton pattern
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function load_dependencies() {
		require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-helper.php';
		require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/functions.php';

		if ( is_admin() ) {
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-admin-page.php';
			require_once SIMPLE_AUTHOR_BOX_PATH . 'inc/class-simple-author-box-user-profile.php';
		}
	}

	/**
	 * Admin hooks
	 *
	 * @return void
	 */
	private function define_admin_hooks() {
		// Everything hooked here loads on both front-end & back-end
		add_filter( 'get_avatar', array( $this, 'replace_gravatar_image' ), 10, 6 );
		add_filter( 'amp_post_template_data', array( $this, 'sab_amp_css' ) ); // @since 2.0.7

		// Only load when we're in the admin panel
		if (is_admin()) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_style_and_scripts' ) );
			add_filter( 'user_contactmethods', array( $this, 'add_extra_fields' ) );
			add_filter( 'plugin_action_links_' . SIMPLE_AUTHOR_BOX_SLUG, array( $this, 'settings_link' ) );
		}
	}

	/**
	 * Override WordPress's get_avatar function.
	 * See: https://codex.wordpress.org/Plugin_API/Filter_Reference/get_avatar
	 *
	 * @return string
	 */
	public function replace_gravatar_image( $avatar, $id_or_email, $size, $default, $alt, $args ) {

		// Process the user identifier.
		$user = false;
		if ( is_numeric( $id_or_email ) ) {
			$user = get_user_by( 'id', absint( $id_or_email ) );
		} elseif ( is_string( $id_or_email ) ) {
			$user = get_user_by( 'email', $id_or_email );
		} elseif ( $id_or_email instanceof WP_User ) {
			// User Object
			$user = $id_or_email;
		} elseif ( $id_or_email instanceof WP_Post ) {
			// Post Object
			$user = get_user_by( 'id', (int) $id_or_email->post_author );
		} elseif ( $id_or_email instanceof WP_Comment && ! empty( $id_or_email->user_id)) {
			$user = get_user_by( 'id', (int) $id_or_email->user_id );
		}

		if ( ! $user || is_wp_error( $user ) ) {
			return $avatar;
		}

		$custom_profile_image = get_user_meta( $user->ID, 'sabox-profile-image', true );
		$class = array( 'avatar', 'avatar-' . (int) $args['size'], 'photo' );

		if ( ! $args['found_avatar'] || $args['force_default'] ) {
			$class[] = 'avatar-default';
		}

		if ( $args['class'] ) {
			if ( is_array( $args['class'] ) ) {
				$class = array_merge( $class, $args['class'] );
			} else {
				$class[] = $args['class'];
			}
		}

		if ( '' !== $custom_profile_image && true !== $args['force_default'] ) {
			$avatar = sprintf(
				"<img alt='%s' src='%s' srcset='%s' class='%s' height='%d' width='%d' %s>",
				esc_attr( $args['alt'] ),
				esc_url( $custom_profile_image ),
				esc_url( $custom_profile_image ) . ' 2x',
				esc_attr( join( ' ', $class ) ),
				(int) $args['height'],
				(int) $args['width'],
				$args['extra_attr']
			);
		}

		return $avatar;
	}

	private function define_public_hooks() {

		add_action( 'wp_enqueue_scripts', array( $this, 'saboxplugin_author_box_style' ), 10 );
		add_shortcode( 'simple-author-box', array( $this, 'shortcode' ) );
		add_filter( 'sabox_hide_social_icons', array( $this, 'show_social_media_icons' ), 10, 2 );

		if ( ! isset( $this->options['sab_autoinsert'] ) ) {
			add_filter( 'the_content', 'wpsabox_author_box' );
		}

		if ( isset( $this->options['sab_footer_inline_style'] ) ) {
			add_action('wp_footer', [$this, 'inline_style'], 13);
		} else {
			add_action( 'wp_head', array( $this, 'inline_style' ), 15 );
		}

	}

	public function settings_link( array $links ) {
		$links['sab'] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=simple-author-box-options' ), __( 'Settings', 'saboxplugin' ) );
		return $links;
	}

	public function admin_style_and_scripts( $hook ) {

		$suffix = '.min';
		if ( SIMPLE_AUTHOR_SCRIPT_DEBUG ) {
			$suffix = '';
		}

		// Globally loaded
		wp_enqueue_style( 'sabox-css', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox.css', [], SIMPLE_AUTHOR_BOX_VERSION );
		wp_enqueue_style( 'saboxplugin-admin-style', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox-admin-style' . $suffix . '.css', [], SIMPLE_AUTHOR_BOX_VERSION );

		// Loaded only on plugin page
		if ( 'toplevel_page_simple-author-box-options' == $hook ) {

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'jquery-ui', SIMPLE_AUTHOR_BOX_ASSETS . 'css/jquery-ui.min.css' );

			wp_enqueue_script(
				'sabox-admin-js', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sabox-admin.js', array(
					'jquery-ui-slider',
					'wp-color-picker',
				), SIMPLE_AUTHOR_BOX_VERSION, true
			);

			wp_enqueue_script(
				'sabox-plugin-install', SIMPLE_AUTHOR_BOX_ASSETS . 'js/plugin-install.js', array(
					'jquery',
					'updates',
				), '1.0.0', 'all'
			);

			// loaded only on user profile page
		} elseif ( 'profile.php' == $hook || 'user-edit.php' == $hook ) {

			wp_enqueue_style( 'saboxplugin-admin-style', SIMPLE_AUTHOR_BOX_ASSETS . 'css/sabox-admin-style' . $suffix . '.css' );

			wp_enqueue_media();
			wp_enqueue_editor();
			wp_enqueue_script( 'sabox-admin-editor-js', SIMPLE_AUTHOR_BOX_ASSETS . 'js/sabox-editor.js', array(), false, true );
			$sabox_js_helper = array();
			$social_icons    = apply_filters( 'sabox_social_icons', Simple_Author_Box_Helper::$social_icons );
			unset( $social_icons['user_email'] );
			$sabox_js_helper['socialIcons'] = $social_icons;

			wp_localize_script( 'sabox-admin-editor-js', 'SABHerlper', $sabox_js_helper );

		}

	}

	public function add_extra_fields( $extra_fields ) {
		unset( $extra_fields['aim'] );
		unset( $extra_fields['jabber'] );
		unset( $extra_fields['yim'] );
		return $extra_fields;
	}

	// Add the author box main CSS.
	public function saboxplugin_author_box_style() {

		$suffix = '.min';
		if ( SIMPLE_AUTHOR_SCRIPT_DEBUG ) {
			$suffix = '';
		}

		$sab_protocol   = is_ssl() ? 'https' : 'http';
		$sab_box_subset = get_option( 'sab_box_subset' );

		/**
		 * Check for duplicate font families, remove duplicates & re-work the font enqueue procedure
		 */
		if ( 'none' != strtolower( $sab_box_subset ) ) {
			$sab_subset = '&amp;subset=' . strtolower( $sab_box_subset );
		} else {
			$sab_subset = '&amp;subset=latin';
		}

		$sab_author_font = get_option( 'sab_box_name_font', 'None' );
		$sab_desc_font   = get_option( 'sab_box_desc_font', 'None' );
		$sab_web_font    = get_option( 'sab_box_web_font', 'None' );

		$google_fonts = array();

		if ( $sab_author_font && 'none' != strtolower( $sab_author_font ) ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_author_font ) );
		}

		if ( $sab_desc_font && 'none' != strtolower( $sab_desc_font ) ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_desc_font ) );
		}

		if ( isset( $this->options['sab_web'] ) && $sab_web_font && 'none' != strtolower( $sab_web_font ) ) {
			$google_fonts[] = str_replace( ' ', '+', esc_attr( $sab_web_font ) );
		}

		$google_fonts = apply_filters( 'sabox_google_fonts', $google_fonts );

		$google_fonts = array_unique( $google_fonts );

		if ( ! empty( $google_fonts ) ) { // let's check the array's not empty before actually loading; we want to avoid loading 'none' font-familes
			$final_google_fonts = array();

			foreach ( $google_fonts as $v ) {
				$final_google_fonts[] = $v . ':400,700,400italic,700italic';
			}

			wp_register_style( 'sab-font', $sab_protocol . '://fonts.googleapis.com/css?family=' . implode( '|', $final_google_fonts ) . $sab_subset, array(), null );

		}

		if ( ! isset( $this->options['sab_load_fa'] ) ) {
			wp_register_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
		}

		wp_register_style( 'sab-plugin', SIMPLE_AUTHOR_BOX_ASSETS . 'css/simple-author-box' . $suffix . '.css', false, SIMPLE_AUTHOR_BOX_VERSION );

		if ( ! is_single() and ! is_page() and ! is_author() and ! is_archive() ) {
			return;
		}

		if ( ! empty( $google_fonts ) ) {
			wp_enqueue_style( 'sab-font' );
		}

		if ( ! isset( $this->options['sab_load_fa'] ) ) {
			wp_enqueue_style( 'font-awesome' );
		}

		wp_enqueue_style( 'sab-plugin' );

	}

	public function inline_style() {
		if (!is_single() && !is_page() && !is_author() && !is_archive()) {
			return;
		}
		echo '<style>' . Simple_Author_Box_Helper::generate_inline_css() . '</style>';
	}

	public function shortcode( $atts ) {
		$atts = wp_parse_args($atts, ['ids' => '']);

		if ( '' != $atts['ids'] ) {
			$ids = explode( ',', $atts['ids'] );
			ob_start();
			$sabox_options = get_option( 'saboxplugin_options' );
			foreach ( $ids as $user_id ) {
				$template        = Simple_Author_Box_Helper::get_template();
				$sabox_author_id = $user_id;
				echo '<div class="sabox-plus-item">';
				include( $template );
				echo '</div>';
			}
			$html = ob_get_clean();
		} else {
			$html = wpsabox_author_box();
		}

		return $html;
	}

	public function show_social_media_icons( $return, $user ) {
		return !in_array('sab-guest-author', (array) $user->roles);
	}

	/**
	 * AMP compatibility
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	function sab_amp_css( $data ) {

		$data['post_amp_styles'] = [
			'.saboxplugin-wrap .saboxplugin-gravatar'     => [
				'float: left',
				'padding: 20px'
			],
			'.saboxplugin-wrap .saboxplugin-gravatar img' => [
				'max-width: 100px',
				'height: auto'
			],
			'.saboxplugin-wrap .saboxplugin-authorname'   => [
				'font-size: 18px',
				'line-height: 1',
				'margin: 20px 0 0 20px',
				'display: block'
			],
			'.saboxplugin-wrap .saboxplugin-authorname a' => [
				'text-decoration: none'
			],
			'.saboxplugin-wrap .saboxplugin-desc'         => [
				'display: block',
				'margin: 5px 20px'
			],
			'.saboxplugin-wrap .saboxplugin-desc a'       => [
				'text-decoration: none'
			],
			'.saboxplugin-wrap .saboxplugin-desc p'       => [
				'margin: 5px 0 12px 0',
				'font-size: ' . absint( get_option( 'sab_box_desc_size', 14 ) ) . 'px',
				'line-height: ' . absint( get_option( 'sab_box_desc_size', 14 ) + 7 ) . 'px'
			],
			'.saboxplugin-wrap .saboxplugin-web'          => [
				'margin: 0 20px 15px',
				'text-align: left'
			],
			'.saboxplugin-wrap .saboxplugin-socials'      => [
				'position: relative',
				'display: block',
				'background: #fcfcfc',
				'padding: 5px',
				'box-shadow: 0 1px 0 0 #eee inset',
				'-webkit-box-shadow: 0 1px 0 0 #eee inset',
				'-moz-box-shadow: 0 1px 0 0 #eee inset'
			],
			'.saboxplugin-wrap .saboxplugin-socials a'    => [
				'text-decoration: none',
				'box-shadow: none',
				'padding: 0',
				'margin: 0',
				'border: 0',
				'transition: opacity 0.4s',
				'-webkit-transition: opacity 0.4s',
				'-moz-transition: opacity 0.4s',
				'-o-transition: opacity 0.4s'
			],
			'.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey' => [
				'display: inline-block',
				'vertical-align: middle',
				'margin: 10px 5px',
				'color: #444'
			],
			'.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color.fa:before' => [
				'font-size: ' . get_option( 'sab_box_icon_size', 14 ) . 'px'
			],
			'.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color.fa' => [
				'width: ' . absint( get_option( 'sab_box_icon_size', 14 ) ) * 2 . 'px',
				'height: ' . absint( get_option( 'sab_box_icon_size', 14 ) ) * 2 . 'px',
				'line-height: ' . absint( get_option( 'sab_box_icon_size', 14 ) ) * 2 . 'px'
			],
			'.saboxplugin-wrap .saboxplugin-socials.sabox-colored .saboxplugin-icon-color' => [
				'color: #FFF',
				'background-color: grey',
				'margin: 5px',
				'text-align: center',
				'vertical-align: middle'
			],
			// hotfixes for some icons since we changed from sabox-icon to using fa-
			'.saboxplugin-socials .fa-googleplus:before'    => [
				"content: '\\f0d5' "
			],
			'.saboxplugin-socials .fa-sharethis:before'     => [
				"content: '\\f1e0' "
			],
			'.saboxplugin-socials .fa-stackoverflow:before' => [
				"content: '\\f16c' "
			],
			'.saboxplugin-socials .fa-stumbleUpon:before'   => [
				"content: '\\f1a4' "
			],
			'.saboxplugin-socials .fa-user_email:before'    => [
				"content: '\\f0e0' "
			],
			'.saboxplugin-socials .fa-addthis:before'       => [
				"content: '\\f0fe' "
			],
			// custom padding & margins
			'.saboxplugin-wrap'                             => [
				'margin-top: ' . absint( get_option( 'sab_box_margin_top', 0 ) ) . 'px',
				'margin-bottom: ' . absint( get_option( 'sab_box_margin_bottom', 0 ) ) . 'px',
				'padding: ' . absint( get_option( 'sab_box_padding_top_bottom', 0 ) ) . 'px ' . absint( get_option( 'sab_box_padding_left_right', 0 ) ) . 'px',
				'box-sizing: border-box',
				'border: 1px solid #EEE',
				'width: 100%',
				'clear: both',
				'overflow : hidden',
				'word-wrap: break-word',
				'position: relative'
			]
		];

		$data['font_urls'] = [
			'Font Awesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2',
			'Font Awesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
		];

		return $data;
	}

}
