<?php
class LoginController extends LoginModel{
    //$userID, $userName, $userPassword, $userPasswordHash, $isAdmin
    public function loginUser(){
        $this->getLoginInfo();
    }
}