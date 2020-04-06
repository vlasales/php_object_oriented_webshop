<?php

class Functions{
    //general crud msg
    public function session_message(){
        if(isset($_SESSION['sessMSG'])){
            echo $_SESSION['sessMSG'];
            unset($_SESSION["sessMSG"]);
        }
    }

    //redirect if not logged in
    public function redirectNotLoggedIn(){
        if(!isset($_SESSION['uid'])){
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>You must have an account and be logged in to see your account.</div>"; 
            header("location: signup.php");
        }
    }
}