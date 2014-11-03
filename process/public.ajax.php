<?php
/*
This page gets included from lib.ajax and then processes
the post. This page should never get called by itself.
This page houses the ajax functions fired from the frontend
*/
if(!empty($_POST)
&& isset($_POST['form_action']))
	{	
	switch($_POST['form_action'])
		{

		case 'frontend_submit_form':
			$action	= $yksemeBase->addUserToMailchimp($_POST,$update_existing='false');
			if($action == "done")
				{
					echo '1';
				} else {
					echo $action;
				}
			break;
		
		/* Resubmit form data - update previously subscribed user */
		case 'frontend_resubmit_form_data':
			$action	= $yksemeBase->addUserToMailchimp($_POST,$update_existing='true');
			if($action == "done")
				{
					echo '1';
				} else {
					echo $action;
				}
			break;
			
		}
	}
?>