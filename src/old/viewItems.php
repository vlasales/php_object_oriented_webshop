<?php
class ViewItems extends GetItems{
    public function showAllItems(){
        $datas = $this->getAllItems();
        foreach($datas as $data){
            echo $data['itemID'] . '<br>';
            echo $data['itemName'] . '<br>';
            echo $data['itemDescription'] . '<br>';
            echo $data['itemStock'];
        }
    }
}