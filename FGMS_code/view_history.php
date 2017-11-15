<?php
require 'connect.php';
require 'layout.php';



?>



<html>
<head>
	<title>History</title>
</head>
<body>
	<table class="bordered">
        <thead>
          <tr>
          		<th>Sr. No.</th>	
              	<th>Type</th>
              	<th>Amount</th>
              	<th>Applied On</th>
              	<th>Midware Verified On</th>
              	<th>Admin Verified On</th>
              	<th>Image</th>
              	<th>Status</th>
          </tr>
        </thead>

        <tbody>
        	<?php

        		$q = "SELECT * FROM `grants` WHERE `userid`='".$_SESSION['userid']."'";
        		if($q_run = mysql_query($q))
        		{
        			$q_num_rows = mysql_num_rows($q_run);
        			if($q_num_rows == 0)
        				echo "Nothing to show";
        			else
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
        						 'Othrers'
        						];
        				$count = 0;
        				while ($row = mysql_fetch_assoc($q_run)) {
        					$count++;
						    echo "
						    	<tr>
						    		<td>".$count."</td>
						    		<td>".$type[$row['type']]."</td>
						    		<td>".$row['amount']."</td>
						    		<td>".$row['applied_on']."</td>
						    		<td>".$row['m_verified_on']."</td>
						    		<td>".$row['a_verified_on']."</td>
						    		<td>".$row['image']."</td>
						    		<td>".$status[$row['checked']]."</td>
						    	</tr>
						    ";  
						}
        			}
        		}
        		else
        			echo mysql_error();
        	?>
        </tbody>
    </table>



</body>
</html>