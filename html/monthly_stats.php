<?php

/*$con = mysql_connect("localhost","masmallc_scas","LWn-tmX-ETv-N7M");
if (!$con)
  {
  die('Could not connect to MySQL Database: ' . mysql_error());
  }
$db_selected = mysql_select_db('masmallc_scas', $con);
if (!$db_selected) {
    die ('Can\'t connect to Database: ' . mysql_error());
}*/

require("../includes/config.php"); 

$month = date("m");
$year = date("Y");
$text_month = date("F");

$query = "SELECT * "
			. "FROM i3_Log "
			. "WHERE Login LIKE '".$year."-".$month."%'";
			
$query_clients = "SELECT ClientID FROM dbi4_Contacts WHERE ContactDate LIKE '".$year."-".$month."%'";

$query_unique_clients = "SELECT ClientID FROM dbi4_Contacts WHERE ContactDate LIKE '".$year."-".$month."%' GROUP BY(ClientID)";
			
$users = query($query);
$num_clients = count(query($query_clients));
$num_unique_clients = count(query($query_unique_clients));

$total = 0;

$vol = array();
foreach($users as $row) {
    $secs = strtotime($row['LastAction']) - strtotime($row['Login']);

	if (array_key_exists($row['UserID'],$vol))
	{
		$vol[$row['UserID']] += $secs;
	}
	else
	{
		$vol[$row['UserID']] = $secs;
	}

	$total += $secs;
    
}

arsort($vol);

$hours = floor($total / 3600);
$minutes = floor(($total / 60) % 60);
$seconds = $total % 60;

// get users that have been active in past month
$active_users = array();

foreach($vol as $key => $value) {
    $usernames_query = "SELECT * "
			        . "FROM i3_Users "
		        	. "WHERE UserID=".$key." LIMIT 1";  
	
	$result = query($usernames_query);
	
	// just 1 result so won't be too slow
	foreach($result as $row)
	{
	    $active_time = '';
	    if ($value > 10) {
    	    $user_hours = floor($value / 3600);
        	$user_minutes = floor(($value / 60) % 60);
        	$user_seconds = $value % 60.;
            
            $user_hours = $user_hours == 0 ? "": $user_hours."h";
            $user_minutes = $user_minutes == 0 ? "": $user_minutes."m";
            $user_seconds .= "s";
            
            $active_time .= $user_hours." ".$user_minutes." ".$user_seconds;
        	
        	$active_users[$row['UserName']] = $active_time;
	    }
	}
}

render("monthly_stats_form.php", array("title" => "Monthly Stats", 
		"users" => $users, "client_count" => $num_clients, "unique_client_count" => $num_unique_clients,
		"hours" => $hours, "minutes" => $minutes, "seconds" => $seconds,
        "active_users"=> $active_users));
?>