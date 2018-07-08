<?php

/**
 *
 */
class Simple_Author_Box_Helper {

	public static $fonts = array();

	static $social_icons = array(
		'addthis'       => 'Add This',
		'behance'       => 'Behance',
		'delicious'     => 'Delicious',
		'deviantart'    => 'Deviantart',
		'digg'          => 'Digg',
		'dribbble'      => 'Dribbble',
		'facebook'      => 'Facebook',
		'flickr'        => 'Flickr',
		'github'        => 'Github',
		'google'        => 'Google',
		'googleplus'    => 'Google Plus',
		'html5'         => 'Html5',
		'instagram'     => 'Instagram',
		'linkedin'      => 'Linkedin',
		'pinterest'     => 'Pinterest',
		'reddit'        => 'Reddit',
		'rss'           => 'Rss',
		'sharethis'     => 'Sharethis',
		'skype'         => 'Skype',
		'soundcloud'    => 'Soundcloud',
		'spotify'       => 'Spotify',
		'stackoverflow' => 'Stackoverflow',
		'steam'         => 'Steam',
		'stumbleUpon'   => 'StumbleUpon',
		'tumblr'        => 'Tumblr',
		'twitter'       => 'Twitter',
		'vimeo'         => 'Vimeo',
		'windows'       => 'Windows',
		'wordpress'     => 'Wordpress',
		'yahoo'         => 'Yahoo',
		'youtube'       => 'Youtube',
		'xing'          => 'Xing',
		'mixcloud'      => 'MixCloud',
		'goodreads'     => 'Goodreads',
		'twitch'        => 'Twitch',
		'vk'            => 'VK',
		'medium'        => 'Medium',
		'quora'         => 'Quora',
		'meetup'        => 'Meetup',
		'user_email'    => 'Email',
		'snapchat'      => 'Snapchat',
		'500px'         => '500px',
	);

	public static function get_sabox_social_icon( $url, $icon_name ) {

		$options = get_option( 'saboxplugin_options' );

		if ( isset( $options['sab_link_target'] ) && '0' != $options['sab_link_target'] ) {
			$sabox_blank = '_blank';
		} else {
			$sabox_blank = '_self';
		}

		if ( isset( $options['sab_colored'] ) && '0' != $options['sab_colored'] ) {
			$sab_color = 'saboxplugin-icon-color';
		} else {
			$sab_color = 'saboxplugin-icon-grey';
		}

		return '<a target="' . esc_attr( $sabox_blank ) . '" href="' . esc_url( $url ) . '" rel="nofollow"><span class="' . esc_attr( $sab_color ) . ' fa fa-' . esc_attr( $icon_name ) . '"></span></a>';

	}

	public static function get_user_social_links( $userd_id, $show_email = false ) {

		$social_icons = apply_filters( 'sabox_social_icons', Simple_Author_Box_Helper::$social_icons );
		$social_links = get_user_meta( $userd_id, 'sabox_social_links', true );

		if ( ! is_array( $social_links ) ) {
			$social_links = array();
		}

		if ( $show_email ) {
			$social_links['user_email'] = get_the_author_meta( 'user_email', $userd_id );
		}

		return $social_links;

	}

	public static function get_google_font_subsets() {
		return array(
			'none'         => 'None',
			'latin'        => 'Latin',
			'latin-ext'    => 'Latin Extended',
			'cyrillic'     => 'Cyrillic',
			'cyrillic-ext' => 'Cyrillic Extended',
			'devanagari'   => 'Devanagari',
			'greek'        => 'Greek',
			'greek-ext'    => 'Greek Extended',
			'vietnamese'   => 'Vietnamese',
			'khmer'        => 'Khmer',
		);
	}

