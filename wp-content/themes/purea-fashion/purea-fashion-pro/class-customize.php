<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Purea_Fashion_Pro_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( get_stylesheet_directory() . '/purea-fashion-pro/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Purea_Fashion_Pro_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Purea_Fashion_Pro_Customize_Section_Pro(
				$manager,
				'purea_fashion_buy',
				array(
					'priority'      => 10,
					'title'    => esc_html__( 'Purea Fashion Pro', 'purea-fashion' ),
					'pro_text' => esc_html__( 'Upgrade to Pro', 'purea-fashion' ),
					'pro_url'  => 'https://www.spiraclethemes.com/purea-magazine-pro-addons/'
				)
			)
		);
	}
}

// Doing this customizer thang!
Purea_Fashion_Pro_Customize::get_instance();
