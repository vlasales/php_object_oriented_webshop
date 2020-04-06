<?php
    include 'includes/autoLoaderClasses.php';

    include 'includes/session.php';
    include 'includes/config.php';

    $redirect = new Functions();
    $redirect->redirectNotLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/content/head.php' ?>
</head>
<body>
    <?php include 'includes/content/navbar.php' ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    $wishlistMess = new Functions();
                    $wishlistMess->session_message();
                ?>
                <h1>Your account</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <h2>Information</h2>
                <?php
                    $userObject = new UsersView();
                    $userObject->showMyUser();
                ?>
            </div>
            <div class="col-lg-6">
                <?php
                    $wishlistView = new WishlistView();
                    $wishlistView->showWishlist();
                ?>
                <?php
                    $wishlistObject = new WishlistController();
                    $wishlistObject->DeleteItemWishList();
                ?>
            </div>
        </div>
    </div>

    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>