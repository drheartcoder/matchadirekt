<?php
error_reporting(0); 
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    echo 'Al least PHP version 5.5.0 is required. Your current version is: ' . PHP_VERSION . "\n";
	exit;
}
		
$db_config_path = '../ca_app/config/database.php';

if($_POST) {
	
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();


	if($core->validate_post($_POST) == true)
	{
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if($database->update_admin_password($_POST) == false) {
			$message = $core->show_message('error',"admin panel username and password could not be updated, please verify your settings.");
		} 
		
		else if ($core->write_config_database($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod ca_app/config/database.php file to 777");
		}
		else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The configuration file could not be written, please chmod ca_app/config/config.php file to 777");
		}
		else if ($core->write_config_constant($_POST) == false) {
			$message = $core->show_message('error',"The constant configuration file could not be written, please chmod ca_app/config/constant.php file to 777");
		}
		else if ($core->write_index($_POST) == false) {
			$message = $core->show_message('error',"The index  file could not be written, please chmod ca_app/index.php file to 777");
		}
		
		if(!isset($message)) { 
			header( 'Location: ' . $_POST['site_url']) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Install | Job Portal</title>
		<style type="text/css">
body {
	font-size: 75%;
	font-family: Helvetica, Arial, sans-serif;
	margin: 0 auto;
	background:#f9f9f9
}
label{display: block;
	font-size: 18px;}
input[type="text"], input[type="password"]{
	display: block;
	font-size: 16px;
	margin: 0;
	padding: 10px;
	border-radius: 5px;
	border:1px solid #ddd;
	margin-bottom:10px;
	width:80%;
}
label {
	margin-top: 20px;
}
input.input_text {
	width: 270px;
}
input#submit {
	margin: 25px auto 0;
	font-size: 16px;
	background:#53B0FD;
	color:#fff;
	border:none;
	border-radius:4px;
	cursor:pointer;
	padding:10px 30px;
	font-weight:700;	
}
fieldset {
	padding: 15px;
	border-radius: 10px;
}
legend {
	font-size: 18px;
	font-weight: bold;
}
.error {
	background: #ffd1d1;
	border: 1px solid #ff5858;
	padding: 4px;
}

.wraper{border:1px solid #ddd; background:#fff; padding:20px; max-width:600px; margin:0 auto; margin-top:50px;}
hr{border-top:1px solid #eee; margin:25px 0}
</style>
		</head>
		<body>
<div class="wraper">
<center>
          <h1>Configure your Site</h1>
          <hr>
        </center>
<?php if(is_writable($db_config_path)){?>
<?php if(isset($message)) {echo '<p class="error">' . $message . '</p>';}?>


<form id="install_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <table width="100%">
    <tr>
              <td>Site Title</td>
              <td><input type="text" name="site_title" id="site_title" placeholder="My Site" required="required" /></td>
            </tr>
    <tr>
              <td>Site URL</td>
              <td><input type="text" name="site_url" id="site_url" placeholder="http://www.example.com" required="required" /></td>
            </tr>
            <tr>
              <td>Site Email Addresss</td>
              <td><input type="text" name="site_email" id="site_email" required="required" /></td>
            </tr>
    <tr>
              <td>Username</td>
              <td><input type="text" name="admin_username" id="admin_username" required="required" /></td>
            </tr>
    <tr>
              <td>password</td>
              <td><input type="password" name="admin_pass" id="admin_pass" required="required" /></td>
            </tr>
      
       <tr>
              <td>Indeed.Com Jobs API Key</td>
              <td><input type="text" name="indeed_key" id="indeed_key" /></td>
            </tr>
                  
            
            
    <tr>
              <td colspan="2"><h3>Datbase Details</h3></td>
            </tr>
    <tr>
              <td>Host Name</td>
              <td><input type="text" name="hostname" id="hostname" value="localhost" required="required" /></td>
            </tr>
    <tr>
              <td>Database Name</td>
              <td><input type="text" name="database" id="database" required="required" /></td>
            </tr>
    <tr>
              <td>Database Username</td>
              <td><input type="text" name="username" id="username" required="required" /></td>
            </tr>
    <tr>
              <td>Database Password</td>
              <td><input type="text" name="password" id="password" /></td>
            </tr>
    
            
            <tr>
              <td colspan="2"><h3>SMTP Settings</h3></td>
            </tr>
    <tr>
              <td>Want to Send SMTP Emails?</td>
              <td>
              
              
              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;">
              <tr>
                <th width="30%" scope="col"><input type="radio" name="smtp" id="smtp" value="true" onclick="document.getElementById('sm').style.display='block';" style="display:inline-block;" /> Yes</th>
                <th scope="col"><input type="radio" name="smtp" id="smtp" value="false" onclick="document.getElementById('sm').style.display='none';" style="display:inline-block;"/> No</th>
              </tr>
            </table>

              
              </td>
            </tr>
   <tr>
    <table style="display:none;" id="sm">
    <tr>
              <td width="248">SMTP Host</td>
              <td width="345"><input type="text" name="smtp_host" id="smtp_host" /></td>
            </tr>
    <tr>
              <td>SMTP Username</td>
              <td><input type="text" name="smtp_user" id="smtp_user" /></td>
            </tr>
    <tr>
              <td>SMTP Password</td>
              <td><input type="text" name="smtp_pass" id="smtp_pass" /></td>
            </tr>
    <tr>
    <tr>
              <td>SMTP Port</td>
              <td><input type="text" name="smtp_port" id="smtp_port" /></td>
            </tr>
            </table>
         </tr>
    <tr>
    
              <td colspan="2"><input type="submit" name="submit" id="submit" value="Click to Setup Now"/></td>
            </tr>
            
  </table>
        </form>
<?php } else { ?>
<p class="error">Please make the ca_app/config/database.php file writable. <strong>Example</strong>:<br />
          <br />
          <code>chmod 777 ca_app/config/database.php</code></p>
<?php } ?>
</tr>
</body>
</html>
