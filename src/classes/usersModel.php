<?php
class UsersModel extends DBconn{
    protected function getUsers(){
        $sql = "SELECT * FROM oopphp_users ORDER BY userID ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->bindParam(2, $userName, PDO::PARAM_STR);
        $stmt->bindParam(3, $userPasswordHash, PDO::PARAM_STR);
        $stmt->bindParam(4, $isAdmin, PDO::PARAM_INT);
        $stmt->execute();

        $usersCount = $stmt->rowCount();
        if($usersCount == 1){
            echo "<h2 class='w-100'>There is {$usersCount} user</h2>";
        } else {
            echo "<h2 class='w-100'>There are {$usersCount} users</h2>";
        }

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
            $sql = "SELECT * FROM oopphp_users WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
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
        if(isset($_SESSION['uid'])){
            $userID = $_SESSION['uid'];
        }

        if(isset($userID)){
            $sql = "SELECT * FROM oopphp_users WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
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
        $stmt->bindParam(4, $isAdmin, PDO::PARAM_INT);
        $stmt->execute();

        $usersCount = $stmt->rowCount();
        if($usersCount == 1){
            echo "<h2 class='w-100'>There is {$usersCount} admin user</h2>";
        } else {
            echo "<h2 class='w-100'>There are {$usersCount} admin users</h2>";
        }

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
        $stmt->bindParam(4, $isAdmin, PDO::PARAM_INT);
        $stmt->execute();

        $usersCount = $stmt->rowCount();
        if($usersCount == 1){
            echo "<h2 class='w-100'>There is {$usersCount} normal user</h2>";
        } else {
            echo "<h2 class='w-100'>There are {$usersCount} normal users</h2>";
        }

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
        $newUserBtn = filter_input(INPUT_POST, 'newUserBtn');

        if(isset($newUserBtn)){
        $userName = htmlentities(filter_input(INPUT_POST, 'newUsername'));
        $userPassword = htmlentities(filter_input(INPUT_POST, 'newUserpassword'));
        $userPasswordHash = password_hash($userPassword, PASSWORD_DEFAULT);

        //file
        $maxFileSize = 80000000;
        $imageName = $_FILES["newUserImage"]["name"];
	    $target_dir = "images/imagesUsers/";
        $target_file = $target_dir . basename($imageName);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $extensions_arr = array("jpg","jpeg","png");

        if(!file_exists($target_file)){
            if(in_array($imageFileType, $extensions_arr)){
                if(($_FILES["newUserImage"]["size"] >= $maxFileSize) || ($_FILES["newUserImage"]["size"] == 0)) {
                    $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File too large. {$maxFileSize}KB is the max file size.</div>";
                    header('location: signup.php');
                } else {
                    if(move_uploaded_file($_FILES["newUserImage"]["tmp_name"],$target_file)){
                        $imageUpload = $target_file;
                    } else {
                        $_SESSION["sessMSG"] = "<div class='alert alert-danger'>Error. Image '{$imageName}' not uploaded.</div>";
                        header('location: signup.php');
                    }
                }
            } else {
                $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File extension must be jpg, png or jpeg. '{$imageFileType}' is not a valid extension.</div>";
                header('location: signup.php');
            }
        } else {
            $_SESSION["sessMSG"] = "<div class='alert alert-danger'>A file with the name '{$imageName}' already exists. Please choose another name.</div>";
            header('location: signup.php');
        }

            $sql = "INSERT INTO oopphp_users(userName, userPassword_hash, userImagePath) VALUES (?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userName, PDO::PARAM_STR);
            $stmt->bindParam(2, $userPasswordHash, PDO::PARAM_STR);
            $stmt->bindParam(3, $imageUpload, PDO::PARAM_STR);
            $stmt->execute();
        

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
        $deleteUserBtn = filter_input(INPUT_POST, 'deleteUserBtn');

        if(isset($deleteUserBtn)){
        try{
            $pdo = $this->connect();

            //begin transaction
            $pdo->beginTransaction();

            $userID = filter_input(INPUT_POST, 'deleteUserID');
            

            if($userID == 1){
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>This user is the root admin and cannot be deleted</div>"; 
                header("location: users.php");
            } else {
                $sql = "DELETE FROM oopphp_users WHERE userID = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $userID, PDO::PARAM_INT);
                $stmt->execute();
            }

            //delete wishlist if user deletes account
            $userID_fk = filter_input(INPUT_POST, 'deleteUserID');

            $sql = "DELETE FROM oopphp_wishlist WHERE userID_fk = ?";
            $stmt2 = $pdo->prepare($sql);
            $stmt2->bindParam(1, $userID_fk, PDO::PARAM_INT);
            $stmt2->execute();

            $pdo->commit();

            //delete image
            $deleteUserImage = htmlentities(filter_input(INPUT_POST, 'deleteUserImage'));
            unlink($deleteUserImage);

        }
        catch(Exception $e){
            $pdo->rollBack();
            echo $e->getMessage();
        }
        finally{
            //destory session if the user deletes own account. or else the session will still have the user info saved
            if(isset($_SESSION['uid']) && $_SESSION['uid'] == $userID){
                session_unset();
                session_destroy();

                //start it again to be able to display messages
                session_start();
            }
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
    }

    //delete image
    protected function setDeleteImage(){
        $deleteImageBtn = filter_input(INPUT_POST, 'deleteImageBtn');
        
        if(isset($deleteImageBtn)){
            $userID = htmlentities(filter_input(INPUT_POST, 'deleteUserImageID'));

            //deleting image is actually an update. or else you delete the whole user
            $sql = "UPDATE oopphp_users SET userImagePath = null WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
            $stmt->execute();

            $deleteImageUser = htmlentities(filter_input(INPUT_POST, 'deleteImageUser'));
            unlink($deleteImageUser);

            if(isset($deleteImageBtn)){
                if($stmt->rowCount() > 0){
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} image deleted.</div>"; 
                    header("location: users.php");
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} image not deleted.</div>"; 
                    header("location: users.php");
                }
            }
        }
    }

    //update general
    protected function setUpdateUser(){
        $updateUserBtn = filter_input(INPUT_POST, 'updateUserBtn');

        if(isset($updateUserBtn)){
            $maxFileSize = 80000000;
            $imageName = $_FILES["updateUserImage"]["name"];
            $target_dir = "images/imagesUsers/";
            $target_file = $target_dir . basename($imageName);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png");
    
            if(!file_exists($target_file)){
                if(in_array($imageFileType, $extensions_arr)){
                    if(($_FILES["updateUserImage"]["size"] >= $maxFileSize) || ($_FILES["updateUserImage"]["size"] == 0)) {
                        $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File too large. {$maxFileSize}KB is the max file size.</div>";
                        header('location: signup.php');
                    } else {
                        if(move_uploaded_file($_FILES["updateUserImage"]["tmp_name"],$target_file)){
                            $imageUpload = $target_file;
                        } else {
                            $_SESSION["sessMSG"] = "<div class='alert alert-danger'>Error. Image '{$imageName}' not uploaded.</div>";
                            header('location: signup.php');
                        }
                    }
                } else {
                    $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File extension must be jpg, png or jpeg. '{$imageFileType}' is not a valid extension.</div>";
                    header('location: signup.php');
                }
            } else {
                $_SESSION["sessMSG"] = "<div class='alert alert-danger'>A file with the name '{$imageName}' already exists. Please choose another name.</div>";
                header('location: signup.php');
            }

        $userID = htmlentities(filter_input(INPUT_POST, 'updateUserID'));
        $userName = htmlentities(filter_input(INPUT_POST, 'updateUserName'));
        
        if(isset($imageUpload)){
            $sql = "UPDATE oopphp_users SET userName = ?, userImagePath = ? WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userName, PDO::PARAM_STR);
            $stmt->bindParam(2, $imageUpload, PDO::PARAM_STR);
            $stmt->bindParam(3, $userID, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $sql = "UPDATE oopphp_users SET userName = ? WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userName, PDO::PARAM_STR);
            $stmt->bindParam(2, $userID, PDO::PARAM_INT);
            $stmt->execute();
        }
        
        //only delete image if there is an upload file
        $updateUserRemove = htmlentities(filter_input(INPUT_POST, 'updateUserRemove'));
        if(isset($imageUpload)){
            unlink($updateUserRemove);
        }
        
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
        $makeAdminBtn = filter_input(INPUT_POST, 'userMakeAdmin');

        if(isset($makeAdminBtn)){
        $userID = filter_input(INPUT_POST, 'userIDMakeAdmin');

        $sql = "UPDATE oopphp_users SET isAdmin = 1 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        
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
        $removeAdminBtn = filter_input(INPUT_POST, 'userRemoveAdmin');

        if(isset($removeAdminBtn)){
        $userID = filter_input(INPUT_POST, 'userIDRemoveAdmin');
    
        if($userID == 1){
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>This user is the root admin and cannot be removed as admin.</div>"; 
            header("location: users.php");
        } else {
        $sql = "UPDATE oopphp_users SET isAdmin = 0 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        
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

/*
delete original:
$userID = filter_input(INPUT_POST, 'deleteUserID');
        $deleteUserBtn = filter_input(INPUT_POST, 'deleteUserBtn');

        if(isset($deleteUserBtn)){
        if($userID == 1){
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>This user is the root admin and cannot be deleted</div>"; 
            header("location: users.php");
        } else {
        $sql = "DELETE FROM oopphp_users WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} deleted.</div>"; 
                header("location: users.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not deleted.</div>"; 
                header("location: users.php");
            }
        }
        }
*/