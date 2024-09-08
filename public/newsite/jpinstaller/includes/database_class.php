<?php

class Database {

	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Create the prepared statement
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);

		// Close the connection
		$mysqli->close();

		return true;
	}

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Open the default SQL file
		$query = file_get_contents('assets/install.sql');

		// Execute a multi query
		//$mysqli->multi_query($query);
		if ($mysqli->multi_query($query)) {
			do {
				$mysqli->next_result();
				$i++;
			}
			while( $mysqli->more_results() ); 
		}
		if( $mysqli->errno )
		{
			die(
				'<h1>ERROR</h1>
				Query #' . ( $i + 1 ) . ' of <b>install.sql</b>:<br /><br />
				<pre>' . @$query_array[ $i ] . '</pre><br /><br /> 
				<span style="color:red;">' . $mysqli->error . '</span>'
			);
		
		}

		// Close the connection
		$mysqli->close();

		return true;
	}
	
	function update_admin_password($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

		// Check for errors
		if(mysqli_connect_errno())
			return false;
		
		$new_hashed='';
		if($data['admin_pass'])
			$new_hashed = password_hash($data['admin_pass'], PASSWORD_DEFAULT);
			
		//$passwd = password_hash(trim($data['admin_pass']), PASSWORD_DEFAULT);
		
		// Create the prepared statement
		$mysqli->query("UPDATE tbl_admin set admin_username='".$data['admin_username']."', admin_password='".$new_hashed."' where id='1'");

		// Close the connection
		$mysqli->close();

		return true;
	}
	
	
	
}