<?php
//$environment = 'production';
$environment = 'development';

switch($environment){
	case 'development':
	ob_start();

	//php info and version
	// prints e.g. 'Current PHP version: 4.1.1'
	echo 'Current PHP version: ' . phpversion();

	echo '<br>';

	//showing php errors
	echo 'Errors:'; echo '<br>';
	ini_set('display_errors', true);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	echo '<br>';

	//show what is saved in superglobals
	echo 'SESSION: ';
	print_r($_SESSION); echo '<br>';
	echo 'GET: ';
	print_r($_GET); echo '<br>';
	echo 'POST: ';
	print_r($_POST); echo '<br>';
	echo 'FILES: ';
	print_r($_FILES); echo '<br>';

	//get login status
	echo 'login status: ';
	if(isset($_SESSION['uid'])){
	echo 'logged in';
	} else {
	echo 'not logged in';
	}

	//get user permissions
	echo '<br>';
	echo 'user status: ';
	if(isset($_SESSION['isAdmin'])){
	echo 'admin';
	} else {
	echo 'not admin';
	}

	break;

	case 'production':
	//fix for "Warning: Cannot modify header information - headers already sent by". ONLY SHOWS ONLINE AND NOT LOCALLY
	ob_start();
	break;

	default:
	die('<h1>No environment set</h1>');
	break;
}