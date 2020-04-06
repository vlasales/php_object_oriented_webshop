<?php
class LogoutModel extends DBconn{
		protected function setLogout(){
            if(isset($_POST['logoutBtn'])){
                if(isset($_SESSION['uid'])){
                    session_unset();
                    session_destroy();

                    //must start a session again to be able to display the message
                    session_start();
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>You are now logged out.</div>";
                    header('location:index.php');
            } else {
                ?><h1 class="alert alert-danger">No userlogin set.</h1><?php
            }
        } else {
            ?><h1 class="alert alert-danger">You are not logged in.</h1><?php
        }
    }
}