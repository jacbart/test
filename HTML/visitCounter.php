<?php
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	//heroku database things

	$elemid = $_REQUEST['elemid'];

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);

	// Connects to your Database 
	//this should connect to heroku sql
	
    // $connect = mysqli_connect("localhost", "root", "pass", "heroku_418f9cc765f4922");
    $connect = mysqli_connect($server,$username,$password,$db);
    if(!$connect)
	{
		die(mysqli_error($connect).'because'.mysqli_errno($connect));
	}

	$query = "select resource,visit from resources where id=".$elemid.";";
	$result = mysqli_query($connect, $query);
	if(!$result)
	{
		die('Could query data: '.mysqli_error($connect).' because '.mysqli_errno($connect));
	}

	  
	while ($row = mysqli_fetch_array($result))
	{
		$newVisit = $row[1] + 1;
		$update = "update resources set visit=".$newVisit." where id=".$elemid.";";
		$upResult = mysqli_query($connect,$update);
		if(!$upResult){		
			die('Could query data: '.mysqli_error($connect).' because '.mysqli_errno($connect));
		}
		header("Location: ".$row[0]."");
	}
	mysqli_close($connect);
?>