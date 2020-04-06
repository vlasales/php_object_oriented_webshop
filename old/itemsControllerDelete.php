<?php
//controller
class DeleteController extends ItemsModel{
    //delete
    public function deleteItem($itemID){
        $this->setDeleteItem($itemID);
    }
    
}