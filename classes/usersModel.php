<?php
class UsersModel extends DBconn{
    protected function getUsers(){
        $sql = "SELECT * FROM oopphp_users ORDER BY userID ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->bindParam(2, $userName, PDO::PARAM_STR);
        $stmt->bindParam(3, $userPasswordHash, PDO::PARAM_STR);
        //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
        $stmt->execute();

        $usersCount = $stmt->rowCount();
        echo '<h2 class="w-100">There are ' . $usersCount . ' users</h2>';

        if($stmt->rowCount() > 0 ){
            $results = $stmt->fetchAll();
            return $results;
        } else {
            //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>No users in the database.</div>";
            //header("location: users.php");
        }
    }
    //specific user
    protected function getUserWhere(){
        $userID = filter_input(INPUT_GET, 'id');

        if(isset($userID)){
            //$userID = $_GET['id'];

            $sql = "SELECT * FROM oopphp_users WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
            //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0 ){
                $results = $stmt->fetchAll();
                return $results;
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>A user with the ID of {$userID} does not exist.</div>"; 
                header("location: users.php");
            }
        } else {
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>No user ID selected.</div>"; 
            header("location: users.php");
        }
        
    }

    //specific user for my-account.php
    protected function getMyUser(){
        $userID = $_SESSION['uid'];

        if(isset($userID)){

            $sql = "SELECT * FROM oopphp_users WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
            //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0 ){
                $results = $stmt->fetchAll();
                return $results;
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>A user with the ID of {$userID} does not exist.</div>"; 
                header("location: users.php");
            }
        }
        
    }

    //user where admin
    protected function getUsersAdmin(){
        $sql = "SELECT * FROM oopphp_users WHERE isAdmin = 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->bindParam(2, $userName, PDO::PARAM_STR);
        $stmt->bindParam(3, $userPasswordHash, PDO::PARAM_STR);
        //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
        $stmt->execute();

        $usersCount = $stmt->rowCount();
        echo '<h2 class="w-100">There are ' . $usersCount . ' admins</h2>';

        if($stmt->rowCount() > 0){
            $results = $stmt->fetchAll();
            return $results;
        } else {
            //$_SESSION['userMSGNoAdmins'] = "<div class='alert alert-danger'>No admin users.</div>"; 
            //header("location: users.php");
        }
    }
    //user where not admin
    protected function getUsersNotAdmin(){
        $sql = "SELECT * FROM oopphp_users WHERE isAdmin = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->bindParam(2, $userName, PDO::PARAM_STR);
        $stmt->bindParam(3, $userPasswordHash, PDO::PARAM_STR);
        //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
        $stmt->execute();

        $usersCount = $stmt->rowCount();
        echo '<h2 class="w-100">There are ' . $usersCount . ' normal users</h2>';

        if($stmt->rowCount() > 0){
            $results = $stmt->fetchAll();
            return $results;
        } else {
            //$_SESSION['userMSGNoNormalUsers'] = "<div class='alert alert-danger'>No normal users.</div>"; 
            //header("location: users.php");
        }
    }

    //insert
    protected function setUser(){
        $userName = htmlentities(filter_input(INPUT_POST, 'newUsername'));
        $userPassword = htmlentities(filter_input(INPUT_POST, 'newUserpassword'));
        $userPasswordHash = password_hash($userPassword, PASSWORD_DEFAULT);

        $newUserBtn = filter_input(INPUT_POST, 'newUserBtn');

        if(isset($newUserBtn)){
            $sql = "INSERT INTO oopphp_users(userName, userPassword_hash) VALUES (?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userName, PDO::PARAM_STR);
            $stmt->bindParam(2, $userPasswordHash, PDO::PARAM_STR);
            $stmt->execute();
        }

        if(isset($newUserBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with name {$userName} created.</div>"; 
                header("location: users.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Username must be unique and the name {$userName} is already taken.</div>"; 
                header("location: users.php");
            }
        }
    }

    //delete
    protected function setDeleteUser(){
        $userID = filter_input(INPUT_POST, 'deleteUserID');
        $deleteUserBtn = filter_input(INPUT_POST, 'deleteUserBtn');

        if($userID == 1){
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>This user is the root admin and cannot be deleted</div>"; 
            header("location: users.php");
        } else {
        $sql = "DELETE FROM oopphp_users WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        if(isset($deleteUserBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} deleted.</div>"; 
                header("location: users.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not deleted.</div>"; 
                header("location: users.php");
            }
        }
        }
    }

    //update general
    protected function setUpdateUser(){
        $userID = htmlentities(filter_input(INPUT_POST, 'updateUserID'));
        $userName = htmlentities(filter_input(INPUT_POST, 'updateUserName'));
        $updateUserBtn = filter_input(INPUT_POST, 'updateUserBtn');

        $sql = "UPDATE oopphp_users SET userName = ? WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userName, PDO::PARAM_STR);
        $stmt->bindParam(2, $userID, PDO::PARAM_INT);
        $stmt->execute();

        if(isset($updateUserBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} updated.</div>"; 
                header("location: users.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not updated.</div>"; 
                header("location: users.php");
            }
        }
    }

    //update - make admin
    protected function setUserAdmin(){
        $userID = filter_input(INPUT_POST, 'userIDMakeAdmin');
        $makeAdminBtn = filter_input(INPUT_POST, 'userMakeAdmin');

        $sql = "UPDATE oopphp_users SET isAdmin = 1 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        if(isset($makeAdminBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} is now an admin.</div>"; 
                header("location: users.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} may already be admin.</div>"; 
                header("location: users.php");
            }
        }
    }

    //update - remove admin
    protected function setUserRemoveAdmin(){
        $userID = filter_input(INPUT_POST, 'userIDRemoveAdmin');
        $makeAdminBtn = filter_input(INPUT_POST, 'userRemoveAdmin');

        if($userID == 1){
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>This user is the root admin and cannot be removed as admin.</div>"; 
            header("location: users.php");
        } else {
        $sql = "UPDATE oopphp_users SET isAdmin = 0 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        if(isset($makeAdminBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} is no longer an admin.</div>"; 
                header("location: users.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} may already not be admin.</div>"; 
                header("location: users.php");
            }
        }
    }
}
}