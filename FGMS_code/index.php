<?php
require 'connect.php';
require 'layout.php';

$Type = ['',
         'Travel',
    	 'Medical',
    	 'Others'
        ];
if(!loggedin())
	echo'<br><center>Welcome!</center>';
if(isset($_SESSION['role'])) {
	if($_SESSION['role']==0){
		echo '<br><center><a href="/FGMS/apply.php"class="waves-effect waves-light btn"><i class="material-icons left">add_box</i>Apply</a>
	<a href="/FGMS/view_history.php"class="waves-effect waves-light btn"><i class="material-icons left">history</i>History</a></center>';

	}
	else if($_SESSION['role']==1){
		if(isset($_POST['submit']))
		{
			$query = "SELECT * FROM `grants` where `checked`='0'";
			if($query_run = mysql_query($query))
			{
				while($query_row = mysql_fetch_assoc($query_run))
				{
						$ID = $query_row['id'];
						if(isset($_POST[$ID]))
						{
							$permission = $_POST[$ID];
							if($permission == "approved")
							{
								$q = "UPDATE `grants` set `checked`='1', `m_verified_on`='".date("Y/m/d h:i:s")."' WHERE `id`='".$ID."'";
								mysql_query($q);
							}
							else if($permission == "disapproved")
							{
								$q = "UPDATE `grants` set `checked`='3', `m_verified_on`='".date("Y/m/d h:i:s")."' WHERE `id`='".$ID."'";
								mysql_query($q);
							}
						}
				}
				//header('Location: index.php');
			}
		}

		$querry="SELECT * FROM grants WHERE checked = '0' AND inst_id='".$_SESSION['userid']."'";

		if($querry_run=mysql_query($querry)){
			$querry_no_rows=mysql_num_rows($querry_run);
			if($querry_no_rows==0)
				echo '<br><center>No Requests Pending</center>';
			else
			{
				echo '<form action="" method="post">';
				echo "<table class='bordered'>
	        			<thead>
	          				<tr>
	          					<th>Sr. No.</th>	
				              	<th>User Id</th>
				              	<th>Name</th>
				              	<th>Email</th>
				              	<th>Type</th>
				              	<th>Amount</th>
				              	<th>Applied On</th>
				              	<th>Image</th>
				              	<th colspan='3'><center>Approve/Disapprove</center></th>
	         				</tr>
	       				</thead>";
	       		$count=0;
	       		while($querry_row = mysql_fetch_assoc($querry_run))
	       		{	
	       			$count++;
	       			$id = $querry_row['id'];
	       			$userid=$querry_row['userid'];
	       			$q = "SELECT * FROM `users` WHERE `userid` = '".$userid."'";
	       			$q_run = mysql_query($q);
	       			$name = mysql_result($q_run, 0, 'name');
	       			$email = mysql_result($q_run, 0, 'email');
	       			$type = $Type[$querry_row['type']];
	       			$amount = $querry_row['amount'];
	       			$applied_on = $querry_row['applied_on'];
	       			$image = $querry_row['image'];

	       			echo '<tbody>
	       					<tr>
	       						<td>'.$count.'</td>
	       						<td>'.$userid.'</td>
	       						<td>'.$name.'</td>
	       						<td>'.$email.'</td>
	       						<td>'.$type.'</td>
	       						<td>'.$amount.'</td>
	       						<td>'.$applied_on.'</td>
	       						<td>'.$image.'</td>
	       						<td><input class="with-gap" name="'.$id.'" type="radio" id="'.$id.'1" value="approved" />
									<label for="'.$id.'1">Approve</label>
								</td>
								<td><input class="with-gap" name="'.$id.'" type="radio" id="'.$id.'2" value="disapproved" />
									<label for="'.$id.'2">Disapprove</label>
								</td>
								<td><input class="with-gap" name="'.$id.'" type="radio" id="'.$id.'3" value="skip" checked />
									<label for="'.$id.'3">Skip</label>
								<td>
							</tr>';
	       		}

	       		echo '</tbody>
						</table>
						<center>
						<button class="btn waves-effect waves-light" type="submit" name="submit">Submit
          				<i class="material-icons right">play_circle_filled</i>
          				</button>
          				</center>
          				</form>';

			}
		}

	}


	else if($_SESSION['role']==2){
		if(isset($_POST['submit']))
		{
			$query = "SELECT * FROM `grants` where `checked`='1'";
			if($query_run = mysql_query($query))
			{
				while($query_row = mysql_fetch_assoc($query_run))
				{
						$ID = $query_row['id'];
						if(isset($_POST[$ID]))
						{
							$permission = $_POST[$ID];
							if($permission == "approved")
							{
								$q = "UPDATE `grants` set `checked`='2', `a_verified_on`='".date("Y/m/d h:i:s")."' WHERE `id`='".$ID."'";
								mysql_query($q);
							}
							else if($permission == "disapproved")
							{
								$q = "UPDATE `grants` set `checked`='4', `a_verified_on`='".date("Y/m/d h:i:s")."' WHERE `id`='".$ID."'";
								mysql_query($q);
							}
						}
				}
				//header('Location: index.php');
			}
		}
		$querry="SELECT * FROM grants WHERE checked = '1'";
		if($querry_run=mysql_query($querry)){
			$querry_no_rows=mysql_num_rows($querry_run);
			if($querry_no_rows==0)
				echo '<br><center>No Requests Pending.</center>';
			else
			{
				echo '<form action="" method="post">';
				echo "<table class='bordered'>
	        			<thead>
	          				<tr>
	          					<th>Sr. No.</th>	
				              	<th>User Id</th>
				              	<th>Name</th>
				              	<th>Email</th>
				              	<th>Type</th>
				              	<th>Amount</th>
				              	<th>Applied On</th>
				              	<th>Image</th>
				              	<th colspan='3'><center>Approve/Disapprove<center></th>
	         				</tr>
	       				</thead>";
	       		$count=0;
	       		while($querry_row = mysql_fetch_assoc($querry_run))
	       		{	
	       			$count++;
	       			$id = $querry_row['id'];
	       			$userid=$querry_row['userid'];
	       			$q = "SELECT * FROM `users` WHERE `userid` = '".$userid."'";
	       			$q_run = mysql_query($q);
	       			$name = mysql_result($q_run, 0, 'name');
	       			$email = mysql_result($q_run, 0, 'email');
	       			$type = $Type[$querry_row['type']];
	       			$amount = $querry_row['amount'];
	       			$applied_on = $querry_row['applied_on'];
	       			$image = $querry_row['image'];

	       			echo '<tbody>
	       					<tr>
	       						<td>'.$count.'</td>
	       						<td>'.$userid.'</td>
	       						<td>'.$name.'</td>
	       						<td>'.$email.'</td>
	       						<td>'.$type.'</td>
	       						<td>'.$amount.'</td>
	       						<td>'.$applied_on.'</td>
	       						<td>'.$image.'</td>
	       						<td><input class="with-gap" name="'.$id.'" type="radio" id="'.$id.'1" value="approved" />
									<label for="'.$id.'1">Approve</label>
								</td>
								<td><input class="with-gap" name="'.$id.'" type="radio" id="'.$id.'2" value="disapproved" />
									<label for="'.$id.'2">Disapprove</label>
								</td>
								<td><input class="with-gap" name="'.$id.'" type="radio" id="'.$id.'3" value="skip" checked />
									<label for="'.$id.'3">Skip</label>
								<td>
							</tr>';
	       		}

	       		echo '</tbody>
						</table>
						<center>
						<button class="btn waves-effect waves-light" type="submit" name="submit">Submit
          				<i class="material-icons right">play_circle_filled</i>
          				</button>
          				</center>
          				</form>';

			}
		}

	}
}




?>