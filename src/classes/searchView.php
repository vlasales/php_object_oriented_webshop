<?php
class SearchView extends SearchModel{
    public function showSearchItems(){
        $results = $this->getSearchItems();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <div class="col-lg-4">
                   <p><?php echo $result['itemID']; ?></p>
                   <p><?php echo $result['itemName']; ?></p>
                   <img src="<?php echo $result['itemImagePath']; ?>">
                   <p><?php echo $result['itemDescription']; ?></p>
                   <p><?php echo $result['itemPrice'] . 'DKK'; ?></p>
                   <?php
                    if($result['itemStock'] > 0){
                        ?>
                            <p><?php echo $result['itemStock'] . ' left in stock'; ?></p>
                        <?php
                    } else {
                        ?>
                            <p class="font-weight-bold text-danger">This item is currently out of stock</p>
                        <?php
                    }
                   ?>
                   <form method="GET" action="item.php">
                       <input type="hidden" name="id" value="<?php echo $result['itemID'] ?>">
                       <button type="submit" class="mb-2 btn btn-primary">See more of this item</button>
                   </form>
                   <?php
                   if(isset($_SESSION['uid'])){
                       ?>
                    <form method="POST" action="index.php">
                       <input type="hidden" name="wishlistID" value="<?php echo $result['itemID'] ?>">
                       <input type="hidden" name="wishlistName" value="<?php echo $result['itemName'] ?>">
                       <input type="hidden" name="wishlistDescription" value="<?php echo $result['itemDescription'] ?>">
                       <input type="hidden" name="wishlistPrice" value="<?php echo $result['itemPrice'] ?>">
                       <input type="hidden" name="wishlistStock" value="<?php echo $result['itemStock'] ?>">
                       <input type="hidden" name="wishlistImagePath" value="<?php echo $result['itemImagePath'] ?>">
                       <button type="submit" name="addItemToWishlistBtn" class="btn btn-info">Add to wishlist</button>
                   </form>
                   <?php
                   }
                   ?>
                   <?php
                    if(isset($_SESSION['isAdmin'])){
                        ?>
                   <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-2">
                    <p>Update item information</p>
                    <input name="updateItemID" type="hidden" value="<?php echo $result['itemID']; ?>" class="form-control">
                    <div class="form-group">
                        <label for="updateItemName">Update name</label>
                        <input name="updateItemName" type="text" value="<?php echo $result['itemName']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="updateItemDescription">Update description</label>
                        <input name="updateItemDescription" type="text" value="<?php echo $result['itemDescription']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="updateItemPrice">Update price</label>
                        <input name="updateItemPrice" type="number" value="<?php echo $result['itemPrice']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="updateItemStock">Update stock</label>
                        <input name="updateItemStock" type="number" value="<?php echo $result['itemStock']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="updateImageRemove" value="<?php echo $result['itemImagePath'] ?>">
                        <label for="updateItemImage" class="w-100">Update image</label>
                        <input type="file" name="updateItemImage" value="<?php echo $result['itemImagePath'] ?>" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <button type="submit" name="updateItemBtn" class="btn btn-warning">Update</button>
                   </form>
                   <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteItemID" value="<?php echo $result['itemID'] ?>">
                        <input type="hidden" name="deleteImageName" value="<?php echo $result['itemImagePath'] ?>">
                        <button type="submit" name="deleteItemBtn" class="btn btn-danger">Delete this item</button>
                   </form>
                        <?php
                    }
                   ?>
                   <hr>
                   </div>
                <?php
            }
        }
    }

    public function showSearchUsers(){
        $results = $this->getSearchUsers();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <div class="col-lg-4">
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
                //if user is logged in and session id matches the id from the result table
                if(isset($_SESSION['uid']) && $_SESSION['uid'] == $result['userID']){
                    ?>
                <form method="POST" action="users.php" class="mb-2">
                    <p>Update user information</p>
                    <input name="updateUserID" type="hidden" value="<?php echo $result['userID'] ?>">
                    <div class="form-group">
                        <label for="updateUserName">New name</label>
                        <input name="updateUserName" type="text" value="<?php echo $result['userName']; ?>" class="form-control">
                    </div>
                    <button name="updateUserBtn" type="submit" class="btn btn-warning">Update</button>
                </form>
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
                    <button type="submit" name="deleteUserBtn" class="btn btn-danger">Delete this User</button>
                </form>
                <?php
                    }
                    ?>
                
                <?php
                }
                ?>
                </div>
                <hr>
                <?php
            }
        }
    }
}