<?php
// start session
session_start();

// link to database
$dbLink = mysql_connect('localhost', 'pmunc', 'pmunctechteam');
if (!$dbLink)
        die('Can\'t establish a connection to the database: ' . mysql_error());

$dbSelected = mysql_select_db('pmunc', $dbLink);
if (!$dbSelected)
        die('Connected, but table is inaccessible: ' . mysql_error());

// check if user is authenticated
$isUserLoggedIn = false;
$query = 'SELECT * FROM users WHERE session_id = "' . session_id() . '" LIMIT 1';
$userResult = mysql_query($query);
if(mysql_num_rows($userResult) == 1){
        $_SESSION['user'] = mysql_fetch_assoc($userResult);
        $isUserLoggedIn = true;
        if(basename($_SERVER['PHP_SELF']) == 'signin.php') {
        	header('Location: dashboard.php');
        	exit;
        }
}
else {
        if(basename($_SERVER['PHP_SELF']) != 'signin.php'){
                header('Location: signin.php');
                exit;
        }
}
?>