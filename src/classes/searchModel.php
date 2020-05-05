<?php
//model
class SearchModel extends DBconn{
    protected function getSearchItems(){
        try{
        $query = filter_input(INPUT_GET, 'itemName', FILTER_SANITIZE_STRING);

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
                echo "<h1 class='w-100 pl-3'>There is {$itemCount} item containing: {$displayQuery}</h1>";
            } else {
                echo "<h1 class='w-100 pl-3'>There are {$itemCount} item containing: {$displayQuery}</h1>";
            }

            if($itemCount > 0){
                $results = $stmt->fetchAll();
                return $results;
            } else {
                //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>There are {$itemCount} items with this name</div>"; 
                //header("location: index.php");
            }
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    }

    protected function getSearchUsers(){
        try{
        $query = filter_input(INPUT_GET, 'userName', FILTER_SANITIZE_STRING);

        if(isset($query)){
            $query = "%$query%";
            $sql = "SELECT * FROM oopphp_users WHERE userName LIKE ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $query, PDO::PARAM_STR);
            $stmt->execute();

            $userCount = $stmt->rowCount();

            //when searching with "LIKE" the string needs % around it. we need to remove that before showing it on the page
            $displayQuery = str_replace('%', '', $query);

            if($userCount == 1){
                echo "<h1 class='w-100'>There is {$userCount} user containing: {$displayQuery}</h1>";
            } else {
                echo "<h1 class='w-100'>There are {$userCount} users containing: {$displayQuery}</h1>";
            }

            if($userCount > 0){
                $results = $stmt->fetchAll();
                return $results;
            } else {
                //$_SESSION['sessMSG'] = "<div class='alert alert-danger'>There are {$itemCount} items with this name</div>"; 
                //header("location: index.php");
            }
        }
    }

catch(Exception $e){
    echo $e->getMessage();
}
}
}