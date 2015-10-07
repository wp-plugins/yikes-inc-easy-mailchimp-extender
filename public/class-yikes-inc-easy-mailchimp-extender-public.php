<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.yikesinc.com/
 * @since      6.0.0
 *
 * @package    Yikes_Inc_Easy_Mailchimp_Extender
 * @subpackage Yikes_Inc_Easy_Mailchimp_Extender/public
 *
 * The public-facing functionality of the plugin.
 *
 * @package    Yikes_Inc_Easy_Mailchimp_Extender
 * @subpackage Yikes_Inc_Easy_Mailchimp_Extender/public
 * @author     YIKES Inc. <info@yikesinc.com>
 */
class Yikes_Inc_Easy_Mailchimp_Extender_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    6.0.0
	 * @access   private
	 * @var      string    $yikes_inc_easy_mailchimp_extender    The ID of this plugin.
	 */
	private $yikes_inc_easy_mailchimp_extender;
	/**
	 * The version of this plugin.
	 *
	 * @since    6.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    6.0.0
	 * @param      string    $yikes_inc_easy_mailchimp_extender       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $yikes_inc_easy_mailchimp_extender, $version ) {
		$this->yikes_inc_easy_mailchimp_extender = $yikes_inc_easy_mailchimp_extender;
		$this->version = $version;
		/** 
		 * 	Define version of this plugin
		 * 	@since 6.0.0
		 */
		if ( ! defined( 'YIKES_MC_VERSION' ) ) {
			define( 'YIKES_MC_VERSION' , $version );
		}
		// Include our Shortcode & Processing function (public folder)
		include_once( YIKES_MC_PATH . 'public/partials/shortcodes/process_form_shortcode.php' );
		// Process our old shortcode to alert the user that this is now depracated
		include_once( YIKES_MC_PATH . 'public/partials/shortcodes/process_form_shortcode_depracated.php' );
		// include our ajax processing class
		require_once( YIKES_MC_PATH . 'public/partials/ajax/class.public_ajax.php' );
		// Include our error logging class
		add_action( 'init' , array( $this , 'load_error_logging_class' ) , 1 );
		// load our checkbox classes
		add_action( 'init' , array( $this , 'load_checkbox_integration_classes' ) , 1 );
		// Legacy support of the php snippet
	}
		
	/**
	 *	Load our checkbox integrations
	 *
	 *	Based on what the user has specified on the options page, lets
	 *	load our checkbox classes
	 *
	 *	@since 6.0.0
	**/
	public function load_checkbox_integration_classes() {
		// store our options
		$integrations = get_option( 'optin-checkbox-init' , '' );
		if( !empty( $integrations ) ) {
			// load our mail integrations class
			require_once YIKES_MC_PATH . 'public/classes/checkbox-integrations.php';
			// loop over selected classes and load them up!
			foreach( $integrations as $integration => $value ) {	
				if( isset( $value['value'] ) && $value['value'] == 'on' ) {
					// load our class extensions
					require_once YIKES_MC_PATH . 'public/classes/checkbox-integrations/class.'.$integration.'-checkbox.php';
				}
			}
		}
	}
	
	/**
	 * Error logging class
	 *
	 * This is our main error logging class file, used to log errors to the error log.
	 *
	 * @since 6.0.0
	 */
	public function load_error_logging_class() {
		if( get_option( 'yikes-mailchimp-debug-status' , '' ) == '1' ) {
			// if error logging is enabled we should include our error logging class
			require_once YIKES_MC_PATH . 'includes/error_log/class-yikes-inc-easy-mailchimp-error-logging.php';
			$error_logging = new Yikes_Inc_Easy_Mailchimp_Error_Logging;
		}
	}	

}


/*
*	Legacy support for our PHP Snippet
*	- this snippet existed in previous versions, and hes been preserved
*	  to maintain backwards compatibility. The form ID needs to be updated.
*	
*	@since 6.0.0
*/
function yksemeProcessSnippet( $list=false, $submit_text ) {
	$submit_text = ( isset( $submit_text ) ) ? 'submit="' . $submit_text . '"' : '';
	return do_shortcode( '[yikes-mailchimp form="' . $list . '" ' . $submit_text . ']' );
}