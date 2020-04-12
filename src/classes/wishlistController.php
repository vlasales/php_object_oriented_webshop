<?php
class WishlistController extends WishlistModel{
    public function AddToWishlist(){
        $this->setToWishlist();
    }

    public function DeleteItemWishList(){
        $this->setDeleteItemWishlist();
    }

    public function MakeWishlistPublic(){
        $this->setWishlistPublic();
    }

    public function MakeWishlistPrivate(){
        $this->setWishlistPrivate();
    }
}