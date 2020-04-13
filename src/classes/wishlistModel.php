<?php
class WishlistModel extends DBconn{
    protected function getWishlistAccount(){
        if(isset($_SESSION['uid'])){
            $userID = $_SESSION['uid'];
        }

        if(isset($userID)){
        $sql = "SELECT * FROM oopphp_wishlist WHERE userID_fk = ? ORDER BY itemID_fk ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        $itemCount = $stmt->rowCount();
        if($itemCount == 1){
            echo "<h1 class='w-100'>There is {$itemCount} item in your wishlist</h1>";
        } else {
            echo "<h1 class='w-100'>There are {$itemCount} items in your wishlist</h1>";
        }

        if($stmt->rowCount() > 0){
            $results = $stmt->fetchAll();
            return $results;
        } else {
            //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>No items in the database.</div>"; 
            //header("location: index.php");
        }
    }
    }

    protected function getWIshlistUsers(){
        $userID = $_GET['id'];

        if(isset($userID)){
            $pdo = $this->connect();
            $sql = "SELECT wishlistIsPublic FROM oopphp_users WHERE userID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
            $stmt->bindColumn('wishlistIsPublic', $wishlistIsPublic, PDO::PARAM_INT);
            $stmt->execute();

            //get specific column only
            $results = $stmt->fetchColumn();
            

            $sql = "SELECT * FROM oopphp_wishlist WHERE userID_fk = ? ORDER BY itemID_fk ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll();
            $itemCount = $stmt->rowCount();

            

            if($wishlistIsPublic == 1) {
                if($itemCount > 0) {
                    if($itemCount == 1){
                        echo "<h1 class='w-100'>There is {$itemCount} item in this users wishlist</h1>";
                    } else {
                        echo "<h1 class='w-100'>There are {$itemCount} items in this users wishlist</h1>";
                    }
                    return $results;
                } else {
                    echo "<div class='alert alert-info'>This users wishlist is empty.</div>";
                }
            } else {
                echo "<div class='alert alert-info'>This user has set their wishlist to private.</div>";
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
        $insertID = filter_input(INPUT_POST, 'wishlistInsertID');
        $itemID = filter_input(INPUT_POST, 'wishlisteItemID');
        $deleteItemBtn = filter_input(INPUT_POST, 'deleteWishlistItemBtn');

        if(isset($deleteItemBtn)){
        $sql = "DELETE FROM oopphp_wishlist WHERE insertID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $insertID, PDO::PARAM_INT);
        $stmt->execute();

            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} removed from wishlist.</div>"; 
                header("location: my-account.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not removed from wishlist.</div>"; 
                header("location: my-account.php");
            }
        }
    }

    //set wishlist public
    protected function setWishlistPublic(){
        $userID = htmlentities(filter_input(INPUT_POST, 'wishlistPublicID'));
        $wishlistPublicBtn = filter_input(INPUT_POST, 'makeWishlistPublic');

        if(isset($wishlistPublicBtn)){
        $sql = "UPDATE oopphp_users SET wishlistIsPublic = 1 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} wishlist is now public.</div>"; 
                header("location: my-account.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not public.</div>"; 
                header("location: my-account.php");
            }
        }
    }

    //wishlist private
    protected function setWishlistPrivate(){
        $userID = htmlentities(filter_input(INPUT_POST, 'wishlistPrivateID'));
        $wishlistPrivateBtn = filter_input(INPUT_POST, 'makeWishlistPrivate');

        if(isset($wishlistPrivateBtn)){
        $sql = "UPDATE oopphp_users SET wishlistIsPublic = 0 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} wishlist is now private.</div>"; 
                header("location: my-account.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not private.</div>"; 
                header("location: my-account.php");
            }
        }
    }
}