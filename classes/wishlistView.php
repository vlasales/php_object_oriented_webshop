<?php
class WishlistView extends WishlistModel{
    public function showWishlist(){
        $results = $this->getWishList();
        $total_price_sum = 0; 
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
                    <button type="submit" name="deleteWishlistItemBtn" class="btn btn-danger">Delete from wishlist</button>
                </form>
            </div>
            <hr>
            <?php
            $total_price_sum = $total_price_sum + $result['itemPrice_fk'];
        }
        echo "<h2 class='text-primary'>Your total cart price: {$total_price_sum} DKK</h2>";
    }

    public function showWishlist2(){
        $results = $this->getWishList2();
        $total_price_sum = 0;
        foreach($results as $result){
                ?>
                    <p><?php echo $result['itemID_fk']; ?></p>
                    <img src="https://via.placeholder.com/300">
                    <p>Name: <?php echo $result['itemName_fk']; ?></p>
                    <p>Description: <?php echo $result['itemDescription_fk']; ?></p>
                    <p>Price: <?php echo $result['itemPrice_fk']; ?></p>
                    <hr>
                <?php
                $total_price_sum = $total_price_sum + $result['itemPrice_fk'];
        }
        echo "<h2 class='text-primary'>This users total cart price: {$total_price_sum} DKK</h2>";
    }
}