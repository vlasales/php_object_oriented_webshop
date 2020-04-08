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
        echo '<h1 class="w-100 pl-3">There are ' . $itemCount . ' items</h1>';

        if($stmt->rowCount() > 0){
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
            //$itemID = $_GET['id'];
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
        //setting create variables
        $itemName = htmlentities(filter_input(INPUT_POST, 'newItemName'));
        $itemDescription = htmlentities(filter_input(INPUT_POST, 'newItemDescription'));
        $itemPrice = htmlentities(filter_input(INPUT_POST, 'newItemPrice'));
        $itemStock = htmlentities(filter_input(INPUT_POST, 'newItemStock'));
        $newItemBtn = filter_input(INPUT_POST, 'newItemBtn');

        //must be inside if, or else it it keeps inserting empty values to the db - bug?
        if(isset($newItemBtn)){
            $sql = "INSERT INTO oopphp_items(itemName, itemDescription, itemPrice, itemStock) VALUES (?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $itemName, PDO::PARAM_STR);
            $stmt->bindParam(2, $itemDescription, PDO::PARAM_STR);
            $stmt->bindParam(3, $itemPrice, PDO::PARAM_STR);
            $stmt->bindParam(4, $itemStock, PDO::PARAM_INT);
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
        try{
            $pdo = $this->connect();

            //begin transaction
            $pdo->beginTransaction();

            //delete item
            $deleteItemBtn = filter_input(INPUT_POST, 'deleteItemBtn');
            $itemID = filter_input(INPUT_POST, 'deleteItemID');

            $sql = "DELETE FROM oopphp_items WHERE itemID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $itemID, PDO::PARAM_INT);
            $stmt->execute();

            //delete wishlist
            $itemID_fk = filter_input(INPUT_POST, 'deleteItemID');

            $sql = "DELETE FROM oopphp_wishlist WHERE itemID_fk = ?";
            $stmt2 = $this->connect()->prepare($sql);
            $stmt2->bindParam(1, $itemID_fk, PDO::PARAM_INT);
            $stmt2->execute();

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

    //update - also updates the wishlist
    protected function setUpdateItem(){
        try{
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
            $updateItemBtn = filter_input(INPUT_POST, 'updateItemBtn');

            $sql = "UPDATE oopphp_items SET itemName = ?, itemDescription = ?, itemPrice = ?, itemStock = ? WHERE itemID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $itemName, PDO::PARAM_STR);
            $stmt->bindParam(2, $itemDescription, PDO::PARAM_STR);
            $stmt->bindParam(3, $itemPrice, PDO::PARAM_STR);
            $stmt->bindParam(4, $itemStock, PDO::PARAM_INT);
            $stmt->bindParam(5, $itemID, PDO::PARAM_INT);
            $stmt->execute();

            //wishlist
            $itemID_fk = htmlentities(filter_input(INPUT_POST, 'updateItemID'));
            $itemName_fk = htmlentities(filter_input(INPUT_POST, 'updateItemName'));
            $itemDescription_fk = htmlentities(filter_input(INPUT_POST, 'updateItemDescription'));
            $itemPrice_fk = htmlentities(filter_input(INPUT_POST, 'updateItemPrice'));

            $sql = "UPDATE oopphp_wishlist SET itemName_fk = ?, itemDescription_fk = ?, itemPrice_fk = ? WHERE itemID_fk = ?";
            $stmt2 = $pdo->prepare($sql);
            $stmt2->bindParam(1, $itemName_fk, PDO::PARAM_STR);
            $stmt2->bindParam(2, $itemDescription_fk, PDO::PARAM_STR);
            $stmt2->bindParam(3, $itemPrice_fk, PDO::PARAM_STR);
            $stmt2->bindParam(4, $itemID_fk, PDO::PARAM_INT);
            $stmt2->execute();

            //commit it to the db at the end
            $pdo->commit();
        }
        catch(Exception $e){
            $pdo->rollBack();
            echo $e->getMessage();
        }
        finally{
            if(isset($updateItemBtn)){
                //when changing more than 1 row we must use ||. if we dont and update an item that is not in a wishlist it will update but show error
                if($stmt->rowCount() > 0 || $stmt2->rowCount() > 0){
                    $_SESSION['sessMSG'] = "<div class='alert alert-success'>Item with ID {$itemID} updated.</div>"; 
                    header("location: index.php");
                } else {
                    $_SESSION['sessMSG'] = "<div class='alert alert-danger'>Error. Item with ID {$itemID} not updated.</div>"; 
                    header("location: index.php");
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