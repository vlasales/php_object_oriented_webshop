<?php
class LogoutModel extends DBconn{
		protected function setLogout(){
            try{
            $logoutBtn = filter_input(INPUT_POST, 'logoutBtn');

            if(isset($logoutBtn)){
                if(isset($_SESSION['uid'])){
                    session_unset();
                    session_destroy();

                    //must start a session again to be able to display the message
                    session_start();
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>You are now logged out.</div>";
                    header('location: index.php');
                    exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>No userlogin set.</div>";
                header('location: index.php');
                exit();
            }
        } else {
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>No logout set.</div>";
            header('location: index.php');
            exit();
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    }
}