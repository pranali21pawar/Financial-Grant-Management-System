<?php
require 'connect.php';
require 'layout.php';

if(isset($_SESSION['role']))
{
	if($_SESSION['role'] == 0)
		header('Location: /FGMS/index.php');
}
else
	header('Location: /FGMS/index.php');


?>


        	<?php
        		$q = 'SELECT * FROM `grants` WHERE `inst_id`="'.$_SESSION['userid'].'" AND `checked` <> 0';
        		if($_SESSION['role'] == 2)
        			$q = 'SELECT * FROM `grants` WHERE `checked` <> 0';

        		if($q_run = mysql_query($q))
        		{
        			$q_num_rows = mysql_num_rows($q_run);
        			if($q_num_rows == 0)
        				echo "<br><center>No Request Verified.<center>";
        			else
        			{
        				echo'<table class="bordered">
       							 <thead>
          							<tr>
          								<th>Sr. No.</th>';	
						              	 if($_SESSION['role']==2) echo '<th>Midware Id</th>
						              	<th>Midware Name</th>';
						            echo'<th>Applicant Id</th>
						              	<th>Applicant Name</th>
						              	<th>Grant Type</th>
						              	<th>Amount</th>
						              	<th>Image</th>
						              	<th>Applied On</th>
						              	<th>Midware Verified On</th>
						              	<th>Time Taken</th>
          							</tr>
       							 </thead>
       							 <tbody> ';
        				$count = 0;
        				$type = ['',
        						 'Travel',
        						 'Medical',
        						 'Others'
        						];
        				while ($row = mysql_fetch_assoc($q_run)) {
        					$count++;
        					$q_user = "SELECT `userid`, `name` FROM `users` WHERE `userid`='".$row['userid']."' OR `userid`='".$row['inst_id']."'";
        					if($_SESSION['role'] == 1)
        						$q_user = "SELECT `userid`, `name` FROM `users` WHERE `userid`='".$row['userid']."'";
        					if($result = mysql_query($q_user))
        					{
        						$std_name = "Unknown";
        						$inst_name = "Unknown";
        						$no_rows = mysql_num_rows($result);
        						while($user_row = mysql_fetch_assoc($result))
        						{
        							if($user_row['userid'] == $row['userid'])
        								$std_name = $user_row['name'];
        							if($user_row['userid'] == $row['inst_id'])
        								$inst_name = $user_row['name'];
        						}

        						echo "
							    	<tr>
							    		<td>".$count."</td>";
							    if($_SESSION['role'] == 2)
							    {
							    	echo "<td>".$row['inst_id']."</td>
							    		  <td>".$inst_name."</td>";
							    }
							    $time_taken=(new DateTime($row['applied_on']))->diff(new DateTime($row['m_verified_on']));
							    echo   "<td>".$row['userid']."</td>
							    		<td>".$std_name."</td>
							    		<td>".$type[$row['type']]	."</td>
							    		<td>".$row['amount']."</td>
							    		<td>".$row['image']."</td>
							    		<td>".$row['applied_on']."</td>
							    		<td>".$row['m_verified_on']."</td>
							    		<td>".$time_taken->days." days</td>
							    	</tr>
							    	</tbody>
							    "; 
        					}
        					else
        						echo mysql_error();
        				}
        			}
        		}
        		else
        			echo mysql_error();
        	?>