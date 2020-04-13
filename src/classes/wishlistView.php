<?php
class WishlistView extends WishlistModel{
    public function showWishlist(){
        $results = $this->getWishListAccount();
        $wishlist_total = 0; 
        if(isset($results)){
            foreach($results as $result){
                ?>
                <div>
                    
                    <p><?php echo $result['itemID_fk']; ?></p>
                    <img src="https://via.placeholder.com/300">
                    <p>Name: <?php echo $result['itemName_fk']; ?></p>
                    <p>Description: <?php echo $result['itemDescription_fk']; ?></p>
                    <p>Price: <?php echo $result['itemPrice_fk']; ?></p>
                    <form method="POST" action="my-account.php">
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
        }
        
    }

    public function showWishlist2(){
        $results = $this->getWishListUsers();
        $wishlist_total = 0;
        
        if(isset($results)){
            foreach($results as $result){
                ?>
                    <p><?php echo $result['itemID_fk']; ?></p>
                    <img src="https://via.placeholder.com/300">
                    <p>Name: <?php echo $result['itemName_fk']; ?></p>
                    <p>Description: <?php echo $result['itemDescription_fk']; ?></p>
                    <p>Price: <?php echo $result['itemPrice_fk']; ?></p>
                    <hr>
                <?php
                $wishlist_total = $wishlist_total + $result['itemPrice_fk'];
            }
        echo "<h2 class='text-primary'>This users total wishlist price: {$wishlist_total} DKK</h2>";
        }
    }
}