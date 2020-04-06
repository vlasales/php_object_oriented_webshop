<?php
class Test extends DBconn {
    public function myTest($itemID, $itemName, $itemDescription, $itemStock){
        $sql = "SELECT * FROM oopphp_items";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$itemID, $itemName, $itemDescription, $itemStock]);
        $items = $stmt->fetchAll();

        foreach($items as $item){
            ?> 
               <p> <?php echo $item['itemID']; ?> </p>
               <p> <?php echo $item['itemName']; ?> </p> 
               <p> <?php echo $item['itemDescription']; ?> </p> 
               <p> <?php echo $item['itemStock']; ?> </p> 
            <?php
        }
    }
}