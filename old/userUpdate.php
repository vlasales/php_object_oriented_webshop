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
        //update user
        $createUserObject = new UsersController();
        $createUserObject->updateUser();
    ?>
    <?php include 'includes/footer.php' ?>
</body>
</html>