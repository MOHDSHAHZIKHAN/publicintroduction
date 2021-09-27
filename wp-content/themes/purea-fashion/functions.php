<?php 


/**
 *  Defining Constants
 */

// Core Constants
define('PUREA_FASHION_REQUIRED_PHP_VERSION', '5.6' );
define('PUREA_FASHION_THEME_AUTH','https://www.spiraclethemes.com/');
define('PUREA_FASHION_THEME_URL','https://www.spiraclethemes.com/purea-fashion-free-wordpress-theme/');
define('PUREA_FASHION_THEME_PRO_URL','https://www.spiraclethemes.com/purea-magazine-pro-addons/');
define('PUREA_FASHION_THEME_DOC_URL','https://www.spiraclethemes.com/purea-fashion-documentation/');
define('PUREA_FASHION_THEME_VIDEOS_URL','https://www.spiraclethemes.com/purea-fashion-video-tutorials/');
define('PUREA_FASHION_THEME_SUPPORT_URL','https://wordpress.org/support/theme/purea-fashion/');
define('PUREA_FASHION_THEME_RATINGS_URL','https://wordpress.org/support/theme/purea-fashion/reviews/');
define('PUREA_FASHION_THEME_CHANGELOGS_URL','https://themes.trac.wordpress.org/log/purea-fashion/');
define('PUREA_FASHION_THEME_CONTACT_URL','https://www.spiraclethemes.com/contact/');


/**
* Check for minimum PHP version requirement 
*
*/
function purea_fashion_check_theme_setup( $oldtheme_name, $oldtheme ){
  	// Compare versions.
  	if ( version_compare(phpversion(), PUREA_FASHION_REQUIRED_PHP_VERSION, '<') ) :
	  	// Theme not activated info message.
	  	add_action( 'admin_notices', 'purea_fashion_php_admin_notice' );
	  	function purea_fashion_php_admin_notice() {
	    	?>
	      		<div class="update-nag">
	          		<?php 
	          			esc_html_e( 'You need to update your PHP version to a minimum of 5.6 to run Purea Fashion WordPress Theme.', 'purea-fashion' ); 
	          		?> 
	          		<br />
	          		<?php esc_html_e( 'Actual version is:', 'purea-fashion' ) ?> 
	          		<strong><?php echo phpversion(); ?></strong>, 
	          		<?php esc_html_e( 'required is', 'purea-fashion' ) ?> 
	          		<strong><?php echo PUREA_FASHION_REQUIRED_PHP_VERSION; ?></strong>
	      		</div>
	    	<?php
	  	}
		// Switch back to previous theme.
		switch_theme( $oldtheme->stylesheet );
		return false;
	endif;
}
add_action( 'after_switch_theme', 'purea_fashion_check_theme_setup', 10, 2  );


/**
 * Removing image sizes defined by parent theme
 */
function purea_fashion_remove_extra_image_sizes() {
	remove_image_size( 'purea-magazine-posts' );
}
add_action('init', 'purea_fashion_remove_extra_image_sizes');


/**
 * Setting default theme mods value for child theme
 */
function purea_fashion_set_default_theme_mods() {
	set_theme_mod('purea_magazine_header_menu_style', 'style-pf');
    set_theme_mod('purea_magazine_highlight_area_columns', '4');
    set_theme_mod('purea_magazine_blog_sidebar_layout', 'right');
    set_theme_mod('purea_magazine_blog_single_sidebar_layout', 'right');
    set_theme_mod('purea_magazine_enable_menu_left_sidebar', true);
}
add_action('after_switch_theme', 'purea_fashion_set_default_theme_mods');


/**
 * Purea fashion theme functions
 */	
function purea_fashion_theme_setup(){

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
    
    remove_action( 'admin_menu', 'purea_magazine_add_menu' );
	add_action('wp_enqueue_scripts', 'purea_fashion_load_scripts');
	
	/**
	* Purea Fashion custom posts thumbs size
	*/
	add_image_size( 'purea-fashion-posts-thumb', 270, 320, true );

	/**
	* Adding translation file
	*/
	$path = get_stylesheet_directory().'/languages';
    load_child_theme_textdomain( 'purea-fashion', $path );
}
add_action( 'after_setup_theme', 'purea_fashion_theme_setup', 99 );

/**
 * Load Scripts
 */
function purea_fashion_load_scripts() {	
	wp_register_style( 'parent-style', get_template_directory_uri().'/style.css' );
	wp_style_add_data( 'parent-style', 'rtl', 'replace' );
	wp_enqueue_style( 'parent-style' );
	
	wp_register_style( 'purea-fashion-style' , trailingslashit(get_stylesheet_directory_uri()).'style.css', false, '1.0.2', 'all');
	wp_style_add_data( 'purea-fashion-style', 'rtl', 'replace' );
	wp_enqueue_style( 'purea-fashion-style' );
}

/**
 * Display dynamic CSS.
 */
function purea_fashion_dynamic_css_wrap() {
    require_once( get_stylesheet_directory(). '/css/dynamic.css.php' );
    ?>
       	<style type="text/css" id="purea-fashion-dynamic-style">
        	<?php echo purea_fashion_dynamic_css_stylesheet(); ?>
       	</style>
    <?php 
}
add_action( 'wp_head', 'purea_fashion_dynamic_css_wrap',20 );


/**
 * Estimated Reading time
 */
function purea_fashion_estimated_reading_time($postid) {
	$post = get_post( $postid ); 
 	$mycontent = $post->post_content;
	$word = str_word_count(strip_tags($mycontent));
	$m = floor($word / 200);
	$s = floor($word % 200 / (200 / 60));
	if(0==$m):
		$est = $s . esc_html(' SEC READ','purea-fashion');
	else:
		$est = $m . esc_html(' MIN READ','purea-fashion');
	endif;
	
	return $est;
}


/**
 * Admin scripts
 */
if ( ! function_exists( 'purea_fashion_admin_scripts' ) ) :
function purea_fashion_admin_scripts($hook) {
	wp_enqueue_style( 'purea-fashion-admin', trailingslashit(get_stylesheet_directory_uri()).'css/admin.css', false ); 
    if('appearance_page_purea-fashion-theme-info' != $hook)
    	return;  
    wp_enqueue_style( 'purea-fashion-info', trailingslashit(get_stylesheet_directory_uri()).'css/purea-fashion-theme-info.css', false );
}
endif;
add_action( 'admin_enqueue_scripts', 'purea_fashion_admin_scripts' );


/**
 * Adding class to body
 */
if ( ! function_exists( 'purea_fashion_add_classes_to_body' ) ) :
function purea_fashion_add_classes_to_body($classes = '') {
    $classes[] = 'purea-fashion';
    return $classes;
}
endif;
add_filter('body_class', 'purea_fashion_add_classes_to_body');


/**
 * Function for Minimizing dynamic CSS
 */
function purea_fashion_minimize_css($css){
    $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css);
    $css = preg_replace('/\s{2,}/', ' ', $css);
    $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
    $css = preg_replace('/;}/', '}', $css);
    return $css;
}


/**
* Includes
*/

//include info
require_once( get_stylesheet_directory(). '/inc/theme-info.php' );

//include widgets
require_once( get_stylesheet_directory(). '/inc/widgets.php' );


/**
 * Upgrade to Pro
 */
require_once( get_stylesheet_directory(). '/purea-fashion-pro/class-customize.php' );