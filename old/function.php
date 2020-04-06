<?php
function updateForm(){
    ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="deleteItemID" value="<?php echo $result['itemID'] ?>">
                    <button type="submit" name="deleteItemBtn">Delete this item</button>
               </form>
               <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                    <input name="updateItemPrice" type="text" value="<?php echo $result['itemPrice']; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="updateItemStock">Update stock</label>
                    <input name="updateItemStock" type="number" value="<?php echo $result['itemStock']; ?>" class="form-control">
                </div>
                <button type="submit" name="updateItemBtn">Update</button>
               </form>
    <?php
}
?>