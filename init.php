<?php

//set your MySQL database credentials
$username="root";
$password="";
$hostname="localhost";
$dbname="shortster_schema";

/*Creating a connection*/
$conn= new mysqli($hostname, $username, $password, $dbname);

/*If there are errors, print error message*/
if($conn->connect_error)
{
	die("Connection failed");
}

?>