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
                <form method="POST" action="users.php" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="form-group">
                    <label for="newUsername">Name</label>
                    <input type="text" name="newUsername" id="newUsername" class="form-control" required>
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
                    </div>
            <div class="form-group">
                    <label for="newUserpassword">Password</label>
                    <input type="password" name="newUserpassword" id="newUserpassword" class="form-control" required>
                    <div class="valid-feedback">
                        <?php echo $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo $invalid_feedback ?>
                    </div>
            </div>
            <div class="form-group">
                <label for="newUserImage" class="w-100">Image - Must be png, jpeg or jpg.</label>
                <input type="file" name="newUserImage" id="newUserImage" accept="image/png, image/jpeg, image/jpg">
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