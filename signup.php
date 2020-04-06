<?php
    include 'includes/autoLoaderClasses.php';

    include 'includes/session.php';
    include 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/content/head.php' ?>
    <title><?php echo $itemName ?></title>
</head>
<body>
    <?php include 'includes/content/navbar.php' ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <?php
                $sessMSG2 = new Functions();
                $sessMSG2->session_message();
            ?>
                <h1>Sign up</h1>
                <form method="POST" action="users.php" class="needs-validation" novalidate>
                    <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="newUsername" class="form-control" required>
                    <div class="valid-feedback">
                            Valid
                        </div>
                        <div class="invalid-feedback">
                            You must fill out this input
                        </div>
                    </div>
            <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="newUserpassword" class="form-control" required>
                    <div class="valid-feedback">
                            Valid
                        </div>
                        <div class="invalid-feedback">
                            You must fill out this input
                        </div>
            </div>
                    <button type="submit" name="newUserBtn" class="btn btn-success">Create user</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>