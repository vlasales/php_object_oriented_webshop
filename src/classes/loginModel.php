<?php
class LoginModel extends DBconn{
    protected function getLoginInfo(){
        try{
        $loginBtn = filter_input(INPUT_POST, 'loginBtn');

        if(isset($loginBtn)){
        $userName = filter_input(INPUT_POST, 'loginName');
        $userPassword = filter_input(INPUT_POST, 'loginPassword');
 
        $sql = "SELECT * FROM oopphp_users WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userName, PDO::PARAM_STR);
        $stmt->bindColumn('userID', $userID, PDO::PARAM_INT);
        $stmt->bindColumn('userName', $userName, PDO::PARAM_STR);
        $stmt->bindColumn('userPassword_hash', $userPassword_hash, PDO::PARAM_STR);
        $stmt->bindColumn('isAdmin', $isAdmin, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetch();
        //return $results;

            if($stmt->rowCount() > 0){
                if(password_verify($userPassword, $userPassword_hash)){
                    $_SESSION['uid'] = $userID;
                    $_SESSION['un'] = $userName;
                    if($isAdmin == 1){
                        $_SESSION['isAdmin'] = $isAdmin;
                    }
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>Your are now logged in</div>";
                    header('location: my-account.php');
                    exit();
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Wrong username/password combination.</div>";
                    header('location: signup.php');
                    exit();
                }
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>No user with that username exists. Try another username.</div>";
                header('location: signup.php');
                exit();
            }
        } else {
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>No login set</div>";
            header('location: signup.php');
            exit();
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    }
}