	public static function get_google_fonts() {
		$fonts = array(
			'None',
			'ABeeZee',
			'Abel',
			'Abril Fatface',
			'Aclonica',
			'Acme',
			'Actor',
			'Adamina',
			'Advent Pro',
			'Aguafina Script',
			'Akronim',
			'Aladin',
			'Aldrich',
			'Alef',
			'Alegreya',
			'Alegreya SC',
			'Alegreya Sans',
			'Alegreya Sans SC',
			'Alex Brush',
			'Alfa Slab One',
			'Alice',
			'Alike',
			'Alike Angular',
			'Allan',
			'Allerta',
			'Allerta Stencil',
			'Allura',
			'Almendra',
			'Almendra Display',
			'Almendra SC',
			'Amarante',
			'Amaranth',
			'Amatic SC',
			'Amethysta',
			'Anaheim',
			'Andada',
			'Andika',
			'Angkor',
			'Annie Use Your Telescope',
			'Anonymous Pro',
			'Antic',
			'Antic Didone',
			'Antic Slab',
			'Anton',
			'Arapey',
			'Arbutus',
			'Arbutus Slab',
			'Architects Daughter',
			'Archivo Black',
			'Archivo Narrow',
			'Arimo',
			'Arizonia',
			'Armata',
			'Artifika',
			'Arvo',
			'Asap',
			'Asset',
			'Astloch',
			'Asul',
			'Atomic Age',
			'Aubrey',
			'Audiowide',
			'Autour One',
			'Average',
			'Average Sans',
			'Averia Gruesa Libre',
			'Averia Libre',
			'Averia Sans Libre',
			'Averia Serif Libre',
			'Bad Script',
			'Balthazar',
			'Bangers',
			'Basic',
			'Battambang',
			'Baumans',
			'Bayon',
			'Belgrano',
			'Belleza',
			'BenchNine',
			'Bentham',
			'Berkshire Swash',
			'Bevan',
			'Bigelow Rules',
			'Bigshot One',
			'Bilbo',
			'Bilbo Swash Caps',
			'Bitter',
			'Black Ops One',
			'Bokor',
			'Bonbon',
			'Boogaloo',
			'Bowlby One',
			'Bowlby One SC',
			'Brawler',
			'Bree Serif',
			'Bubblegum Sans',
			'Bubbler One',
			'Buda',
			'Buenard',
			'Butcherman',
			'Butterfly Kids',
			'Cabin',
			'Cabin Condensed',
			'Cabin Sketch',
			'Caesar Dressing',
			'Cagliostro',
			'Calligraffitti',
			'Cambo',
			'Candal',
			'Cantarell',
			'Cantata One',
			'Cantora One',
			'Capriola',
			'Cardo',
			'Carme',
			'Carrois Gothic',
			'Carrois Gothic SC',
			'Carter One',
			'Caudex',
			'Cedarville Cursive',
			'Ceviche One',
			'Changa One',
			'Chango',
			'Chau Philomene One',
			'Chela One',
			'Chelsea Market',
			'Chenla',
			'Cherry Cream Soda',
			'Cherry Swash',
			'Chewy',
			'Chicle',
			'Chivo',
			'Cinzel',
			'Cinzel Decorative',
			'Clicker Script',
			'Coda',
			'Coda Caption',
			'Codystar',
			'Combo',
			'Comfortaa',
			'Coming Soon',
			'Concert One',
			'Condiment',
			'Content',
			'Contrail One',
			'Convergence',
			'Cookie',
			'Copse',
			'Corben',
			'Courgette',
			'Cousine',
			'Coustard',
			'Covered By Your Grace',
			'Crafty Girls',
			'Creepster',
			'Crete Round',
			'Crimson Text',
			'Croissant One',
			'Crushed',
			'Cuprum',
			'Cutive',
			'Cutive Mono',
			'Damion',
			'Dancing Script',
			'Dangrek',
			'Dawning of a New Day',
			'Days One',
			'Delius',
			'Delius Swash Caps',
			'Delius Unicase',
			'Della Respira',
			'Denk One',
			'Devonshire',
			'Didact Gothic',
			'Diplomata',
			'Diplomata SC',
			'Domine',
			'Donegal One',
			'Doppio One',
			'Dorsa',
			'Dosis',
			'Dr Sugiyama',
			'Droid Sans',
			'Droid Sans Mono',
			'Droid Serif',
			'Duru Sans',
			'Dynalight',
			'EB Garamond',
			'Eagle Lake',
			'Eater',
			'Economica',
			'Ek Mukta',
			'Electrolize',
			'Elsie',
			'Elsie Swash Caps',
			'Emblema One',
			'Emilys Candy',
			'Engagement',
			'Englebert',
			'Enriqueta',
			'Erica One',
			'Esteban',
			'Euphoria Script',
			'Ewert',
			'Exo',
			'Exo 2',
			'Expletus Sans',
			'Fanwood Text',
			'Fascinate',
			'Fascinate Inline',
			'Faster One',
			'Fasthand',
			'Fauna One',
			'Federant',
			'Federo',
			'Felipa',
			'Fenix',
			'Finger Paint',
			'Fira Mono',
			'Fira Sans',
			'Fjalla One',
			'Fjord One',
			'Flamenco',
			'Flavors',
			'Fondamento',
			'Fontdiner Swanky',
			'Forum',
			'Francois One',
			'Freckle Face',
			'Fredericka the Great',
			'Fredoka One',
			'Freehand',
			'Fresca',
			'Frijole',
			'Fruktur',
			'Fugaz One',
			'GFS Didot',
			'GFS Neohellenic',
			'Gabriela',
			'Gafata',
			'Galdeano',
			'Galindo',
			'Gentium Basic',
			'Gentium Book Basic',
			'Geo',
			'Geostar',
			'Geostar Fill',
			'Germania One',
			'Gilda Display',
			'Give You Glory',
			'Glass Antiqua',
			'Glegoo',
			'Gloria Hallelujah',
			'Goblin One',
			'Gochi Hand',
			'Gorditas',
			'Goudy Bookletter 1911',
			'Graduate',
			'Grand Hotel',
			'Gravitas One',
			'Great Vibes',
			'Griffy',
			'Gruppo',
			'Gudea',
			'Habibi',
			'Hammersmith One',
			'Hanalei',
			'Hanalei Fill',
			'Handlee',
			'Hanuman',
			'Happy Monkey',
			'Headland One',
			'Henny Penny',
			'Herr Von Muellerhoff',
			'Hind',
			'Holtwood One SC',
			'Homemade Apple',
			'Homenaje',
			'IM Fell DW Pica',
			'IM Fell DW Pica SC',
			'IM Fell Double Pica',
			'IM Fell Double Pica SC',
			'IM Fell English',
			'IM Fell English SC',
			'IM Fell French Canon',
			'IM Fell French Canon SC',
			'IM Fell Great Primer',
			'IM Fell Great Primer SC',
			'Iceberg',
			'Iceland',
			'Imprima',
			'Inconsolata',
			'Inder',
			'Indie Flower',
			'Inika',
			'Irish Grover',
			'Istok Web',
			'Italiana',
			'Italianno',
			'Jacques Francois',
			'Jacques Francois Shadow',
			'Jim Nightshade',
			'Jockey One',
			'Jolly Lodger',
			'Josefin Sans',
			'Josefin Slab',
			'Joti One',
			'Judson',
			'Julee',
			'Julius Sans One',
			'Junge',
			'Jura',
			'Just Another Hand',
			'Just Me Again Down Here',
			'Kalam',
			'Kameron',
			'Kantumruy',
			'Karla',
			'Karma',
			'Kaushan Script',
			'Kavoon',
			'Kdam Thmor',
			'Keania One',
			'Kelly Slab',
			'Kenia',
			'Khmer',
			'Kite One',
			'Knewave',
			'Kotta One',
			'Koulen',
			'Kranky',
			'Kreon',
			'Kristi',
			'Krona One',
			'La Belle Aurore',
			'Lancelot',
			'Lato',
			'League Script',
			'Leckerli One',
			'Ledger',
			'Lekton',
			'Lemon',
			'Libre Baskerville',
			'Life Savers',
			'Lilita One',
			'Lily Script One',
			'Limelight',
			'Linden Hill',
			'Lobster',
			'Lobster Two',
			'Londrina Outline',
			'Londrina Shadow',
			'Londrina Sketch',
			'Londrina Solid',
			'Lora',
			'Love Ya Like A Sister',
			'Loved by the King',
			'Lovers Quarrel',
			'Luckiest Guy',
			'Lusitana',
			'Lustria',
			'Macondo',
			'Macondo Swash Caps',
			'Magra',
			'Maiden Orange',
			'Mako',
			'Marcellus',
			'Marcellus SC',
			'Marck Script',
			'Margarine',
			'Marko One',
			'Marmelad',
			'Marvel',
			'Mate',
			'Mate SC',
			'Maven Pro',
			'McLaren',
			'Meddon',
			'MedievalSharp',
			'Medula One',
			'Megrim',
			'Meie Script',
			'Merienda',
			'Merienda One',
			'Merriweather',
			'Merriweather Sans',
			'Metal',
			'Metal Mania',
			'Metamorphous',
			'Metrophobic',
			'Michroma',
			'Milonga',
			'Miltonian',
			'Miltonian Tattoo',
			'Miniver',
			'Miss Fajardose',
			'Modern Antiqua',
			'Molengo',
			'Molle',
			'Monda',
			'Monofett',
			'Monoton',
			'Monsieur La Doulaise',
			'Montaga',
			'Montez',
			'Montserrat',
			'Montserrat Alternates',
			'Montserrat Subrayada',
			'Moul',
			'Moulpali',
			'Mountains of Christmas',
			'Mouse Memoirs',
			'Mr Bedfort',
			'Mr Dafoe',
			'Mr De Haviland',
			'Mrs Saint Delafield',
			'Mrs Sheppards',
			'Muli',
			'Mystery Quest',
			'Neucha',
			'Neuton',
			'New Rocker',
			'News Cycle',
			'Niconne',
			'Nixie One',
			'Nobile',
			'Nokora',
			'Norican',
			'Nosifer',
			'Nothing You Could Do',
			'Noticia Text',
			'Noto Sans',
			'Noto Serif',
			'Nova Cut',
			'Nova Flat',
			'Nova Mono',
			'Nova Oval',
			'Nova Round',
			'Nova Script',
			'Nova Slim',
			'Nova Square',
			'Numans',
			'Nunito',
			'Odor Mean Chey',
			'Offside',
			'Old Standard TT',
			'Oldenburg',
			'Oleo Script',
			'Oleo Script Swash Caps',
			'Open Sans',
			'Open Sans Condensed',
			'Oranienbaum',
			'Orbitron',
			'Oregano',
			'Orienta',
			'Original Surfer',
			'Oswald',
			'Over the Rainbow',
			'Overlock',
			'Overlock SC',
			'Ovo',
			'Oxygen',
			'Oxygen Mono',
			'PT Mono',
			'PT Sans',
			'PT Sans Caption',
			'PT Sans Narrow',
			'PT Serif',
			'PT Serif Caption',
			'Pacifico',
			'Paprika',
			'Parisienne',
			'Passero One',
			'Passion One',
			'Pathway Gothic One',
			'Patrick Hand',
			'Patrick Hand SC',
			'Patua One',
			'Paytone One',
			'Peralta',
			'Permanent Marker',
			'Petit Formal Script',
			'Petrona',
			'Philosopher',
			'Piedra',
			'Pinyon Script',
			'Pirata One',
			'Plaster',
			'Play',
			'Playball',
			'Playfair Display',
			'Playfair Display SC',
			'Podkova',
			'Poiret One',
			'Poller One',
			'Poly',
			'Pompiere',
			'Pontano Sans',
			'Port Lligat Sans',
			'Port Lligat Slab',
			'Prata',
			'Preahvihear',
			'Press Start 2P',
			'Princess Sofia',
			'Prociono',
			'Prosto One',
			'Puritan',
			'Purple Purse',
			'Quando',
			'Quantico',
			'Quattrocento',
			'Quattrocento Sans',
			'Questrial',
			'Quicksand',
			'Quintessential',
			'Qwigley',
			'Racing Sans One',
			'Radley',
			'Rajdhani',
			'Raleway',
			'Raleway Dots',
			'Rambla',
			'Rammetto One',
			'Ranchers',
			'Rancho',
			'Rationale',
			'Redressed',
			'Reenie Beanie',
			'Revalia',
			'Ribeye',
			'Ribeye Marrow',
			'Righteous',
			'Risque',
			'Roboto',
			'Roboto Condensed',
			'Roboto Slab',
			'Rochester',
			'Rock Salt',
			'Rokkitt',
			'Romanesco',
			'Ropa Sans',
			'Rosario',
			'Rosarivo',
			'Rouge Script',
			'Rubik Mono One',
			'Rubik One',
			'Ruda',
			'Rufina',
			'Ruge Boogie',
			'Ruluko',
			'Rum Raisin',
			'Ruslan Display',
			'Russo One',
			'Ruthie',
			'Rye',
			'Sacramento',
			'Sail',
			'Salsa',
			'Sanchez',
			'Sancreek',
			'Sansita One',
			'Sarina',
			'Satisfy',
			'Scada',
			'Schoolbell',
			'Seaweed Script',
			'Sevillana',
			'Seymour One',
			'Shadows Into Light',
			'Shadows Into Light Two',
			'Shanti',
			'Share',
			'Share Tech',
			'Share Tech Mono',
			'Shojumaru',
			'Short Stack',
			'Siemreap',
			'Sigmar One',
			'Signika',
			'Signika Negative',
			'Simonetta',
			'Sintony',
			'Sirin Stencil',
			'Six Caps',
			'Skranji',
			'Slabo 13px',
			'Slabo 27px',
			'Slackey',
			'Smokum',
			'Smythe',
			'Sniglet',
			'Snippet',
			'Snowburst One',
			'Sofadi One',
			'Sofia',
			'Sonsie One',
			'Sorts Mill Goudy',
			'Source Code Pro',
			'Source Sans Pro',
			'Source Serif Pro',
			'Special Elite',
			'Spicy Rice',
			'Spinnaker',
			'Spirax',
			'Squada One',
			'Stalemate',
			'Stalinist One',
			'Stardos Stencil',
			'Stint Ultra Condensed',
			'Stint Ultra Expanded',
			'Stoke',
			'Strait',
			'Sue Ellen Francisco',
			'Sunshiney',
			'Supermercado One',
			'Suwannaphum',
			'Swanky and Moo Moo',
			'Syncopate',
			'Tangerine',
			'Taprom',
			'Tauri',
			'Teko',
			'Telex',
			'Tenor Sans',
			'Text Me One',
			'The Girl Next Door',
			'Tienne',
			'Tinos',
			'Titan One',
			'Titillium Web',
			'Trade Winds',
			'Trocchi',
			'Trochut',
			'Trykker',
			'Tulpen One',
			'Ubuntu',
			'Ubuntu Condensed',
			'Ubuntu Mono',
			'Ultra',
			'Uncial Antiqua',
			'Underdog',
			'Unica One',
			'UnifrakturCook',
			'UnifrakturMaguntia',
			'Unkempt',
			'Unlock',
			'Unna',
			'VT323',
			'Vampiro One',
			'Varela',
			'Varela Round',
			'Vast Shadow',
			'Vibur',
			'Vidaloka',
			'Viga',
			'Voces',
			'Volkhov',
			'Vollkorn',
			'Voltaire',
			'Waiting for the Sunrise',
			'Wallpoet',
			'Walter Turncoat',
			'Warnes',
			'Wellfleet',
			'Wendy One',
			'Wire One',
			'Yanone Kaffeesatz',
			'Yellowtail',
			'Yeseva One',
			'Yesteryear',
			'Zeyada',
		);

		if ( empty( Simple_Author_Box_Helper::$fonts ) ) {
			foreach ( $fonts as $font ) {
				Simple_Author_Box_Helper::$fonts[ $font ] = $font;
			}
		}

		return Simple_Author_Box_Helper::$fonts;

	}

