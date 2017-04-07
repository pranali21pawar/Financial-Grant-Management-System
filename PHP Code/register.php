<?php
require 'connect.php';
require 'layout.php';

$err_msg = '';
$userid = '';
$name = '';
$email = '';
$mobile = '';
$password = '';
$cnfpassword = '';
$role = '';

if(isset($_POST['userid']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['password']) && isset($_POST['cnfpassword']) && isset($_POST['role'])) {
	$userid = $_POST['userid'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$password = $_POST['password'];
	$cnfpassword = $_POST['cnfpassword'];
	$role = $_POST['role'];

	if($password == $cnfpassword)
	{
		$mobile = preg_replace("/\D/","",$mobile);
		if(strlen($mobile) == 10) 
		{
			if(eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($email)))
			{
				$q = "INSERT INTO `users` VALUES ('".mysql_real_escape_string($userid)."',
												  '".mysql_real_escape_string($name)."',
												  '".mysql_real_escape_string($email)."',
												  '".mysql_real_escape_string($mobile)."',
												  '".mysql_real_escape_string($password)."',
												  '".mysql_real_escape_string($role)."')";
				if($q_run = mysql_query($q))
				{
					$_SESSION['userid'] = $userid;
					$_SESSION['role'] = $role;
					header('Location: /FGMS/index.php');
				}
				else
				{
					$err_msg = mysql_error();
				}
			}
			else
			{
				$err_msg = "Invalid email!!!";
			}
		}
		else 
		{
			$err_msg = "Invalid Mobile Number!!!";
		}
	}
	else
	{
		$err_msg = "Password does not match!!!";
	}
}

?>

<html>
<head>
	<title>Register</title>
</head>
<body>
<div class="container">
  <div class="row">
    <form class="col s12" action="" method="post">
      <?php
        if($err_msg != '') {
			echo "<div class='row'>
			      	<div class='col s6 offset-s3' style='color:red;'>
			      		".$err_msg."
			      	</div>
			      </div>";
		}
      ?>
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <input id="userid" name="userid" type="text" value="<?php echo $userid; ?>" class="validate">
          <label for="userid">User ID</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <input id="name" name="name" type="text" value="<?php echo $name; ?>" class="validate">
          <label for="name">Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <input id="email" name="email" type="email" value="<?php echo $email; ?>" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <input id="mobile" name="mobile" type="text" value="<?php echo $mobile; ?>" maxlength="10" class="validate">
          <label for="mobile">Mobile</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <input id="password" name="password" value="<?php echo $password; ?>" type="password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <input id="cnfpassword" name="cnfpassword" type="password" class="validate">
          <label for="cnfpassword">Confirm Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <select id="role" name="role">
          	<option value="0" <?php if($role == 0) echo "selected='selected'";?>>Student</option>
          	<option value="1" <?php if($role == 1) echo "selected='selected'";?>>Midware</option>
          </select>
          <label for="role">Role</label>
        </div>
        <script type="text/javascript">
        	$(document).ready(function() {
			    $('select').material_select();
			});
        </script>
      </div>
      <div class="row">
      	<div class="col s6 offset-s3">
      		<button type="submit" class="waves-effect waves-light btn">Register</button>
      	</div>
      </div>
    </form>
  </div>
</div>
</body>
</html>