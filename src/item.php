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
        <main role="main" class="row">
            <div class="col-lg-12">
                <?php
                    //get item id
                    $itemObject = new ItemsView();
                    $itemObject->showItemWhere();
                ?>
            </div>
        </main>
    </div>
    <?php   
        $itemObject = new ItemsController();
        $itemObject->createItem();
        $itemObject->updateItem();
        $itemObject->deleteItem();
    ?>
    
    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>