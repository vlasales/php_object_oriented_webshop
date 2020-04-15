<?php
class ItemsView extends ItemsModel{
    public function showItems(){
        $results = $this->getItems();
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
                   <form method="POST" enctype="multipart/form-data" action="index.php" class="mb-2">
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

    public function showItemWhere(){
        $results = $this->getItemWhere();
        if(isset($results)){
            foreach($results as $result){
                ?> 
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
                   <!--
                   <form method="GET" action="item.php">
                       <input type="hidden" name="id" value="<?php echo $result['itemID'] ?>">
                       <button type="submit" class="mb-2 btn btn-primary">See more of this item</button>
                   </form>
                    -->
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
                   <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-2">
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
                        <button type="submit" name="deleteItemBtn" class="btn btn-danger">Delete this item</button>
                   </form>
                        <?php
                    }
                   ?>
                   <hr>
                <?php
            }
        }
    }
}