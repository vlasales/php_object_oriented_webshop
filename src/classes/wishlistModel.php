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
        $userID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

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
        $addItemToWishlistBtn = filter_input(INPUT_POST, 'addItemToWishlistBtn');

        if(isset($addItemToWishlistBtn)){
        if(isset($_SESSION['uid'])){
            $userID_fk = $_SESSION['uid'];
        }
        $itemID_fk = filter_input(INPUT_POST, 'wishlistID', FILTER_VALIDATE_INT);
        $itemName_fk = filter_input(INPUT_POST, 'wishlistName', FILTER_SANITIZE_STRING);
        $itemDescription_fk = filter_input(INPUT_POST, 'wishlistDescription', FILTER_SANITIZE_STRING);
        $itemPrice_fk = filter_input(INPUT_POST, 'wishlistPrice', FILTER_VALIDATE_FLOAT);
        $itemStock_fk = filter_input(INPUT_POST, 'wishlistStock', FILTER_VALIDATE_INT);
        $itemImagePath_fk = filter_input(INPUT_POST, 'wishlistImagePath', FILTER_SANITIZE_STRING);

        
            $sql = "INSERT INTO oopphp_wishlist(userID_fk, itemID_fk, itemName_fk, itemDescription_fk, itemPrice_fk, itemStock_fk, itemImagePath_fk) VALUES(?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $userID_fk, PDO::PARAM_INT);
            $stmt->bindParam(2, $itemID_fk, PDO::PARAM_INT);
            $stmt->bindParam(3, $itemName_fk, PDO::PARAM_STR);
            $stmt->bindParam(4, $itemDescription_fk, PDO::PARAM_STR);
            $stmt->bindParam(5, $itemPrice_fk, PDO::PARAM_STR);
            $stmt->bindParam(6, $itemStock_fk, PDO::PARAM_INT);
            $stmt->bindParam(7, $itemImagePath_fk, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with name {$itemName_fk} added to wishlist.</div>"; 
                header("location: index.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with name {$itemName_fk} not added to wishlist.</div>"; 
                header("location: index.php");
                exit();
            }
        }
    }

    //delete 1 from wishlist
    protected function setDeleteItemWishlist(){
        $deleteItemBtn = filter_input(INPUT_POST, 'deleteWishlistItemBtn');

        if(isset($deleteItemBtn)){
        //delete
        $insertID = filter_input(INPUT_POST, 'wishlistInsertID', FILTER_VALIDATE_INT);
        $itemID = filter_input(INPUT_POST, 'wishlisteItemID', FILTER_VALIDATE_INT);

        $sql = "DELETE FROM oopphp_wishlist WHERE insertID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $insertID, PDO::PARAM_INT);
        $stmt->execute();

            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} removed from wishlist.</div>"; 
                header("location: account.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not removed from wishlist.</div>"; 
                header("location: account.php");
                exit();
            }
        }
    }

    //delete all
    protected function setDeleteItemWishlistAll(){
        $wishlistDeleteAllBtn = filter_input(INPUT_POST, 'wishlistDeleteAllBtn');

        if(isset($wishlistDeleteAllBtn)){
        //delete
        $wishlistDeleteAllUserID = filter_input(INPUT_POST, 'wishlistDeleteAllUserID', FILTER_VALIDATE_INT);

        $sql = "DELETE FROM oopphp_wishlist WHERE userID_fk = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $wishlistDeleteAllUserID, PDO::PARAM_INT);
        $stmt->execute();

            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>All items from wishlist deleted</div>"; 
                header("location: account.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. All items from wishlist not deleted</div>"; 
                header("location: account.php");
                exit();
            }
        }
    }

    //set wishlist public
    protected function setWishlistPublic(){
        $wishlistPublicBtn = filter_input(INPUT_POST, 'makeWishlistPublic');

        if(isset($wishlistPublicBtn)){
        $userID = filter_input(INPUT_POST, 'wishlistPublicID', FILTER_VALIDATE_INT);
    
        $sql = "UPDATE oopphp_users SET wishlistIsPublic = 1 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} wishlist is now public.</div>"; 
                header("location: account.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not public.</div>"; 
                header("location: account.php");
                exit();
            }
        }
    }

    //wishlist private
    protected function setWishlistPrivate(){
        $wishlistPrivateBtn = filter_input(INPUT_POST, 'makeWishlistPrivate');

        if(isset($wishlistPrivateBtn)){
        $userID = filter_input(INPUT_POST, 'wishlistPrivateID', FILTER_VALIDATE_INT);
        
        $sql = "UPDATE oopphp_users SET wishlistIsPublic = 0 WHERE userID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();

        
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>User with ID {$userID} wishlist is now private.</div>"; 
                header("location: account.php");
                exit();
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. User with ID {$userID} not private.</div>"; 
                header("location: account.php");
                exit();
            }
        }
    }
}