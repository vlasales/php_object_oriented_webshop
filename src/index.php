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
    <?php
    if(isset($_SESSION['isAdmin'])){
        ?>
    <section class="row">
        <div class="col-lg-12">
            <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" class="needs-validation" enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <label for="newItemName">Name</label>
                    <input type="text" name="newItemName" id="newItemName" class="form-control" required>
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newItemDescription">Description</label>
                    <input type="text" name="newItemDescription" id="newItemDescription" class="form-control" required>
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newItemPrice">Price</label>
                    <input type="number" name="newItemPrice" id="newItemPrice" class="form-control" required>
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newItemStock">Stock</label>
                    <input type="number" name="newItemStock" id="newItemStock" class="form-control" required>
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newItemImage" class="w-100">Image - Must be png, jpeg or jpg.</label>
                    <input type="file" name="newItemImage" id="newItemImage" accept="image/png, image/jpeg, image/jpg">
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
                </div>
                <button type="submit" name="newItemBtn" class="btn btn-success">Add new item</button>
            </form>
        </div>
    </section>
    <hr>
    <?php
    }
    ?>
    <section class="row">
        <div class="col-lg-12">
            <form method="GET" action="search.php" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="itemName">Search items by name</label>
                    <input type="text" name="itemName" id="itemName" class="form-control" required>
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </section>
    <hr>
        <main role="main" class="row">
        <div class="col-lg-12">
            <?php
                $sessMSG2 = new Functions();
                $sessMSG2->session_message();
            ?>
        </div>
            <?php
                $itemObjectShow = new ItemsView();
                $itemObjectShow->showItems();
            ?>
        </main>
    </div>

    <?php   
        $itemObject = new ItemsController();
        $itemObject->createItem();
        $itemObject->updateItem();
        $itemObject->deleteItem();
            $itemObject->deleteImageItem();

        $wishlistObject = new WishlistController();
        $wishlistObject->AddToWishlist();
    ?>
    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>