<?php
//model
class ItemsModel extends DBconn{
    protected function getItems(){
        $sql = "SELECT * FROM oopphp_items ORDER BY itemID ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $itemID, PDO::PARAM_INT);
        $stmt->bindParam(2, $itemName, PDO::PARAM_STR);
        $stmt->bindParam(3, $itemDescription, PDO::PARAM_STR);
        $stmt->bindParam(4, $itemPrice, PDO::PARAM_STR);
        $stmt->bindParam(5, $itemStock, PDO::PARAM_INT);
        $stmt->execute();

        $itemCount = $stmt->rowCount();
        if($itemCount == 1){
            echo "<h1 class='w-100 pl-3'>There is {$itemCount} item</h1>";
        } else {
            echo "<h1 class='w-100 pl-3'>There are {$itemCount} items</h1>";
        }

        if($itemCount > 0){
            $results = $stmt->fetchAll();
            return $results;
        } else {
            //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>No items in the database.</div>"; 
            //header("location: index.php");
        }
    }

    protected function getItemWhere(){
        $itemID = filter_input(INPUT_GET, 'id');
        
        if(isset($itemID)){
            $sql = "SELECT * FROM oopphp_items WHERE itemID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $itemID, PDO::PARAM_INT);
            $stmt->execute();
            
            if($stmt->rowCount() > 0){
                $results = $stmt->fetchAll();
                return $results;
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>An item with the ID of {$itemID} does not exist.</div>"; 
                header("location: index.php");
            }
        } else {
            $_SESSION['sessMSG'] = "<div class='alert alert-danger'>No item ID selected.</div>"; 
            header("location: index.php");
        }
    }

    protected function setItem(){
        $newItemBtn = filter_input(INPUT_POST, 'newItemBtn');
        if(isset($newItemBtn)){
        //setting create variables
        $itemName = htmlentities(filter_input(INPUT_POST, 'newItemName'));
        $itemDescription = htmlentities(filter_input(INPUT_POST, 'newItemDescription'));
        $itemPrice = htmlentities(filter_input(INPUT_POST, 'newItemPrice'));
        $itemStock = htmlentities(filter_input(INPUT_POST, 'newItemStock'));
        

        //file
        $maxFileSize = 80000000;
        $imageName = $_FILES["newItemImage"]["name"];
	    $target_dir = "images/imagesItems/";
        $target_file = $target_dir . basename($imageName);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $extensions_arr = array("jpg","jpeg","png");

        if(!file_exists($target_file)){
            if(in_array($imageFileType, $extensions_arr)){
                if(($_FILES["newItemImage"]["size"] >= $maxFileSize) || ($_FILES["newItemImage"]["size"] == 0)) {
                    $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File too large. {$maxFileSize}KB is the max file size.</div>";
                    header('location: index.php');
                } else {
                    if(move_uploaded_file($_FILES["newItemImage"]["tmp_name"],$target_file)){
                        $imageUpload = $target_file;
                    } else {
                        $_SESSION["sessMSG"] = "<div class='alert alert-danger'>Error. Image '{$imageName}' not uploaded.</div>";
                        header('location: index.php');
                    }
                }
            } else {
                $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File extension must be jpg, png or jpeg. '{$imageFileType}' is not a valid extension.</div>";
                header('location: index.php');
            }
        } else {
            $_SESSION["sessMSG"] = "<div class='alert alert-danger'>A file with the name '{$imageName}' already exists. Please choose another name.</div>";
            header('location: index.php');
        }
        
        $sql = "INSERT INTO oopphp_items(itemName, itemDescription, itemPrice, itemStock, itemImagePath) VALUES (?,?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $itemName, PDO::PARAM_STR);
            $stmt->bindParam(2, $itemDescription, PDO::PARAM_STR);
            $stmt->bindParam(3, $itemPrice, PDO::PARAM_STR);
            $stmt->bindParam(4, $itemStock, PDO::PARAM_INT);
            $stmt->bindParam(5, $imageUpload, PDO::PARAM_STR);
            $stmt->execute();
        
        //only show if the button is clicked
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with name {$itemName} added.</div>"; 
                header("location: index.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item name must be unique and the name {$itemName} is already taken.</div>"; 
                header("location: index.php");
            }
        }
    }

