<?php
//tag to mark the beginning of a php code

// Database connection
$host = "localhost";
//$host is a variable that contains the host name which is localhost
//"Localhost" is a hostname that refers to the current device used to access it
$database = "online_enrollment";
//$database is a variable that contains the name of the db being used
$username = "omao";
//$username is a variable containing the name of the user logged in to the db ie omao in this case
$password = "omao";
//$password variable contains the password of the db user
$conn = mysqli_connect($host, $username, $password, $database);
//$conn variable contains the function that executes the database connection

// Check the connection
if (!$conn) {
    //statement that checks the non-existense of the connection
    //! means not/negates
    die("Connection failed: " . mysqli_connect_error());
    //die() function is used to terminate the script's execution and display a message to the user which is Connection failed 
    //. is used to concatenate the first message and the connection error message
    //mysqli_connect_error() function is used to retrieve the last error message from the most recent MySQLi connection attempt
} else {
    //checks for the opposite statement that is the existense of the connection
    return "Connection success";
    //prints the output which is a success message to show that the connection has been established
}

//tag to mark the end of a php code/db connection code
?>
