<?php
//save content as php variable to call it
function updateForm(){
    echo 'test';
}
//view
class ItemsView extends ItemsModel{
    public function showItems(){
        $results = $this->getItems();
        if(isset($results)){
            foreach($results as $result){
                ?>
                <div class="col-lg-4">
                <?php updateForm(); ?>
                   <p><?php echo $result['itemID']; ?></p>
                   <img src="https://via.placeholder.com/300">
                   <p><?php echo $result['itemName']; ?></p>
                   <p><?php echo $result['itemDescription']; ?></p>
                   <p><?php echo $result['itemPrice'] . 'DKK'; ?></p>
                   <p><?php echo $result['itemStock'] . ' left in stock'; ?></p>
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
                   <img src="https://via.placeholder.com/300">
                   <p><?php echo $result['itemName']; ?></p>
                   <p><?php echo $result['itemDescription']; ?></p>
                   <p><?php echo $result['itemPrice'] . 'DKK'; ?></p>
                   <p><?php echo $result['itemStock'] . ' left in stock'; ?></p>
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