	public static function get_custom_post_type() {
		$post_types = get_post_types(
			array(
				'publicly_queryable' => true,
				'_builtin'           => false,
			)
		);

		$post_types['post'] = __( 'Post', 'saboxplugin' );
		$post_types['page'] = __( 'Page', 'saboxplugin' );

		return $post_types;
	}

	public static function get_template( $template_name = 'template-sab.php' ) {

		$template = '';

		if ( ! $template ) {
			$template = locate_template( array( 'sab/' . $template_name ) );
		}

		if ( ! $template && file_exists( SIMPLE_AUTHOR_BOX_PATH . 'template/' . $template_name ) ) {
			$template = SIMPLE_AUTHOR_BOX_PATH . 'template/' . $template_name;
		}

		if ( ! $template ) {
			$template = SIMPLE_AUTHOR_BOX_PATH . 'template/template-sab.php';
		}

		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters( 'sabox_get_template_part', $template, $template_name );
		if ( $template ) {
			return $template;
		}

	}

	public static function generate_inline_css() {

		$padding_top_bottom  = get_option( 'sab_box_padding_top_bottom', 0 );
		$padding_left_right  = get_option( 'sab_box_padding_left_right', 0 );
		$sabox_top_margin    = get_option( 'sab_box_margin_top', 0 );
		$sabox_bottom_margin = get_option( 'sab_box_margin_bottom', 0 );
		$sabox_name_size     = get_option( 'sab_box_name_size', 18 );
		$sabox_desc_size     = get_option( 'sab_box_desc_size', 14 );
		$sabox_icon_size     = get_option( 'sab_box_icon_size', 14 );
		$sabox_options       = get_option( 'saboxplugin_options', array() );

		if ( isset( $sabox_options['sab_web'] ) and get_option( 'sab_box_web_size' ) ) {
			$sabox_web_size = get_option( 'sab_box_web_size' );
		} else {
			$sabox_web_size = 14;
		}

		$style = '';

		// Border color of Simple Author Box
		if ( isset( $sabox_options['sab_box_border'] ) && ! empty( $sabox_options['sab_box_border'] ) ) {
			$style .= '.saboxplugin-wrap {border-color:' . esc_html( $sabox_options['sab_box_border'] ) . ';}';
			$style .= '.saboxplugin-wrap .saboxplugin-socials {-webkit-box-shadow: 0 0.05em 0 0 ' . esc_html( $sabox_options['sab_box_border'] ) . ' inset; -moz-box-shadow:0 0.05em 0 0 ' . esc_html( $sabox_options['sab_box_border'] ) . ' inset;box-shadow:0 0.05em 0 0 ' . esc_html( $sabox_options['sab_box_border'] ) . ' inset;}';
		}
		// Avatar image style
		if ( isset( $sabox_options['sab_avatar_style'] ) && '0' != $sabox_options['sab_avatar_style'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-gravatar img {-webkit-border-radius:50%;-moz-border-radius:50%;-ms-border-radius:50%;-o-border-radius:50%;border-radius:50%;}';
		}
		// Social icons style
		if ( isset( $sabox_options['sab_colored'] ) && '0' != $sabox_options['sab_colored'] && isset( $sabox_options['sab_icons_style'] ) && '0' != $sabox_options['sab_icons_style'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color {-webkit-border-radius:50%;-moz-border-radius:50%;-ms-border-radius:50%;-o-border-radius:50%;border-radius:50%;}';
		}
		// Long Shadow
		if ( isset( $sabox_options['sab_colored'] ) && '0' != $sabox_options['sab_colored'] && ! isset( $sabox_options['sab_box_long_shadow'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color:before {text-shadow: none;}';
		}
		// Avatar hover effect
		if ( isset( $sabox_options['sab_avatar_style'] ) && '0' != $sabox_options['sab_avatar_style'] && isset( $sabox_options['sab_avatar_hover'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-gravatar img {-webkit-transition:all .5s ease;-moz-transition:all .5s ease;-o-transition:all .5s ease;transition:all .5s ease;}';
			$style .= '.saboxplugin-wrap .saboxplugin-gravatar img:hover {-webkit-transform:rotate(45deg);-moz-transform:rotate(45deg);-o-transform:rotate(45deg);-ms-transform:rotate(45deg);transform:rotate(45deg);}';
		}
		// Social icons hover effect
		if ( isset( $sabox_options['sab_icons_style'] ) && '0' != $sabox_options['sab_icons_style'] && isset( $sabox_options['sab_social_hover'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color, .saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey {-webkit-transition: all 0.3s ease-in-out;-moz-transition: all 0.3s ease-in-out;-o-transition: all 0.3s ease-in-out;-ms-transition: all 0.3s ease-in-out;transition: all 0.3s ease-in-out;}.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color:hover,.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey:hover {-webkit-transform: rotate(360deg);-moz-transform: rotate(360deg);-o-transform: rotate(360deg);-ms-transform: rotate(360deg);transform: rotate(360deg);}';
		}
		// Thin border
		if ( isset( $sabox_options['sab_colored'] ) && '0' != $sabox_options['sab_colored'] && ! isset( $sabox_options['sab_box_thin_border'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color {border: medium none !important;}';
		}
		// Background color of social icons bar
		if ( isset( $sabox_options['sab_box_icons_back'] ) && ! empty( $sabox_options['sab_box_icons_back'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials{background-color:' . esc_html( $sabox_options['sab_box_icons_back'] ) . ';}';
		}
		// Color of social icons (for symbols only):
		if ( isset( $sabox_options['sab_box_icons_color'] ) && ! empty( $sabox_options['sab_box_icons_color'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-grey {color:' . esc_html( $sabox_options['sab_box_icons_color'] ) . ';}';
		}
		// Author name color
		if ( isset( $sabox_options['sab_box_author_color'] ) && ! empty( $sabox_options['sab_box_author_color'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-authorname a {color:' . esc_html( $sabox_options['sab_box_author_color'] ) . ';}';
		}

		// Author web color
		if ( isset( $sabox_options['sab_web'] ) && isset( $sabox_options['sab_box_web_color'] ) && ! empty( $sabox_options['sab_box_web_color'] ) ) {
			$style .= '.saboxplugin-wrap .saboxplugin-web a {color:' . esc_html( $sabox_options['sab_box_web_color'] ) . ';}';
		}

		// Author name font family
		if ( get_option( 'sab_box_name_font', 'None' ) != 'None' ) {
			$author_name_font = get_option( 'sab_box_name_font' );
			$style           .= '.saboxplugin-wrap .saboxplugin-authorname {font-family:"' . esc_html( $author_name_font ) . '";}';
		}

		// Author description font family
		if ( get_option( 'sab_box_desc_font', 'None' ) != 'None' ) {
			$author_desc_font = get_option( 'sab_box_desc_font' );
			$style           .= '.saboxplugin-wrap .saboxplugin-desc {font-family:' . esc_html( $author_desc_font ) . ';}';
		}

		// Author web font family
		if ( isset( $sabox_options['sab_web'] ) && get_option( 'sab_box_web_font', 'None' ) != 'None' ) {
			$author_web_font = get_option( 'sab_box_web_font' );
			$style          .= '.saboxplugin-wrap .saboxplugin-web {font-family:"' . esc_html( $author_web_font ) . '";}';
		}

		// Author description font style
		if ( isset( $sabox_options['sab_desc_style'] ) && '0' != $sabox_options['sab_desc_style'] ) {
			$style .= '.saboxplugin-wrap .saboxplugin-desc {font-style:italic;}';
		}
		// Margin top & bottom, Padding
		$style .= '.saboxplugin-wrap {margin-top:' . absint( $sabox_top_margin ) . 'px; margin-bottom:' . absint( $sabox_bottom_margin ) . 'px; padding: ' . absint( $padding_top_bottom ) . 'px ' . absint( $padding_left_right ) . 'px }';
		// Author name text size
		$style .= '.saboxplugin-wrap .saboxplugin-authorname {font-size:' . absint( $sabox_name_size ) . 'px; line-height:' . absint( $sabox_name_size + 7 ) . 'px;}';
		// Author description font size
		$style .= '.saboxplugin-wrap .saboxplugin-desc p, .saboxplugin-wrap .saboxplugin-desc {font-size:' . absint( $sabox_desc_size ) . 'px !important; line-height:' . absint( $sabox_desc_size + 7 ) . 'px !important;}';
		// Author website text size
		$style .= '.saboxplugin-wrap .saboxplugin-web {font-size:' . absint( $sabox_web_size ) . 'px;}';
		// Icons size
		$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color.fa:before {font-size:' . absint( $sabox_icon_size ) . 'px;}';
		$style .= '.saboxplugin-wrap .saboxplugin-socials .saboxplugin-icon-color.fa {width:' . absint( $sabox_icon_size * 2 ) . 'px; height:' . absint( $sabox_icon_size * 2 ) . 'px; line-height:' . absint( $sabox_icon_size * 2 ) . 'px; }';

		return apply_filters( 'sabox_inline_css', $style );
	}

}
