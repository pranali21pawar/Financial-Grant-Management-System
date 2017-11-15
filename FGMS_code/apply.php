<?php
require 'connect.php';
require 'layout.php';


if(isset($_POST['grant_type']) && isset($_POST['amount']) && isset($_POST['description']) && isset($_POST['inst_id']))
{
	if(!empty($_POST['grant_type']) && !empty($_POST['amount']) && !empty($_POST['description']) && !empty($_POST['inst_id'])){
			
			$q = "INSERT INTO grants VALUES ('','".$_SESSION['userid']."',
											   '".$_POST['grant_type']."',
											   '".$_POST['amount']."',
											   '".$_POST['description']."',
											   '',
											   '".$_POST['inst_id']."',
											   '".date('Y/m/d h:i:s')."',
											   '','','')";

			if($q_run = mysql_query($q))
			{
				echo "Successfully applied.";
			}
			else
			{
				echo "Error : ".mysql_error();
			}
		
	}
	else
		echo "All fields are required.";
}

?>



<html>
<head>
	<title>Apply</title>
</head>
<body>
	
	<form class="col s12" method="post" action="">
		<div class="container col s12">
			<div class="row">
				<!-- <div class="input-field col s1 offset-s3">
					<label style="font-size:1.1em; color:black;">Type:</label>
				</div> -->
				<div class="input-field col s5 offset-s3" >
				    <select name="grant_type" id="grant_type" required>
				    	<option value="" disabled selected>Select Type of Grant</option>
				    	<option value="1">Travel</option>
				    	<option value="2">Medical</option>
				    	<option value="3">Others</option>
				    </select>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s5 offset-s3">
					<input type="number" name="amount" id="amount" min="0" max="200" required >
					<label for="amount">Amount</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s5 offset-s3">
					<textarea id="description" name="description" class="materialize-textarea" required></textarea>
	          		<label for="description">Details</label>
	          	</div>
			</div>
			<div class="row" id="bill_div">
				<div class="file-field input-field col s5 offset-s3"  >
	     			<div class="btn">
	        			<span>Bill</span>
	        			<input type="file" name="bill" id="bill" >
	      			</div>
	      			<div class="file-path-wrapper">
	        			<input class="file-path validate" type="text" id="bill_path">
	     			</div>
	   			</div>
	   		</div>
	   		<div class="row">
        		<div class="input-field col s5 offset-s3">
	          		<select name="inst_id" required>
	          			<?php
	   						$query="SELECT `userid` FROM `users` WHERE `role`='1'";
	   			
	   						if($query_run=mysql_query($query))
	   						{
	   							while($rows=mysql_fetch_assoc($query_run))
	   							{
	   								echo '<option value="'.$rows['userid'].'">'.$rows['userid'].'</option>';
	   							}
	   						}
	   						else
	   							echo mysql_error();
   						?>
	          			
	         		</select>
          			<label for="role">Instructor</label>
        		</div>
       			<script type="text/javascript">
        			$(document).ready(function() {
			    	$('select').material_select();
					});
        		</script>
   			</div>
   			<div class="row">
        		<div class="input-field col s5 offset-s3">
          			<button class="btn waves-effect waves-light" type="submit" name="action">Apply
          			<i class="material-icons right">play_circle_filled</i>
          			</button>
       			</div>
     		</div>
    	</div>/
	</form>

</body>
</html>