<?php
	// Query the database for form ID's/Names
	// Run our custom query to retreive our forms from the table we've created
	global $wpdb;
	// return it as an array, so we can work with it to build our form below
	$all_forms = $wpdb->get_results( 'SELECT id, form_name FROM ' . $wpdb->prefix . 'yikes_easy_mc_forms', ARRAY_A );
?>
<h3><span><?php _e( 'Import/Export Forms & Settings' , 'yikes-inc-easy-mailchimp-extender' ); ?></span></h3>

<div class="inside">	
					
	<!-- Export Form -->
	<form action="<?php echo esc_url_raw( add_query_arg( array( 'action' => 'yikes-easy-mc-export-forms' , 'nonce' => wp_create_nonce( 'export-forms' ) ) ) ); ?>" method="post">							
									
		<p><strong><?php _e( "Export Forms" , 'yikes-inc-easy-mailchimp-extender' ); ?></strong></p>
		<p class="description">
			<?php _e( "Select the forms you would like to export. When you click the download button below, Easy Forms for MailChimp will create a CSV file for you to save to your computer. Once you've saved the download file, you can use the Import tool to import the forms to this or any other site." , "yikes-inc-easy-mailchimp-extender" ); ?>
		</p>
	
			<?php if( !empty( $all_forms ) ) { ?>	
				<!-- custom list so users can export specific forms -->
				<a class="toggle-custom-lists button-secondary" onclick="jQuery(this).next().slideToggle();return false;"><?php _e( 'Select Forms' , 'yikes-inc-easy-mailchimp-extender' ); ?></a>
				<ul class="export-custom-forms-list">
					<p class="description"><?php _e( 'Select which forms to export. Leave all checkboxes unchecked to export all of your forms.' , 'yikes-inc-easy-mailchimp-extender' ); ?></p>
					<?php foreach( $all_forms as $form ) { ?>
						<li><label><input type="checkbox" name="export_forms[]" value="<?php echo (int) $form['id']; ?>"><?php echo esc_html( $form['form_name'] ); ?></label></li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p><em><?php _e( "It looks like you haven't created any forms yet." , "yikes-inc-easy-mailchimp-extender" ); ?></em></p>
			<?php } ?>
		<!-- check if any of our transients contain data -->							
		<p><input type="submit" class="button-primary" value="<?php _e( 'Export Opt-in Forms' , 'yikes-inc-easy-mailchimp-extender' ); ?>" /></p>
					
	</form>
	
	<hr />
	
	<!-- Export Form -->
	<form action="<?php echo esc_url_raw( add_query_arg( array( 'action' => 'yikes-easy-mc-export-settings' , 'nonce' => wp_create_nonce( 'export-settings' ) ) ) ); ?>" method="post">							
									
		<p><strong><?php _e( "Export Settings" , 'yikes-inc-easy-mailchimp-extender' ); ?></strong></p>
		<p class="description">
			<?php _e( "Export YIKES Easy Forms for MailChimp plugin settings." , "yikes-inc-easy-mailchimp-extender" ); ?>
		</p>

		<!-- check if any of our transients contain data -->							
		<p><input type="submit" class="button-primary" value="<?php _e( 'Export Plugin Settings' , 'yikes-inc-easy-mailchimp-extender' ); ?>" /></p>
					
	</form>
	
	<hr />
	
	<!-- Import Form -->	
	<form action="<?php echo esc_url_raw( add_query_arg( array( 'action' => 'yikes-easy-mc-import-forms' , 'nonce' => wp_create_nonce( 'import-forms' ) ) ) ); ?>" method="post" enctype="multipart/form-data">							
									
		<p><strong><?php _e( "Import" , 'yikes-inc-easy-mailchimp-extender' ); ?></strong></p>
		<p class="description">
			<?php _e( "Select the Easy Forms for MailChimp export file you would like to import. You can use this field to import your optin forms or settings. " , "yikes-inc-easy-mailchimp-extender" ); ?>
		</p>
		
		<label>
			<input type="file" name="csv" id="forms_to_import">
		</label>
		<!-- check if any of our transients contain data -->							
		<p><input type="submit" class="button-primary" value="<?php _e( 'Import' , 'yikes-inc-easy-mailchimp-extender' ); ?>" /></p>
					
	</form>
	
</div> <!-- .inside -->