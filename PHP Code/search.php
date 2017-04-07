<?php
require 'connect.php';
require 'layout.php';

$found = 0;

if(isset($_POST['submit']))
{
	$search_by = $_POST['search_by'];
	$key = $_POST['key'];
	$query = 'SELECT * FROM `grants` WHERE `inst_id`="'.$_SESSION['userid'].'" AND `'.$search_by.'` LIKE "%'.$key.'%"';
	if($search_by == 'app_name' || $search_by == 'app_email' || $search_by == 'mid_name' || $search_by == 'mid_email') {
		if($search_by == 'app_name' || $search_by == 'app_email')
		{
			$search_by = substr($search_by, 4);
			$q = 'SELECT `userid` FROM `users` WHERE `'.$search_by.'` LIKE "%'.$key.'%" AND `role` = "0"';
			$query = 'SELECT * FROM `grants` WHERE `userid`	= ';
			if($_SESSION['role'] == 1)
				$query = 'SELECT * FROM `grants` WHERE `inst_id` = "'.$_SESSION['userid'].'" AND `userid` = ';
		}
		else
		{
			$search_by = substr($search_by, 4);
			$q = 'SELECT `userid` FROM `users` WHERE `'.$search_by.'` LIKE "%'.$key.'%" AND `role` = "1"';
			$query = 'SELECT * FROM `grants` WHERE `inst_id` = ';
		}

		if($r_q = mysql_query($q))
		{
			$userid = mysql_result($r_q, 0);
			$query = $query.'"'.$userid.'"';
		}
		else
			echo mysql_error();
	}
	else {
		if($_SESSION['role'] == 2)
			$query = 'SELECT * FROM `grants` WHERE `'.$search_by.'` LIKE "%'.$key.'%"';
	}

	if($result = mysql_query($query))
	{
		$no_rows = mysql_num_rows($result);
		if($no_rows != 0)
		{
			$found = 1;
			$count = 0;

			echo "<table class=\"bordered\">
			        <thead>
			          <tr>
			          		<th>Sr. No.</th>	
			              	<th>Applicant Id</th>
			              	<th>Applicant Name</th>
			              	<th>Applicant Email</th>";
			if($_SESSION['role']==2)
			{
				echo '	<th>Midware Id</th>
						<th>Midware Name</th>
						<th>Midware Email</th>';
			}

			echo 	"	<th>Type</th>
						<th>Amount</th>
		              	<th>Image</th>
		              	<th>Applied On</th>
		              	<th>Midware Verified On</th>
		              	<th>Admin Verified On</th>
		              	<th>Status</th>
			          </tr>
			        </thead>

			        <tbody>";
			while($row = mysql_fetch_assoc($result))
			{	
				$status = ['Pending', 
						   'Midware Approved',
						   'Admin Approved',
						   'Midware Disapproved',
						   'Admin Disapproved'
						   ];
				$type = ['',
        				 'Travel',
        				 'Medical',
        				 'Others'
        				];
				$count++;
				$q_user = "SELECT `userid`, `name`, `email` FROM `users` WHERE `userid`='".$row['userid']."' OR `userid`='".$row['inst_id']."'";
        					if($_SESSION['role'] == 1)
        						$q_user = "SELECT `userid`, `name`, `email` FROM `users` WHERE `userid`='".$row['userid']."'";
        					if($result_user = mysql_query($q_user))
        					{
        						$app_name = "Unknown";
        						$app_email= "Unknown";
        						$inst_name = "Unknown";
        						$inst_email= "Unknown";
        						$no_rows = mysql_num_rows($result_user);
        						while($user_row = mysql_fetch_assoc($result_user))
        						{
        							if($user_row['userid'] == $row['userid'])
        							{
        								$app_name = $user_row['name'];
        								$app_email = $user_row['email'];
        							}

        							if($user_row['userid'] == $row['inst_id'])
        							{
        								$inst_name = $user_row['name'];
        								$inst_email = $user_row['email'];
        							}
        						}
        					}
				echo "
					<tr>
						<td>".$count."</td>
						<td>".$row['userid']."</td>
						<td>".$app_name."</td>
						<td>".$app_email."</td>";
				if($_SESSION['role']==2)
				{
					echo "	<td>".$row['inst_id']."</td>
							<td>".$inst_name."</td>
							<td>".$inst_email."</td>";
				}
					echo"	<td>".$type[$row['type']]."</td>
							<td>".$row['amount']."</td>
							<td>".$row['image']."</td>
							<td>".$row['applied_on']."</td>
							<td>".$row['m_verified_on']."</td>
							<td>".$row['a_verified_on']."</td>
							<td>".$status[$row['checked']]."</td>
					</tr>
					";
			}
			echo "</tbody>
				  </table>";
		}
		else
			echo "No result found... :(";
	}
	else
		echo mysql_error();
}
?>



<html>
<head>
	<title>Search</title>
</head>
<body>
<br>
<?php
if($found == 0)
{
echo '<form method="post" action="">
		<div class="container">
			<div class="row">
				<div class="input-field col s6" >
				    <select name="search_by" id="search_by" required>
				    	<option value="" disabled selected>Choose your option</option>
				    	<option value="userid">Applicant Id</option>
				    	<option value="app_name">Applicant Name</option>
				    	<option value="app_email">Applicant email</option>';
				    	
				      	if($_SESSION[role]==2) {
				      		echo '	<option value="inst_id">Midware Id</option>
				      				<option value="mid_name">Midware Name</option>
				      				<option value="mid_email">Midware email</option>';
				      	}
echo '
				    	<option value="type">Type</option>
				    	<option value="amount">Amount</option>
				    	<option value="applied_on">Applied On</option>
				    	<option value="m_verified_on">Midware Verified On</option>
				    	<option value="a_verified_on">Admin Verified On</option>


				    </select>
			    	<label for="search_by">Search By</label>
			 	</div>
			 	<script type="text/javascript">
			 	 	$(document).ready(function() {
						$(\'select\').material_select();
					});
			 	</script>
		 	</div>

		 	<div class="row">
		    	<div class="input-field col s6">
			      	<input value="" name ="key" id="key" type="text" class="validate" required>
			      	<label class="active" for="key">Keyword</label>
			    </div>
			</div>

			<div class="row">
	    		<div class="input-field col s5 offset-s4">
	      			<button class="btn waves-effect waves-light" type="submit" name="submit">Search
	      			<i class="material-icons right">search</i>
	      			</button>
	   			</div>
	 		</div>
		        
		</div>
	</form>';
}
?>
</body>
</html>