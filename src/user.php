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
            <main role="main" class="col-lg-6">
                <?php
                    $usersView = new UsersView();
                    $usersView->showUserWhere();
                ?>
            </main>
            <section class="col-lg-6">
                <h2>Wishlist</h2>
                    <?php
                        $wishlistView = new WishlistView();
                        $wishlistView->showWishlistUser();
                    ?>
            </section>
        </div>
    </div>

    <?php   
        $itemObject = new UsersController();
        $itemObject->createUser();
        $itemObject->updateUser();
        $itemObject->deleteUser();
    ?>
    
    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>