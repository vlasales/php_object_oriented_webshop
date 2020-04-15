<?php
    include 'includes/autoLoaderClasses.php';

    include 'includes/session.php';
    include 'includes/config.php';
    include 'includes/variables.php';
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
                    $func = new Functions();
                    $func->session_message();

                    $func->redirectNotLoggedIn();
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
                    $wishlistView->showWishlistAccount();
                ?>
                <?php
                    $wishlistObject = new WishlistController();
                    $wishlistObject->DeleteItemWishList();
                    $wishlistObject->MakeWishlistPublic();
                    $wishlistObject->MakeWishlistPrivate();
                ?>
            </div>
        </div>
    </div>

    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>