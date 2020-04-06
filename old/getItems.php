<?php
class GetItems extends DBconn{
    protected function getAllItems(){
        $sql = 'SELECT * FROM oopphp_items';
        
        /*
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($itemID, $itemName, $itemDescription, $itemStock);
        */
        

        $stmt = $this->connect()->query($sql);
        $numberOfItems = $stmt->num_rows;

        if($numberOfItems > 0){
            while($row = $stmt->fetch_assoc() ){
                $data[] = $row;
            }
            return $data;
        }
    }
}