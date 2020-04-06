<?php
class MyGetItem extends DBconn{
    public function getAllItems($conn){
        $sql = "SELECT itemID, itemName, itemDescription, itemStock FROM oopphp_items";

        /*
        $stmt = $this->connect()->query($sql);
        $numRows = $stmt->num_rows;
        if($numRows > 0){
            while($row = $stmt->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        */

        
        $stmt = $conn->prepare( $sql );
        $stmt->execute();
        $stmt->bind_result( $itemID, $itemName, $itemDescription, $itemStock);
        

        while($stmt->fetch() ){
            echo $itemID;
            echo $itemName;
            echo $itemDescription;
            echo $itemStock;
        }
        $stmt->close();
        $conn->close();
        
    }
}