    protected function setDeleteItem(){
        $deleteItemBtn = filter_input(INPUT_POST, 'deleteItemBtn');
        if(isset($deleteItemBtn)){
        try{
            $pdo = $this->connect();

            //begin transaction
            $pdo->beginTransaction();

            $itemID = filter_input(INPUT_POST, 'deleteItemID');

            $sql = "DELETE FROM oopphp_items WHERE itemID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $itemID, PDO::PARAM_INT);
            $stmt->execute();

            //delete wishlist
            $itemID_fk = filter_input(INPUT_POST, 'deleteItemID');

            $sql = "DELETE FROM oopphp_wishlist WHERE itemID_fk = ?";
            $stmt2 = $pdo->prepare($sql);
            $stmt2->bindParam(1, $itemID_fk, PDO::PARAM_INT);
            $stmt2->execute();

            $pdo->commit();

            //delete image
            $imageNameDelete = htmlentities(filter_input(INPUT_POST, 'deleteImageName'));
            unlink($imageNameDelete);

        }
        catch(Exception $e){
            $pdo->rollBack();
            echo $e->getMessage();
        }
        finally{
            if(isset($deleteItemBtn)){
                if($stmt->rowCount() > 0){
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} deleted.</div>"; 
                    header("location: index.php");
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not deleted.</div>"; 
                    header("location: index.php");
                }
            }
        }
        
    }
    }

    //update - also updates the wishlist
    protected function setUpdateItem(){
        $updateItemBtn = filter_input(INPUT_POST, 'updateItemBtn');

        if(isset($updateItemBtn)){
        try{
        $maxFileSize = 80000000;
        $imageName = $_FILES["updateItemImage"]["name"];
	    $target_dir = "images/imagesItems/";
        $target_file = $target_dir . basename($imageName);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $extensions_arr = array("jpg","jpeg","png");

        //check if the file already is in the folder
        if(!file_exists($target_file)){
            //check if the image type is ok
            if(in_array($imageFileType, $extensions_arr)){
                //check size
                if(($_FILES["updateItemImage"]["size"] >= $maxFileSize) || ($_FILES["updateItemImage"]["size"] == 0)) {
                    $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File too large. {$maxFileSize}KB is the max file size.</div>";
                    header('location: index.php');
                } else {
                    //upload the file
                    if(move_uploaded_file($_FILES["updateItemImage"]["tmp_name"],$target_file)){
                        $imageUpload = $target_file;
                    } else {
                        $_SESSION["sessMSG"] = "<div class='alert alert-danger'>Error. Image '{$imageName}' not uploaded.</div>";
                        header('location: index.php');
                    }
                }
            } else {
                $_SESSION["sessMSG"] = "<div class='alert alert-danger'>File extension must be jpg, png or jpeg. '{$imageFileType}' is not a valid extension.</div>";
                header('location: index.php');
            }
        } else {
            $_SESSION["sessMSG"] = "<div class='alert alert-danger'>A file with the name '{$imageName}' already exists. Please choose another name.</div>";
            header('location: index.php');
        }
    


            //we must set the connection to a variable, or else every time we call the function it will create a new object every time
            $pdo = $this->connect();

            //begin transaction
            $pdo->beginTransaction();

            //items
            $itemID = htmlentities(filter_input(INPUT_POST, 'updateItemID'));
            $itemName = htmlentities(filter_input(INPUT_POST, 'updateItemName'));
            $itemDescription = htmlentities(filter_input(INPUT_POST, 'updateItemDescription'));
            $itemPrice = htmlentities(filter_input(INPUT_POST, 'updateItemPrice'));
            $itemStock = htmlentities(filter_input(INPUT_POST, 'updateItemStock'));
            
            //we must have 2 queries when it comes to images. or else we will have a null image path if the user clicks update without choosing and image every time
            if(isset($imageUpload)){
                $sql = "UPDATE oopphp_items SET itemName = ?, itemDescription = ?, itemPrice = ?, itemStock = ?, itemImagePath = ? WHERE itemID = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $itemName, PDO::PARAM_STR);
                $stmt->bindParam(2, $itemDescription, PDO::PARAM_STR);
                $stmt->bindParam(3, $itemPrice, PDO::PARAM_STR);
                $stmt->bindParam(4, $itemStock, PDO::PARAM_INT);
                $stmt->bindParam(5, $imageUpload, PDO::PARAM_STR);
                $stmt->bindParam(6, $itemID, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $sql = "UPDATE oopphp_items SET itemName = ?, itemDescription = ?, itemPrice = ?, itemStock = ? WHERE itemID = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $itemName, PDO::PARAM_STR);
                $stmt->bindParam(2, $itemDescription, PDO::PARAM_STR);
                $stmt->bindParam(3, $itemPrice, PDO::PARAM_STR);
                $stmt->bindParam(4, $itemStock, PDO::PARAM_INT);
                $stmt->bindParam(5, $itemID, PDO::PARAM_INT);
                $stmt->execute();
            }

            //wishlist
            $itemID_fk = htmlentities(filter_input(INPUT_POST, 'updateItemID'));
            $itemName_fk = htmlentities(filter_input(INPUT_POST, 'updateItemName'));
            $itemDescription_fk = htmlentities(filter_input(INPUT_POST, 'updateItemDescription'));
            $itemPrice_fk = htmlentities(filter_input(INPUT_POST, 'updateItemPrice'));
            $itemStock_fk = htmlentities(filter_input(INPUT_POST, 'updateItemStock'));

            if(isset($imageUpload)){
                $sql = "UPDATE oopphp_wishlist SET itemName_fk = ?, itemDescription_fk = ?, itemPrice_fk = ?, itemStock_fk = ?, itemImagePath_fk = ? WHERE itemID_fk = ?";
                $stmt2 = $pdo->prepare($sql);
                $stmt2->bindParam(1, $itemName_fk, PDO::PARAM_STR);
                $stmt2->bindParam(2, $itemDescription_fk, PDO::PARAM_STR);
                $stmt2->bindParam(3, $itemPrice_fk, PDO::PARAM_STR);
                $stmt2->bindParam(4, $itemStock_fk, PDO::PARAM_INT);
                $stmt2->bindParam(5, $imageUpload, PDO::PARAM_STR);
                $stmt2->bindParam(6, $itemID_fk, PDO::PARAM_INT);
                $stmt2->execute();
            } else {
                $sql = "UPDATE oopphp_wishlist SET itemName_fk = ?, itemDescription_fk = ?, itemPrice_fk = ?, itemStock_fk = ? WHERE itemID_fk = ?";
                $stmt2 = $pdo->prepare($sql);
                $stmt2->bindParam(1, $itemName_fk, PDO::PARAM_STR);
                $stmt2->bindParam(2, $itemDescription_fk, PDO::PARAM_STR);
                $stmt2->bindParam(3, $itemPrice_fk, PDO::PARAM_STR);
                $stmt2->bindParam(4, $itemStock_fk, PDO::PARAM_INT);
                $stmt2->bindParam(5, $itemID_fk, PDO::PARAM_INT);
                $stmt2->execute();
            }            

            //commit it to the db at the end
            $pdo->commit();

            //only delete image if there is an upload file
            $updateImageRemove = htmlentities(filter_input(INPUT_POST, 'updateImageRemove'));
            if(isset($imageUpload)){
                unlink($updateImageRemove);
            }
            
        }
        catch(Exception $e){
            $pdo->rollBack();
            echo $e->getMessage();
        }
        finally{
            if(isset($updateItemBtn)){
                //when changing more than 1 row we must use ||. if we dont and update an item that is not in a wishlist it will update but show error
                if($stmt->rowCount() > 0){
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} updated.</div>"; 
                    header("location: " . $_SERVER['PHP_SELF']);
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not updated.</div>"; 
                    header("location: " . $_SERVER['PHP_SELF']);
                }
            }
        }
    }
    }

    /*
    //delete - original
    protected function setDeleteItem(){
        //delete
        $deleteItemBtn = filter_input(INPUT_POST, 'deleteItemBtn');
        $itemID = filter_input(INPUT_POST, 'deleteItemID');

        $sql = "DELETE FROM oopphp_items WHERE itemID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $itemID, PDO::PARAM_INT);
        $stmt->execute();

        if(isset($deleteItemBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} deleted.</div>"; 
                header("location: index.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not deleted.</div>"; 
                header("location: index.php");
            }
        }
    }
    
    //update - original
    protected function setUpdateItem(){
        $itemID = filter_input(INPUT_POST, 'updateItemID');
        $itemName = filter_input(INPUT_POST, 'updateItemName');
        $itemDescription = filter_input(INPUT_POST, 'updateItemDescription');
        $itemPrice = filter_input(INPUT_POST, 'updateItemPrice');
        $itemStock = filter_input(INPUT_POST, 'updateItemStock');
        $updateItemBtn = filter_input(INPUT_POST, 'updateItemBtn');

        $sql = "UPDATE oopphp_items SET itemName = ?, itemDescription = ?, itemPrice = ?, itemStock = ? WHERE itemID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $itemName, PDO::PARAM_STR);
        $stmt->bindParam(2, $itemDescription, PDO::PARAM_STR);
        $stmt->bindParam(3, $itemPrice, PDO::PARAM_STR);
        $stmt->bindParam(4, $itemStock, PDO::PARAM_INT);
        $stmt->bindParam(5, $itemID, PDO::PARAM_INT);
        $stmt->execute();

        if(isset($updateItemBtn)){
            if($stmt->rowCount() > 0){
                $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} updated. wishlist updated;</div>"; 
                header("location: index.php");
            } else {
                $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not updated.</div>"; 
                header("location: index.php");
            }
        }
    }
    */
}