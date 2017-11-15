<?php
$date1 = new DateTime("2009-06-28 02:30:00");
$date2 = new DateTime("2009-06-27 02:30:00");
// echo $date1->date;
$interval = $date1->diff($date2);
echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
echo "<br>"."h : ".$interval->h." m:".$interval->i." s:".$interval->s."<br>";
// shows the total amount of days (not divided into years, months and days like above)
echo "difference " . $interval->days . " days ";
?>