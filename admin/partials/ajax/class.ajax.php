<?php
	/*
	* 	Main Ajax handler
	* 	
	* 	Handles many of the ajax functionality on the admin side (ie. Adding new field to form, updating fields, grabbing list data etc.)
	*	
	*	@since 6.0.0
	*	Author: Yikes Inc. | https://www.yikesinc.com
	*/
	class YIKES_Inc_Easy_MailChimp_Process_Ajax
	{

		public function __construct() {				
			// ajax send merge variable to form builder
			add_action( 'wp_ajax_add_field_to_form', array( $this , 'send_field_to_form' ), 10 );
			// ajax send interest group to form builder
			add_action( 'wp_ajax_add_interest_group_to_form', array( $this , 'send_interest_group_to_form' ), 10 );
			// return new list data + activity (for dashboard widget )
			add_action( 'wp_ajax_get_new_list_data', array( $this , 'get_new_list_data' ), 10 );
			// Add a new notification to a form
			add_action( 'wp_ajax_add_notification_to_form', array( $this , 'add_notification_to_form' ), 10 , 1 );
		}
		
		/* 
		*	Assign a new notification to the form
		*	- return a single container
		*/
		public function add_notification_to_form() {
			if( $_POST['notification_name'] ) {
				include_once( YIKES_MC_PATH . 'admin/partials/ajax/add_notification_to_form.php' );
			}
			exit();
			wp_die();
		}
		
		// Process our AJAX request,
		// when the user wants to switch which form data
		// is displayed on the dashboard
		public function get_new_list_data() {
			$list_id = $_POST['list_id'];
			$api_key = get_option( 'yikes-mc-api-key' , '' );
			// initialize MailChimp Class
			$MailChimp = new MailChimp( $api_key );
			// retreive our list data
			$list_data = $MailChimp->call( 'lists/list' , array( 'apikey' => $api_key, 'filters' => array( 'list_id' => $list_id ) ) );
			if( !empty( $list_data['data'] ) ) {
				include_once( YIKES_MC_PATH . 'admin/partials/dashboard-widgets/templates/stats-list-template.php' );
			}
			exit();
			wp_die();
		}
		
		// Process our Ajax Request
		// send a field to our form
		public function send_field_to_form() {
			$form_data_array = array(
				'field_name' => $_POST['field_name'],
				'merge_tag' => $_POST['merge_tag'],
				'field_type' => $_POST['field_type'],
				'list_id' => $_POST['list_id'],
			);
			include YIKES_MC_PATH . 'admin/partials/ajax/add_field_to_form.php';
			exit();
			wp_die();
		}
		
		// send interest group to our form
		public function send_interest_group_to_form() {
			$form_data_array = array(
				'field_name' => $_POST['field_name'],
				'group_id' => $_POST['group_id'],
				'field_type' => $_POST['field_type'],
				'list_id' => $_POST['list_id'],
			);
			include YIKES_MC_PATH . 'admin/partials/ajax/add_interest_group_to_form.php';
			exit();
			wp_die();
		}
	
		/*
		*	Search through multi dimensional array
		*	and return the index ( used to find the list name assigned to a form )
		*	- http://stackoverflow.com/questions/6661530/php-multi-dimensional-array-search
		*/
		public function findMCListIndex( $id, $array , $tag ) {
			if( $tag == 'tag' ) {
				foreach ( $array as $key => $val ) {
					   if ( $val['tag'] === $id ) {
						   return $key;
					   }
				   }
			   return null;
			} else {
				foreach ( $array as $key => $val ) {
				   if ( $val['id'] == $id ) {
					   return $key;
				   }
			   }
			return null;
			}
	  	} // end
					
	} // end class
	
	new YIKES_Inc_Easy_MailChimp_Process_Ajax;
?>