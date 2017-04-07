<?php
require 'connect.php';
require 'layout.php';

if(isset($_POST['userid']) && isset($_POST['password'])) {
  $userid=$_POST['userid'];
  $password=$_POST['password'];

  //$password_hash=md5($password);

  // Validating mobile no. and password
  if(!empty($userid) && !empty($password)) {
    $query="SELECT userid, role FROM users WHERE userid='".$userid."' AND password='".$password."'";
    if($query_run=mysql_query($query)) {
      $query_num_rows=mysql_num_rows($query_run);

      if($query_num_rows==0) {
        echo 'Invalid User ID or Password.';
      } else if($query_num_rows==1) {
        $userid=mysql_result($query_run,0,'userid');
        $role=mysql_result($query_run,0,'role');
        $_SESSION['userid']=$userid;
        $_SESSION['role']=$role;
        header('Location: /FGMS/index.php');
      }
    } 
    else {
      echo mysql_error();
    }
  } else {
    echo 'All fields are required.';
  }
}





?>

<html>
<head>
  <title>Log In</title>
</head>
<body>
    <br>
    <br>
    <form class="col s12" action="" method="post">
      <div class="row">
        <div class="input-field col s3 offset-s4">
          <i class="material-icons prefix">account_circle</i>
          <input id="icon_prefix" type="text" class="validate" name="userid" required>
          <label for="icon_prefix">User Id</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s3 offset-s4">
          <i class="material-icons prefix">fingerprint</i>
          <input id="password" type="password" class="validate" name="password" required>
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s3 offset-s4">
          <button class="btn waves-effect waves-light" type="submit" name="action">Submit
          <i class="material-icons right">play_circle_filled</i>
          </button>
        </div>
      </div>
    </form>

</body>
</html>

  
    
 