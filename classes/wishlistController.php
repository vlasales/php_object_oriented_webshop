<?php
class WishlistController extends WishlistModel{
    public function AddToWishlist(){
        $this->setToWishlist();
    }

    public function DeleteItemWishList(){
        $this->setDeleteItemWishlist();
    }
}