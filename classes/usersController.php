<?php
//controller
class UsersController extends UsersModel{
    //create
    public function createUser(){
        $this->setUser();
    }
    
    //delete
    public function deleteUser(){
        $this->setDeleteUser();
    }

    //update
    public function updateUser(){
        $this->setUpdateUser();
    }
    //update - make admin
    public function makeUserAdmin(){
        $this->setUserAdmin();
    }
    //update - remove admin
    public function removeUserAdmin(){
        $this->setUserRemoveAdmin();
    }
}