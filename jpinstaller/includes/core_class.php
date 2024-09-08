<?php

class Core {

	// Function to validate the post data
	function validate_post($data)
	{
		/* Validating the hostname, the database name and the username. The password is optional. */
		return !empty($data['hostname']) && !empty($data['username']) && !empty($data['database']);
	}

	// Function to show an error
	function show_message($type,$message) {
		return $message;
	}

	// Function to write the config file
	function write_config_database($data) {

		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../ca_app/config/database.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				@chmod($output_path,0644);
				return true;
			} else {
				@chmod($output_path,0644);
				return false;
			}

		} else {
			@chmod($output_path,0644);
			return false;
		}
	}
	
	function write_config($data) {

		// Config path
		$template_path 	= 'config/config.php';
		$output_path 	= '../ca_app/config/config.php';

		// Open the file
		$con_file = file_get_contents($template_path);

		$new  = str_replace("%SITE_URL%",$data['site_url'],$con_file);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				@chmod($output_path,0644);
				return true;
			} else {
				@chmod($output_path,0644);
				return false;
			}

		} else {
			@chmod($output_path,0644);
			return false;
		}
	}
	
	function write_config_constant($data) {

		// Config path
		$template_path 	= 'config/constants.php';
		$output_path 	= '../ca_app/config/constants.php';

		// Open the file
		$constant_file = file_get_contents($template_path);

		$new  = str_replace("%SITE_NAME%",$data['site_title'],$constant_file);
		$new  = str_replace("%ADMIN_EMAIL%",$data['site_email'],$new);
		$new  = str_replace("%INDEED_KEY%",$data['indeed_key'],$new);
		$new  = str_replace("%SITE_URL%",$data['site_url'],$new);
		
		$new  = str_replace("%SMTP%",$data['smtp'],$new);
		$new  = str_replace("%SMTP_host%",$data['smtp_host'],$new);
		$new  = str_replace("%SMTP_user%",$data['smtp_user'],$new);
		$new  = str_replace("%SMTP_pass%",$data['smtp_pass'],$new);
		$new  = str_replace("%SMTP_port%",$data['smtp_port'],$new);
		
		
		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				@chmod($output_path,0644);
				return true;
			} else {
				@chmod($output_path,0644);
				return false;
			}

		} else {
			@chmod($output_path,0644);
			return false;
		}
	}
	
	function write_index($data) {

		// Config path
		$template_path 	= 'config/index.php';
		$output_path 	= '../index.php';

		// Open the file
		$con_file = file_get_contents($template_path);
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$con_file)) {
				@chmod($output_path,0644);
				return true;
			} else {
				@chmod($output_path,0644);
				return false;
			}

		} else {
			@chmod($output_path,0644);
			return false;
		}
	}
	
}