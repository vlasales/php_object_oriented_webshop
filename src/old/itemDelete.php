<?php
    include 'includes/session.php';
    include 'includes/config.php';
    
    include 'includes/autoLoaderClasses.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php' ?>

    <?php
        //delete
        $itemObject = new ItemsController();
        $itemObject->deleteItem();
    ?>

    <?php include 'includes/footer.php' ?>
</body>
</html>