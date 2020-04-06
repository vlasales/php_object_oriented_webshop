<?php
class UsersView extends UsersModel{
    public function showUsers(){
        $results = $this->getUsers();
        foreach($results as $result){
            ?>
            <p><?php echo $result['userID']; ?></p>
            <p><?php echo $result['userName']; ?></p>
            <p><?php echo $result['userPassword_hash']; ?></p>
            <p><?php echo $result['isAdmin']; ?></p>
            <form method="GET" action="user.php">
                <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
            </form>
            <?php
            if(isset($_SESSION['isAdmin'])){
                ?>
                <form method="POST" action="users.php">
                <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
            </form>
            <form method="POST" action="users.php">
                <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
            </form>
            <?php
            }
            ?>
            <?php
            //if user is logged in and session id matches the id from the result table
            if(isset($_SESSION['uid']) && $_SESSION['uid'] == $result['userID']){
                ?>
            <form method="POST" action="users.php" class="mb-2">
                <p>Update user information</p>
                <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                <div class="form-group">
                    <label for="updateUserName">New name</label>
                    <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                </div>
                <button name="updateUserBtn" type="submit" class="btn btn-warning">Update</button>
            </form>
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

    //specific user
    public function showUserWhere(){
        $results = $this->getUserWhere();
        foreach($results as $result){
            ?>
            <p><?php echo $result['userID']; ?></p>
            <p><?php echo $result['userName']; ?></p>
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
                ?>
            <form method="POST" action="users.php">
                <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
            </form>
            <form method="POST" action="users.php">
                <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
            </form>
            <?php
            }
            ?>
            <?php
            //if user is logged in and session id matches the id from the result table
            if(isset($_SESSION['uid']) && $_SESSION['uid'] == $result['userID']){
                ?>
            <form method="POST" action="users.php" class="mb-2">
                <p>Update user information</p>
                <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                <div class="form-group">
                    <label for="updateUserName">New name</label>
                    <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                </div>
                <button name="updateUserBtn" type="submit" class="btn btn-warning">Update</button>
            </form>
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

    //specific user for my-account.php
    public function showMyUser(){
        $results = $this->getMyUser();
        foreach($results as $result){
            ?>
            <p><?php echo $result['userID']; ?></p>
            <p><?php echo $result['userName']; ?></p>
            <p><?php echo $result['userPassword_hash']; ?></p>
            <p><?php echo $result['isAdmin']; ?></p>
            <!--
            <form method="GET" action="user.php">
                <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
            </form>
            -->
            <?php
            //if user is logged in and session id matches the id from the result table
            if(isset($_SESSION['uid']) && $_SESSION['uid'] == $result['userID']){
                ?>
            <form method="POST" action="users.php" class="mb-2">
                <p>Update user information</p>
                <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                <div class="form-group">
                    <label for="updateUserName">New name</label>
                    <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                </div>
                <button name="updateUserBtn" type="submit" class="btn btn-warning">Update</button>
            </form>
            <form method="POST" action="users.php">
                <input type="hidden" name="deleteUserID" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="deleteUserBtn" class="btn btn-danger">Delete this User</button>
            </form>
            <?php
            }
            ?>
            <?php
        }
    }

    //admin
    public function showUsersAdmin(){
        $results = $this->getUsersAdmin();
        foreach($results as $result){
            ?>
            <p><?php echo $result['userID']; ?></p>
            <p><?php echo $result['userName']; ?></p>
            <p><?php echo $result['userPassword_hash']; ?></p>
            <p><?php echo $result['isAdmin']; ?></p>
            <form method="GET" action="user.php">
                <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
            </form>
            <?php
            if(isset($_SESSION['isAdmin'])){
                ?>
                <form method="POST" action="users.php">
                <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
            </form>
            <form method="POST" action="users.php">
                <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
            </form>
            <?php
            }
            ?>
            <?php
            //if user is logged in and session id matches the id from the result table
            if(isset($_SESSION['uid']) && $_SESSION['uid'] == $result['userID']){
                ?>
            <form method="POST" action="users.php" class="mb-2">
                <p>Update user information</p>
                <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                <div class="form-group">
                    <label for="updateUserName">New name</label>
                    <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                </div>
                <button name="updateUserBtn" type="submit" class="btn btn-warning">Update</button>
            </form>
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

    //nonadmin
    public function showUsersNotAdmin(){
        $results = $this->getUsersNotAdmin();
        foreach($results as $result){
            ?>
            <p><?php echo $result['userID']; ?></p>
            <p><?php echo $result['userName']; ?></p>
            <p><?php echo $result['userPassword_hash']; ?></p>
            <p><?php echo $result['isAdmin']; ?></p>
            <form method="GET" action="user.php">
                <input type="hidden" name="id" value="<?php echo $result['userID'] ?>">
                <button type="submit" class="mb-2 btn btn-primary">See more of this user</button>
            </form>
            <?php
            if(isset($_SESSION['isAdmin'])){
                ?>
                <form method="POST" action="users.php">
                <input name="userIDMakeAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userMakeAdmin" class="mb-2 btn btn-info">Make admin</button>
            </form>
            <form method="POST" action="users.php">
                <input name="userIDRemoveAdmin" type="hidden" value="<?php echo $result['userID'] ?>">
                <button type="submit" name="userRemoveAdmin" class="mb-2 btn btn-info">Remove admin</button>
            </form>
            <?php
            }
            ?>
            <?php
            //if user is logged in and session id matches the id from the result table
            if(isset($_SESSION['uid']) && $_SESSION['uid'] == $result['userID']){
                ?>
            <form method="POST" action="users.php" class="mb-2">
                <p>Update user information</p>
                <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                <div class="form-group">
                    <label for="updateUserName">New name</label>
                    <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>">
                </div>
                <button name="updateUserBtn" type="submit" class="btn btn-warning">Update</button>
            </form>
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