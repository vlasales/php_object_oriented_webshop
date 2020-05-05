<?php
//controller
class ItemsController extends ItemsModel{
    //create
    public function createItem(){
        $this->setItem();
    }

    //delete
    public function deleteItem(){
        $this->setDeleteItem();
    }

    //delete image
    public function deleteImageItem(){
        $this->setDeleteImageItem();
    }

    //update
    public function updateItem(){
        $this->setUpdateItem();
    }
}