<?php
class WishlistView extends WishlistModel{
    public function showWishlistAccount(){
        $results = $this->getWishListAccount();
        $wishlist_total = 0;
        if(isset($results)){
            foreach($results as $result){
                ?>
                <div>
                    
                    <p>Name: <?php echo $result['itemName_fk']; ?></p>
                    <img src="<?php echo $result['itemImagePath_fk']; ?>">
                    <p>Description: <?php echo $result['itemDescription_fk']; ?></p>
                    <p>Price: <?php echo $result['itemPrice_fk']; ?></p>
                    <?php
                    if($result['itemStock_fk'] > 0){
                        ?>
                            <p><?php echo $result['itemStock_fk'] . ' left in stock'; ?></p>
                        <?php
                    } else {
                        ?>
                            <p class="font-weight-bold text-danger">This item is currently out of stock</p>
                        <?php
                    }
                   ?>
                    <form method="POST" action="account.php">
                        <input type="hidden" name="wishlisteItemID" value="<?php echo $result['itemID_fk'] ?>">
                        <input type="hidden" name="wishlistInsertID" value="<?php echo $result['insertID'] ?>">
                        <button type="submit" name="deleteWishlistItemBtn" class="btn btn-danger">Delete from wishlist</button>
                    </form>
                </div>
                <hr>
                <?php
                $wishlist_total = $wishlist_total + $result['itemPrice_fk'];
            }
            echo "<h2 class='text-primary'>Your total wishlist price: {$wishlist_total} DKK</h2>";
            ?>
                <form action="account.php" method="POST">
                    <input type="hidden" name="wishlistDeleteAllUserID" value="<?php echo $result['userID_fk'] ?>">
                    <button type="submit" name="wishlistDeleteAllBtn" class="btn btn-danger">Delete all items from wishlist</button>
                </form>
            <?php
        }
        
    }

    public function showWishlistUser(){
        $results = $this->getWishListUsers();
        $wishlist_total = 0;
        
        if(isset($results)){
            foreach($results as $result){
                ?>
                    <p><?php echo $result['itemID_fk']; ?></p>
                    <p>Name: <?php echo $result['itemName_fk']; ?></p>
                    <img src="<?php echo $result['itemImagePath_fk']; ?>">
                    <p>Description: <?php echo $result['itemDescription_fk']; ?></p>
                    <p>Price: <?php echo $result['itemPrice_fk']; ?></p>
                    <?php
                    if($result['itemStock_fk'] > 0){
                        ?>
                            <p><?php echo $result['itemStock_fk'] . ' left in stock'; ?></p>
                        <?php
                    } else {
                        ?>
                            <p class="font-weight-bold text-danger">This item is currently out of stock</p>
                        <?php
                    }
                   ?>
                    <hr>
                <?php
                $wishlist_total = $wishlist_total + $result['itemPrice_fk'];
            }
            echo "<h2 class='text-primary'>This users total wishlist price: {$wishlist_total} DKK</h2>";
        }
    }
}