<?php
class UsersModel extends DBconn{
    protected function getUsers(){
        try{
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
    catch(Exception $e){
        echo $e->getMessage();
    }
    }

    //specific user
    protected function getUserWhere(){
        try{
        $userID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

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
                exit();
            }
        } else {
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>No user ID selected.</div>"; 
            header("location: users.php");
            exit();
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    }

    //specific user for account.php
    protected function getMyUser(){
        try{
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
                exit();
            }
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    }

    //user where admin
    protected function getUsersAdmin(){
        try{
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
    catch(Exception $e){
        echo $e->getMessage();
    }
    }
    //user where not admin
    protected function getUsersNotAdmin(){
        try{
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
    catch(Exception $e){
        echo $e->getMessage();
    }
    }

    //insert
    protected function setUser(){
        try{
        $newUserBtn = filter_input(INPUT_POST, 'newUserBtn');

        if(isset($newUserBtn)){
        $userName = filter_input(INPUT_POST, 'newUsername', FILTER_SANITIZE_STRING);
        $userPassword = filter_input(INPUT_POST, 'newUserpassword', FILTER_SANITIZE_STRING);
        $userPasswordHash = password_hash($userPassword, PASSWORD_DEFAULT);

        //file
        $maxFileSize = 80000000;
        $unixTimeStamp = new DateTime();
        $imageName = $unixTimeStamp->getTimestamp() . '-' . $_FILES["newUserImage"]["name"];
        $target_dir = "images/imagesUsers/";
        $target_file = $target_dir . basename($imageName);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $extensions_arr = array("jpg","jpeg","png");

        if(!file_exists($target_file)){
            if(in_array($imageFileType, $extensions_arr)){
                if(($_FILES["newUserImage"]["size"] >= $maxFileSize) || ($_FILES["newUserImage"]["size"] == 0)) {
                    $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File too large. {$maxFileSize}KB is the max file size.</div>";
                    header('location: signup.php');
                    exit();
                } else {
                    $imageUpload = $target_file;
                }
            } else {
                if(isset($imageUpload)){
                    $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File extension must be jpg, png or jpeg. '{$imageFileType}' is not a valid extension.</div>";
                    header('location: signup.php');
                    exit();
                }
            }
        } else {
            //will probably never show, due to timestamps
            $_SESSION["sessMSG"] = "<div class='alert alert-danger'>A file with the name '{$imageName}' already exists. Please choose another name.</div>";
            header('location: signup.php');
            exit();
        }

            if(isset($imageName)){
                $sql = "INSERT INTO oopphp_users(userName, userPassword_hash, userImagePath) VALUES (?,?,?)";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(1, $userName, PDO::PARAM_STR);
                $stmt->bindParam(2, $userPasswordHash, PDO::PARAM_STR);
                $stmt->bindParam(3, $imageUpload, PDO::PARAM_STR);
                $stmt->execute();

                move_uploaded_file($_FILES["newUserImage"]["tmp_name"], $target_file);
            } else {
                $sql = "INSERT INTO oopphp_users(userName, userPassword_hash) VALUES (?,?)";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(1, $userName, PDO::PARAM_STR);
                $stmt->bindParam(2, $userPasswordHash, PDO::PARAM_STR);
                $stmt->execute();
            }
            
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    finally{
        if(isset($newUserBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with name {$userName} created.</div>"; 
                header("location: signup.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Username must be unique and the name {$userName} is already taken.</div>"; 
                header("location: signup.php");
                exit();
            }
        }
    }
    }

    //delete
    protected function setDeleteUser(){
        try{
        $deleteUserBtn = filter_input(INPUT_POST, 'deleteUserBtn');

        if(isset($deleteUserBtn)){
        
            $pdo = $this->connect();

            //begin transaction
            $pdo->beginTransaction();

            $userID = filter_input(INPUT_POST, 'deleteUserID', FILTER_VALIDATE_INT);
            

                $sql = "DELETE FROM oopphp_users WHERE userID = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $userID, PDO::PARAM_INT);
                $stmt->execute();
            

            //delete wishlist if user deletes account
            $userID_fk = filter_input(INPUT_POST, 'deleteUserID', FILTER_VALIDATE_INT);

            $sql = "DELETE FROM oopphp_wishlist WHERE userID_fk = ?";
            $stmt2 = $pdo->prepare($sql);
            $stmt2->bindParam(1, $userID_fk, PDO::PARAM_INT);
            $stmt2->execute();

            $pdo->commit();

            //delete image
            $deleteUserImage = filter_input(INPUT_POST, 'deleteUserImage', FILTER_SANITIZE_STRING);
            unlink($deleteUserImage);


        }
    }
        catch(Exception $e){
            $pdo->rollBack();
            echo $e->getMessage();
        }
        finally{
            //destory session if the user deletes own account. or else the session will still have the user info saved
            if(isset($deleteUserBtn)){
                if(isset($_SESSION['uid']) && $_SESSION['uid'] == $userID){
                    session_unset();
                    session_destroy();
    
                    //start it again to be able to display messages
                    session_start();
                }
            }
            if(isset($deleteUserBtn)){
                if($stmt->rowCount() > 0){
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} deleted.</div>"; 
                    header("location: users.php");
                    exit();
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not deleted.</div>"; 
                    header("location: users.php");
                    exit();
                }
            }
        }
    
    }

    //delete image
    protected function setDeleteUserImage(){
        try{
        $deleteImageBtn = filter_input(INPUT_POST, 'deleteImageUserBtn');
        
        if(isset($deleteImageBtn)){
            $userID = filter_input(INPUT_POST, 'deleteUserImageID', FILTER_VALIDATE_INT);

            //deleting image is actually an update. or else you delete the whole user
            $sql = "UPDATE oopphp_users SET userImagePath = null WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
            $stmt->execute();

            $deleteImageUser = filter_input(INPUT_POST, 'deleteImageUser', FILTER_SANITIZE_STRING);
            unlink($deleteImageUser);
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    finally{
        if(isset($deleteImageBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} image deleted.</div>"; 
                header("location: account.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} image not deleted.</div>"; 
                header("location: account.php");
                exit();
            }
        }
    }
    }

    //update general
    protected function setUpdateUser(){
        try{
        $updateUserBtn = filter_input(INPUT_POST, 'updateUserBtn');

        if(isset($updateUserBtn)){
            $maxFileSize = 80000000;
            $unixTimeStamp = new DateTime();
            $imageName = $unixTimeStamp->getTimestamp() . '-' . $_FILES["updateUserImage"]["name"];
            $target_dir = "images/imagesUsers/";
            $target_file = $target_dir . basename($imageName);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png");
    
            if(!file_exists($target_file)){
                if(in_array($imageFileType, $extensions_arr)){
                    if(($_FILES["updateUserImage"]["size"] >= $maxFileSize) || ($_FILES["updateUserImage"]["size"] == 0)) {
                        $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File too large. {$maxFileSize}KB is the max file size.</div>";
                        header('location: account.php');
                    } else {
                            $imageUpload = $target_file;
                    }
                } else {
                    if(isset($imageUpload)){
                        $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File extension must be jpg, png or jpeg. '{$imageFileType}' is not a valid extension.</div>";
                        header('location: account.php');
                        exit();
                    }
                }
            } else {
                $_SESSION["sessMSG"] = "<div class='alert alert-danger'>A file with the name '{$imageName}' already exists. Please choose another name.</div>";
                header('location: account.php');
                exit();
            }

        $userID = filter_input(INPUT_POST, 'updateUserID', FILTER_VALIDATE_INT);
        $userName = filter_input(INPUT_POST, 'updateUserName', FILTER_SANITIZE_STRING);
        
        if(isset($imageUpload)){
            $sql = "UPDATE oopphp_users SET userName = ?, userImagePath = ? WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userName, PDO::PARAM_STR);
            $stmt->bindParam(2, $imageUpload, PDO::PARAM_STR);
            $stmt->bindParam(3, $userID, PDO::PARAM_INT);
            $stmt->execute();

            move_uploaded_file($_FILES["updateUserImage"]["tmp_name"], $target_file);
        } else {
            $sql = "UPDATE oopphp_users SET userName = ? WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userName, PDO::PARAM_STR);
            $stmt->bindParam(2, $userID, PDO::PARAM_INT);
            $stmt->execute();
        }

        
        //only delete image if there is an upload file
        $updateUserRemove = filter_input(INPUT_POST, 'updateUserRemove', FILTER_SANITIZE_STRING);
        if(isset($imageUpload)){
            unlink($updateUserRemove);
        }
        
            
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    finally{
        if(isset($updateUserBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} updated.</div>"; 
                header("location: account.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not updated.</div>"; 
                header("location: account.php");
                exit();
            }
        }
    }
    }

    //update - make admin
    protected function setUserAdmin(){
        try{
        $makeAdminBtn = filter_input(INPUT_POST, 'userMakeAdmin');

        if(isset($makeAdminBtn)){
        $userID = filter_input(INPUT_POST, 'userIDMakeAdmin', FILTER_VALIDATE_INT);

        $sql = "UPDATE oopphp_users SET isAdmin = 1 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();
        }
    }
        catch(Exception $e){
            echo $e->getMessage();
        }
        finally{
            if(isset($makeAdminBtn)){
                if($stmt->rowCount() > 0){
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} is now an admin.</div>"; 
                    header("location: users.php");
                    exit();
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} may already be admin.</div>"; 
                    header("location: users.php");
                    exit();
                }
            }
        }

        
            
    }
    

    //update - remove admin
    protected function setUserRemoveAdmin(){
        try{
        $removeAdminBtn = filter_input(INPUT_POST, 'userRemoveAdmin');

        if(isset($removeAdminBtn)){
        $userID = filter_input(INPUT_POST, 'userIDRemoveAdmin', FILTER_VALIDATE_INT);
    
        if($userID == 1){
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>This user is the root admin and cannot be removed as admin.</div>"; 
            header("location: users.php");
            exit();
        } else {
        $sql = "UPDATE oopphp_users SET isAdmin = 0 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();
        }
    }
}
        catch(Exception $e){
            echo $e->getMessage();
        }
        finally{
            if(isset($removeAdminBtn)){
                if($stmt->rowCount() > 0){
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} is no longer an admin.</div>"; 
                    header("location: users.php");
                    exit();
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} may already not be admin.</div>"; 
                    header("location: users.php");
                    exit();
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