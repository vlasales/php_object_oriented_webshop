<?php
//model
class SearchModel extends DBconn{
    protected function getSearch(){
        $query = filter_input(INPUT_GET, 'query');

        if(isset($query)){
            $query = "%$query%";
            $sql = "SELECT * FROM oopphp_items WHERE itemName LIKE ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $query, PDO::PARAM_STR);
            $stmt->execute();

            $itemCount = $stmt->rowCount();

            //when searching with "LIKE" the string needs % around it. we need to remove that before showing it on the page
            $displayQuery = str_replace('%', '', $query);

            if($itemCount == 1){
                echo "<h1 class='w-100 pl-3'>There is {$itemCount} item with the name {$displayQuery}</h1>";
            } else {
                echo "<h1 class='w-100 pl-3'>There are {$itemCount} items with the name {$displayQuery}</h1>";
            }

            if($itemCount > 0){
                $results = $stmt->fetchAll();
                return $results;
            } else {
                //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>There are {$itemCount} items with this name</div>"; 
                //header("location: index.php");
            }
        } else {
            echo "<div class='col-lg-12'><h1>No search set</h1></div>";
        }
    }
}