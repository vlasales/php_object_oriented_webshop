<?php
		//$environment = 'production';
		$environment = 'development';
    
		switch($environment){
			case 'development':
				//php info and version
				// prints e.g. 'Current PHP version: 4.1.1'
				echo 'Current PHP version: ' . phpversion();
	
				//pecho '<br>';
	
				// prints e.g. '2.0' or nothing if the extension isn't enabled
				//echo phpversion('tidy');
	
				//phpinfo();
				
				echo '<br>';
	
				//showing php errors
				echo 'Errors:';
				ini_set('display_errors', true);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);
				
				echo '<br>';
	
				print_r('SESSION: ');
				print_r($_SESSION); echo '<br>';
				print_r('GET: ');
				print_r($_GET); echo '<br>';
				print_r('POST: ');
				print_r($_POST); echo '<br>';
	
				echo 'login status: ';
				if(isset($_SESSION['uid'])){
					echo 'logged in';
				} else {
					echo 'not logged in';
				}
	
				echo '<br>';
				echo 'user status: ';
				if(isset($_SESSION['isAdmin'])){
					echo 'admin';
				} else {
					echo 'not admin';
				}
	
				//setting page title
				if(isset($_GET['id'])){
					$page_title = $_GET['id'];
				} else {
					$page_title = 'PHP webshop';
				}
			break;
			
			case 'production':
				//do nothing
				break;
				
			default:
				die('<h1>No environment set</h1>');
				break;
		}