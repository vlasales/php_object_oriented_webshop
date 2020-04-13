<?php
    //include 'includes/autoLoaderClasses.php';
    var_dump(__DIR__); echo '<br>';
    require_once __DIR__ . '/includes/autoLoaderClasses.php';
    

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
        <div class="row">
        <div class="col-lg-12">
    <form method="POST" action="index.php" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="newItemName">Name</label>
            <input type="text" name="newItemName" class="form-control" required>
            <div class="valid-feedback">
                <?php echo $valid_feedback ?>
            </div>
            <div class="invalid-feedback">
                <?php echo $invalid_feedback ?>
            </div>
        </div>
        <div class="form-group">
            <label for="newItemDescription">Description</label>
            <input type="text" name="newItemDescription" class="form-control" required>
            <div class="valid-feedback">
                <?php echo $valid_feedback ?>
            </div>
            <div class="invalid-feedback">
                <?php echo $invalid_feedback ?>
            </div>
        </div>
        <div class="form-group">
            <label for="newItemPrice">Price</label>
            <input type="number" name="newItemPrice" class="form-control" required>
            <div class="valid-feedback">
                <?php echo $valid_feedback ?>
            </div>
            <div class="invalid-feedback">
                <?php echo $invalid_feedback ?>
            </div>
        </div>
        <div class="form-group">
            <label for="newItemStock">Stock</label>
            <input type="number" name="newItemStock" class="form-control" required>
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
</div>
    <hr>
    <?php
    }
    ?>

        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="search.php" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="query">Search items by name</label>
                        <input type="text" name="itemName" class="form-control" required>
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
        </div>
        <hr>
        <div class="row">
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
        </div>
    </div>

    <?php   
        $itemObject = new ItemsController();
        $itemObject->createItem();
        $itemObject->updateItem();
        $itemObject->deleteItem();

        $wishlistObject = new WishlistController();
        $wishlistObject->AddToWishlist();
    ?>
    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>