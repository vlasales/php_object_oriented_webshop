<?php
class WishlistModel extends DBconn{
    protected function getWishlist(){
        
        $userID = $_SESSION['uid'];

        if(isset($userID)){
        $sql = "SELECT * FROM oopphp_wishlist WHERE userID_fk = ? ORDER BY itemID_fk ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        $itemCount = $stmt->rowCount();
        echo '<h1 class="w-100">There are ' . $itemCount . ' items in your wishlist</h1>';

        if($stmt->rowCount() > 0){
            $results = $stmt->fetchAll();
            return $results;
        } else {
            //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>No items in the database.</div>"; 
            //header("location: index.php");
        }
    }
    }

    protected function getWIshlist2(){
        $userID = $_GET['id'];

        if(isset($userID)){
        $sql = "SELECT * FROM oopphp_users INNER JOIN oopphp_wishlist ON oopphp_users.userID = oopphp_wishlist.userID_fk ORDER BY itemID_fk ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        $itemCount = $stmt->rowCount();

        echo '<h1 class="w-100">There are ' . $itemCount . ' items on this users wishlist</h1>';

        if($stmt->rowCount() > 0){
            $results = $stmt->fetchAll();
            return $results;
        } else {
            //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>No items in the database.</div>"; 
            //header("location: index.php");
        }
    }
    }

    //add to wishlist
    protected function setToWishlist(){
        if(isset($_SESSION['uid'])){
            $userID_fk = $_SESSION['uid'];
        }
        $itemID_fk = htmlentities(filter_input(INPUT_POST, 'wishlistID'));
        $itemName_fk = htmlentities(filter_input(INPUT_POST, 'wishlistName'));
        $itemDescription_fk = htmlentities(filter_input(INPUT_POST, 'wishlistDescription'));
        $itemPrice_fk = htmlentities(filter_input(INPUT_POST, 'wishlistPrice'));
        $addItemToWishlistBtn = filter_input(INPUT_POST, 'addItemToWishlistBtn');

        if(isset($addItemToWishlistBtn)){
            $sql = "INSERT INTO oopphp_wishlist(userID_fk, itemID_fk, itemName_fk, itemDescription_fk, itemPrice_fk) VALUES(?,?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID_fk, PDO::PARAM_INT);
            $stmt->bindParam(2, $itemID_fk, PDO::PARAM_INT);
            $stmt->bindParam(3, $itemName_fk, PDO::PARAM_STR);
            $stmt->bindParam(4, $itemDescription_fk, PDO::PARAM_STR);
            $stmt->bindParam(5, $itemPrice_fk, PDO::PARAM_STR);
            $stmt->execute();
        }
        

        if(isset($addItemToWishlistBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with name {$itemName_fk} added to wishlist.</div>"; 
                header("location: index.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with name {$itemName_fk} not added to wishlist.</div>"; 
                header("location: index.php");
            }
        }
    }

    //delete from wishlist
    protected function setDeleteItemWishlist(){
        //delete
        $deleteItemBtn = filter_input(INPUT_POST, 'deleteWishlistItemBtn');
        $itemID = filter_input(INPUT_POST, 'wishlisteItemID');

        $sql = "DELETE FROM oopphp_wishlist WHERE itemID_fk = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $itemID, PDO::PARAM_INT);
        $stmt->execute();

        if(isset($deleteItemBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} removed from wishlist.</div>"; 
                header("location: my-account.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not removed from wishlist.</div>"; 
                header("location: my-account.php");
            }
        }
    }
}