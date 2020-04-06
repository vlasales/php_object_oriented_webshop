<?php
class WishlistView extends WishlistModel{
    public function showWishlist(){
        $results = $this->getWishList();
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
        }
    }

    public function showWishlist2(){
        $results = $this->getWishList2();
        foreach($results as $result){
            if($result['wishlistIsPublic'] == 1){
                ?>
                    <p><?php echo $result['itemID_fk']; ?></p>
                    <img src="https://via.placeholder.com/300">
                    <p>Name: <?php echo $result['itemName_fk']; ?></p>
                    <p>Description: <?php echo $result['itemDescription_fk']; ?></p>
                    <p>Price: <?php echo $result['itemPrice_fk']; ?></p>
                <?php
            } else {
                ?>
                    <p>This user has set their wishlist to private</p>
                <?php
            }
        }
    }
}