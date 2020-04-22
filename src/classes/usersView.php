<?php
class UsersView extends UsersModel{
    public function showUsers(){
        $results = $this->getUsers();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <p><?php echo $result['userID']; ?></p>
                <p><?php echo $result['userName']; ?></p>
                <?php
                    if($result['userImagePath'] == null){
                        ?>
                        <img src="https://via.placeholder.com/300/f2f2f2/000000/?text=No image for user">
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo $result['userImagePath']; ?>">
                        <?php
                    }
                ?>
                <p><?php echo $result['userPassword_hash']; ?></p>
                <p><?php echo $result['isAdmin']; ?></p>
                <form method="GET" action="user.php">
                    <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                    <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
                </form>
                <?php
                if(isset($_SESSION['isAdmin'])){
                    if($result['isAdmin'] == 0){
                        ?>
                        <form method="POST" action="users.php">
                            <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
                        </form>
                <?php
                    } else {
                        
                        if($result['userID'] == 1){
                            //must have an empty if. if i do if(!$result..) then the form is not shown
                            ?>
                            
                        <?php
                        } else {
                            ?>
                            <form method="POST" action="users.php">
                                <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                                <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
                            </form>
                        <?php
                        }
                        ?>
                <?php
                    }
                    ?>
                <?php
                }
                ?>
                <?php
                if(isset($_SESSION['isAdmin'])){
                    if($result['userID'] == 1){
                        //empty so that root admin cannot be deleted
                    } else {
                        ?>
                        <form method="POST" action="users.php">
                    <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                    <input type="hidden" name="deleteUserImage" value="<?php echo $result['userImagePath'] ?>">
                    <button type="submit" name="deleteUserBtn" class="btn btn-danger">Delete this User</button>
                </form>
                <?php
                    }
                    ?>
                
                <?php
                }
                ?>
                <hr>
                <?php
            }
        }
    }

    //specific user
    public function showUserWhere(){
        $results = $this->getUserWhere();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <p><?php echo $result['userID']; ?></p>
                <p><?php echo $result['userName']; ?></p>
                <?php
                    if($result['userImagePath'] == null){
                        ?>
                        <img src="https://via.placeholder.com/300/f2f2f2/000000/?text=No image for user">
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo $result['userImagePath']; ?>">
                        <?php
                    }
                ?>
                <p><?php echo $result['userPassword_hash']; ?></p>
                <p><?php echo $result['isAdmin']; ?></p>
                <!--
                <form method="GET" action="user.php">
                    <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                    <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
                </form>
                -->
                <?php
                if(isset($_SESSION['isAdmin'])){
                if($result['isAdmin'] == 0){
                        ?>
                        <form method="POST" action="users.php">
                            <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
                        </form>
                <?php
                    } else {
                        if($result['userID'] == 1){
                            //must have an empty if. if i do if(!$result..) then the form is not shown
                            ?>
                            
                        <?php
                        } else {
                            ?>
                            <form method="POST" action="users.php">
                                <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                                <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
                            </form>
                        <?php
                        }
                        ?>
                        <?php
                    }
                    ?>
                <?php
                }
                ?>
                
                <hr>
                <?php
            }
        }
    }

    //specific user for my-account.php
    public function showMyUser(){
        $results = $this->getMyUser();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <p><?php echo $result['userID']; ?></p>
                <p><?php echo $result['userName']; ?></p>
                <?php
                    if($result['userImagePath'] == null){
                        ?>
                        <img src="https://via.placeholder.com/300/f2f2f2/000000/?text=No image for user">
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo $result['userImagePath']; ?>">
                        <?php
                    }
                ?>
                <p><?php echo $result['userPassword_hash']; ?></p>
                <p><?php echo $result['isAdmin']; ?></p>
                <hr>
                <?php
                if($result['wishlistIsPublic'] == 0){
                    ?>
                    <p>Your wishlist is currently <span class="font-weight-bold text-primary">private.</span></p>
                    <form method="POST" action="my-account.php" class="mb-2">
                        <input type="hidden" name="wishlistPublicID" value="<?php echo $result['userID'] ?>">
                        <button name="makeWishlistPublic" type="submit" class="btn btn-primary">Make wishlist public</button>
                    </form>
                <?php
                } else {
                    ?>
                    <p>Your wishlist is currently <span class="font-weight-bold text-primary">public</span></p>
                    <form method="POST" action="my-account.php" class="mb-2">
                        <input type="hidden" name="wishlistPrivateID" value="<?php echo $result['userID'] ?>">
                        <button name="makeWishlistPrivate" type="submit" class="btn btn-primary">Make wishlist private</button>
                    </form>
                <?php
                }
                ?>
                <hr>
                <?php
                //if user is logged in and session id matches the id from the result table
                if(isset($_SESSION['uid']) && $_SESSION['uid'] == $result['userID']){
                    ?>
                <form method="POST" enctype="multipart/form-data" action="users.php" class="mb-2">
                    <p>Update user information</p>
                    <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                    <div class="form-group">
                        <label for="updateUserName">New name</label>
                        <input name="updateUserName" id="updateUserName" type="text" value="<?php echo $result['userName']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="updateUserRemove" value="<?php echo $result['userImagePath']; ?>">
                        <label for="updateUserImage" class="w-100">Image - Must be png, jpeg or jpg.</label>
                        <input type="file" name="updateUserImage" id="updateUserImage" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <button name="updateUserBtn" type="submit" class="btn btn-warning">Update</button>
                </form>
                <hr>
                <form method="POST" action="users.php" class="mb-2">
                    <input name="deleteUserImageID" type="hidden" value="<?php echo $result['userID'] ?>">
                    <input type="hidden" name="deleteImageUser" value="<?php echo $result['userImagePath']; ?>">
                    <button type="submit" name="deleteImageBtn" class="btn btn-danger">Delete image</button>
                </form>
                <?php
                }
                ?>
                <hr>
                <?php
                    if($result['userID'] == 1){
                        //empty so that root admin cannot be deleted
                    } else {
                        ?>
                        <form method="POST" action="users.php">
                            <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                            <input type="hidden" name="deleteUserImage" value="<?php echo $result['userImagePath'] ?>">
                            <button type="submit" name="deleteUserBtn" class="btn btn-danger">Delete this User</button>
                        </form>
                        <hr>
                <?php
                    }
                    ?>

                
                <?php
            }
        }
    }

    //admin
    public function showUsersAdmin(){
        $results = $this->getUsersAdmin();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <p><?php echo $result['userID']; ?></p>
                <p><?php echo $result['userName']; ?></p>
                <?php
                    if($result['userImagePath'] == null){
                        ?>
                        <img src="https://via.placeholder.com/300/f2f2f2/000000/?text=No image for user">
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo $result['userImagePath']; ?>">
                        <?php
                    }
                ?>
                <p><?php echo $result['userPassword_hash']; ?></p>
                <p><?php echo $result['isAdmin']; ?></p>
                <form method="GET" action="user.php">
                    <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                    <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
                </form>
                <?php
                if(isset($_SESSION['isAdmin'])){
                    if($result['isAdmin'] == 0){
                        ?>
                        <form method="POST" action="users.php">
                            <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
                        </form>
                <?php
                    } else {
                        ?>
                        <?php
                        if($result['userID'] == 1){
                            //cannot remove admin
                        } else {
                            ?>
                            <form method="POST" action="users.php">
                            <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
                        </form>
                        <?php
                        }
                        
                    }
                    ?>
                <?php
                }
                ?>
                <?php
                if(isset($_SESSION['isAdmin'])){
                    ?>
                    <?php
                    if($result['userID'] == 1){
                        //cannot delete
                    } else {
                        ?>
                        <form method="POST" action="users.php">
                            <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="deleteUserBtn" class="btn btn-danger">Delete this User</button>
                        </form>
                        <?php
                    }
                }
                ?>
                <hr>
                <?php
            }
        }
    }

    //nonadmin
    public function showUsersNotAdmin(){
        $results = $this->getUsersNotAdmin();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <p><?php echo $result['userID']; ?></p>
                <p><?php echo $result['userName']; ?></p>
                <?php
                    if($result['userImagePath'] == null){
                        ?>
                        <img src="https://via.placeholder.com/300/f2f2f2/000000/?text=No image for user">
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo $result['userImagePath']; ?>">
                        <?php
                    }
                ?>
                <p><?php echo $result['userPassword_hash']; ?></p>
                <p><?php echo $result['isAdmin']; ?></p>
                <form method="GET" action="user.php">
                    <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                    <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
                </form>
                <?php
                if(isset($_SESSION['isAdmin'])){
                    if($result['isAdmin'] == 0){
                        ?>
                        <form method="POST" action="users.php">
                            <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
                        </form>
                <?php
                    } else {
                        ?>
                        <form method="POST" action="users.php">
                            <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
                        </form>
                <?php
                    }
                    ?>
                <?php
                }
                ?>
                <?php
                if(isset($_SESSION['isAdmin'])){
                    ?>
                <form method="POST" action="users.php">
                    <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                    <button type="submit" name="deleteUserBtn" class="btn btn-danger">Delete this User</button>
                </form>
                <?php
                }
                ?>
                <hr>
                <?php
            }
        }
    }

    //probably not needed
    public function filterUsers(){
        if(isset($_POST['usersSelect'])){
            switch($_POST['usersSelect']){
                case 'none':
                    //do nothing
                break;
                case 'all':
                    $sql = "SELECT * FROM oopphp_users";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(1, $userID, PDO::PARAM_INT);
                    $stmt->bindParam(2, $userName, PDO::PARAM_STR);
                    $stmt->bindParam(3, $userPasswordHash, PDO::PARAM_STR);
                    //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
                    $stmt->execute();
            
                    if($stmt->rowCount() > 0 ){
                        $results = $stmt->fetchAll();
                        //return $results;
                    } else {
                        ?><p>There are no users.</p><?php
                    }
                    foreach($results as $result){
                        ?>
                        <div class="col-lg-4">
                        <p><?php echo $result['userID']; ?></p>
                        <p><?php echo $result['userName']; ?></p>
                        <p><?php echo $result['userPassword_hash']; ?></p>
                        <p><?php echo $result['isAdmin']; ?></p>
                        <form method="GET" action="user.php">
                            <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                            <button type="submit" class="mb-2">See more of this user</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="deleteUserBtn">Delete this User</button>
                        </form>
                        <form method="POST" action="users.php">
                            <p>Update user information</p>
                            <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                            <label for="updateUserName">New name</label>
                            <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                            <button name="updateUserBtn" type="submit">Update</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userMakeAdmin" class="mb-2">Make admin</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userRemoveAdmin" class="mb-2">Remove admin</button>
                        </form>
                    </div>
                        <?php
                }
                break;

                case 'admin':
                    $sql = "SELECT * FROM oopphp_users WHERE isAdmin = 1";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(1, $userID, PDO::PARAM_INT);
                    $stmt->bindParam(2, $userName, PDO::PARAM_STR);
                    $stmt->bindParam(3, $userPasswordHash, PDO::PARAM_STR);
                    //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
                    $stmt->execute();
            
                    $results = $stmt->fetchAll();
                    //return $results;

                    foreach($results as $result){
                        ?>
                        <p><?php echo $result['userID']; ?></p>
                        <p><?php echo $result['userName']; ?></p>
                        <p><?php echo $result['userPassword_hash']; ?></p>
                        <p><?php echo $result['isAdmin']; ?></p>
                        <form method="GET" action="user.php">
                            <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                            <button type="submit" class="mb-2">See more of this user</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="deleteUserBtn">Delete this User</button>
                        </form>
                        <form method="POST" action="users.php">
                            <p>Update user information</p>
                            <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                            <label for="updateUserName">New name</label>
                            <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                            <button name="updateUserBtn" type="submit">Update</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userMakeAdmin" class="mb-2">Make admin</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userRemoveAdmin" class="mb-2">Remove admin</button>
                        </form>
                        <hr>
                        <?php
                    }
                break;

                case 'user':
                    $sql = "SELECT * FROM oopphp_users WHERE isAdmin = 0";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(1, $userID, PDO::PARAM_INT);
                    $stmt->bindParam(2, $userName, PDO::PARAM_STR);
                    $stmt->bindParam(3, $userPasswordHash, PDO::PARAM_STR);
                    //$stmt->bindParam(4, $isAdmin, PDO::PARAM_STR);
                    $stmt->execute();
            
                    $results = $stmt->fetchAll();
                    //return $results;
                    foreach($results as $result){
                        ?>
                        <p><?php echo $result['userID']; ?></p>
                        <p><?php echo $result['userName']; ?></p>
                        <p><?php echo $result['userPassword_hash']; ?></p>
                        <p><?php echo $result['isAdmin']; ?></p>
                        <form method="GET" action="user.php">
                            <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                            <button type="submit" class="mb-2">See more of this user</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="deleteUserBtn">Delete this User</button>
                        </form>
                        <form method="POST" action="users.php">
                            <p>Update user information</p>
                            <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                            <label for="updateUserName">New name</label>
                            <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                            <button name="updateUserBtn" type="submit">Update</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userMakeAdmin" class="mb-2">Make admin</button>
                        </form>
                        <form method="POST" action="users.php">
                            <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                            <button type="submit" name="userRemoveAdmin" class="mb-2">Remove admin</button>
                        </form>
                        <hr>
                        <?php
                    }
                break;

        default:
        
        break;
        }
    }
}
}