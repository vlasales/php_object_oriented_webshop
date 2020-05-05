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
            <div class="col-lg-12 text-center">
                <h1>404 - Page not found</h1>
                <a href="index.php">
                    <button class="btn btn-primary">Back to frontpage</button>
                </a>
            </div>
        </main>
    </div>

    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>