<?php
include 'init.php';

//include error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//shorten and submit URL
if(isset($_POST['button_1']))
{
	$orig_url = $_POST['url'];
	
	//generate unique and random 6 characters long shortcode
	$rand = substr(md5(microtime()), rand(0,26),6);
	
	echo "your short link is: <br>";
	
	//make shortcode clickable and referenceable
	echo '<a href="'; echo $orig_url;  echo '"target="_blank">'; echo ''.$rand.'</a>';
	
	//use prepared statements for SQL Injection prevention
	$stmt = $conn->prepare("insert into urls (link_to_page, shortcode) values (?, ?)");
	$stmt->bind_param('ss', $orig_url, $rand);
	$stmt->execute();

	echo "<br> If entered URL is already in the listing, it won't be added.";
}

//listing shortcodes from database
if(isset($_POST['button_2']))
{
	$query = "select shortcode, link_to_page, date_created from urls";	
	$result = mysqli_query($conn, $query);
		
	//query data and fetch each array element
	while($row = mysqli_fetch_array($result)){
		echo '<a href="'; echo $row['link_to_page']; echo '"target="_blank">' .$row['shortcode'].'</a> 
		Creation Date: '.$row['date_created'].'<br>';	
	}
}

//customize and submit shorten URL
if(isset($_POST['button_3']))
{
	$shortcode = $_POST['url_1'];
	$url = $_POST['url'];
	
	//Submitted shortcode must be at least 4 characters long 
	if(strlen($shortcode) >= 4)
	{
		$stmt = $conn->prepare("update urls set shortcode = ? where link_to_page = ?");
		$stmt->bind_param('ss', $shortcode, $url);
		$stmt->execute();
		echo "Customization successful. If there already exists a shortcode in the listing, customization won't be done.";
	}
	else
	{
		echo "Submitted shortcode must be at least 4 characters long.";
	}	
}



?>