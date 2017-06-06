<?php
/**
 * AccessPress Store functions and definitions
 *
 * @package AccessPress Store
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'accesspress_store_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function accesspress_store_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on AccessPress Store, use a find and replace
	 * to change 'accesspress-store' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'accesspress-store', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
    
    add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    
    add_image_size('accesspress-prod-cat-size', 562, 492, true);
    
    add_image_size('accesspress-service-thumbnail', 380, 252, true);
    
    add_image_size('accesspress-blog-big-thumbnail', 760, 300, true);

    add_image_size('accesspress-slider', 1350, 570, true);
    
    
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'accesspress-store' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'accesspress_store_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'accesspress_store_setup' );

/**
 * AccessPress Store Admin Enqueue Js
*/
function accesspress_store_wp_admin_section() {
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'ap-admin-css', get_template_directory_uri() . '/inc/css/ap-admin.css' );

    if (function_exists('wp_enqueue_media'))
        wp_enqueue_media();
    wp_enqueue_script( 'accesspress-store-admin', get_template_directory_uri() . '/inc/js/ap-admin.js', array( 'jquery' ), '20130508', true );
    wp_localize_script('accesspress-store-admin', 'accesspress_store_l10n', array(
        'upload' => __('Upload', 'accesspress-store'),
        'remove' => __('Remove', 'accesspress-store')
    ));
    
}
add_action( 'admin_enqueue_scripts', 'accesspress_store_wp_admin_section' );


/**
 * Load Require init file.
*/
require $accesspress_store_file_directory_init_file_path = trailingslashit( get_template_directory() ).'inc/init.php';


/**
 * AccessPress More Themes
*/
function accesspress_store_add_upsell() {
	add_theme_page(
		__( 'More Themes', 'accesspress-store' ),
		__( 'More Themes', 'accesspress-store' ),
		'administrator',
		'accesspressstore-themes',
		'accesspress_store_display_upsell'
	);
}
add_action( 'admin_menu', 'accesspress_store_add_upsell', 11 );

function accesspress_store_display_upsell() {
	$directory_uri = get_template_directory_uri(); ?>
		<div class="wrap">
			<h1 style="margin-bottom:20px;">
				<img src="<?php echo get_template_directory_uri(); ?>/inc/images/accesspressthemes.png"/>
			<?php echo sprintf(__( 'More Themes from <a href="%s" target="_blank">AccessPress Themes</a>', 'accesspress-store' ) , esc_url('https://accesspressthemes.com/'))?>
			</h1>

			<div class="theme-browser rendered">
				<div class="themes">
				<?php
				// Set the argument array with author name.
				$args = array(
					'author' => 'access-keys',
				);
				// Set the $request array.
				$request = array(
					'body' => array(
						'action'  => 'query_themes',
						'request' => serialize( (object)$args )
					)
				);
				$themes = accesspressstore_get_themes( $request );
				$active_theme = wp_get_theme()->get( 'Name' );
				$counter = 1;
				// For currently active theme.
				foreach ( $themes->themes as $theme ) {
					if( $active_theme == $theme->name ) {?>

						<div id="<?php echo $theme->slug; ?>" class="theme active">
							<div class="theme-screenshot">
								<img src="<?php echo $theme->screenshot_url ?>"/>
							</div>
							<h3 class="theme-name" id="accesspress-parallax-name"><strong><?php _e('Active','accesspress-store'); ?></strong>: <?php echo $theme->name; ?></h3>
							<div class="theme-actions">
								<a class="button button-secondary activate" target="_blank" href="<?php echo get_site_url(). '/wp-admin/customize.php' ?>"><?php _e('Customize','accesspress-store'); ?></a>
							</div>
						</div>
					<?php
					$counter++;
					break;
					}
				}

				// For all other themes.
				foreach ( $themes->themes as $theme ) {
					if( $active_theme != $theme->name ) {
						// Set the argument array with author name.
						$args = array(
							'slug' => $theme->slug,
						);
						// Set the $request array.
						$request = array(
							'body' => array(
								'action'  => 'theme_information',
								'request' => serialize( (object)$args )
							)
						);
						$theme_details = accesspressstore_get_themes( $request );
					?>
						<div id="<?php echo $theme->slug; ?>" class="theme">
							<div class="theme-screenshot">
								<img src="<?php echo $theme->screenshot_url ?>"/>
							</div>

							<h3 class="theme-name"><?php echo $theme->name; ?></h3>

							<div class="theme-actions">
								<?php if( wp_get_theme( $theme->slug )->exists() ) { ?>
									<!-- Show the tick image notifying the theme is already installed. -->
									<img data-toggle="tooltip" title="<?php _e( 'Already installed', 'accesspress-store' ); ?>" data-placement="bottom" class="theme-exists" src="<?php echo $directory_uri ?>/inc/images/right.png"/>
									<!-- Activate Button -->
									<a  class="button button-secondary activate"
										href="<?php echo wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=' . urlencode( $theme->slug ) ), 'switch-theme_' . $theme->slug );?>" ><?php _e('Activate','accesspress-store') ?></a>
								<?php }else {
									// Set the install url for the theme.
									$install_url = add_query_arg( array(
											'action' => 'install-theme',
											'theme'  => $theme->slug,
										), self_admin_url( 'update.php' ) );
								?>
									<!-- Install Button -->
									<a data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Downloaded ' . number_format( $theme_details->downloaded ) . ' times'; ?>" class="button button-secondary activate" href="<?php echo esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ); ?>" ><?php _e( 'Install Now', 'accesspress-store' ); ?></a>
								<?php } ?>

								<a class="button button-primary load-customize hide-if-no-customize" target="_blank" href="<?php echo $theme->preview_url; ?>"><?php _e( 'Live Preview', 'accesspress-store' ); ?></a>
							</div>
						</div>
						<?php
					}
				}?>
				</div>
			</div>
		</div>
	<?php
}
function accesspressstore_get_themes( $request ) {

	// Generate a cache key that would hold the response for this request:
	$key = 'accesspressstore_' . md5( serialize( $request ) );

	// Check transient. If it's there - use that, if not re fetch the theme
	if ( false === ( $themes = get_transient( $key ) ) ) {

		// Transient expired/does not exist. Send request to the API.
		$response = wp_remote_post( 'http://api.wordpress.org/themes/info/1.0/', $request );

		// Check for the error.
		if ( !is_wp_error( $response ) ) {

			$themes = unserialize( wp_remote_retrieve_body( $response ) );

			if ( !is_object( $themes ) && !is_array( $themes ) ) {

				// Response body does not contain an object/array
				return new WP_Error( 'theme_api_error', 'An unexpected error has occurred' );
			}

			// Set transient for next time... keep it for 24 hours should be good
			set_transient( $key, $themes, 60 * 60 * 24 );
		}
		else {
			// Error object returned
			return $response;
		}
	}
	return $themes;
}