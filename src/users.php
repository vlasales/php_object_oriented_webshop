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
    
    <!--
    Probably not needed
    <form action="users.php" method="POST">
        <select name="usersSelect">
            <option value="none">None</option>
            <option value="all">All</option>
            <option value="admin">Admins</option>
            <option value="user">Users</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    <hr>
    -->
    
    
    <!--
    <div class="container-fluid">
        <div class="row">
            <?php
                //$usersObjectShow->filterUsers();
            ?>
        </div>
    </div>
-->
<div class="row">
    <div class="col-lg-12">
    <?php
        $sessMSG = new Functions();
        $sessMSG->session_message();
    ?>
                <form method="GET" action="search.php" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="userName">Search user by name</label>
                        <input type="text" name="userName" id="userName" class="form-control" required>
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
        <h1>List of users</h1>
    </div>
</div>
            <div class="row">
        <div class="col-lg-4">
        <?php
        //see users
        $usersObjectShow = new UsersView();
        $usersObjectShow->showUsers();
        ?>
        </div>
        <div class="col-lg-4">
        <?php
        //admin
        $usersObjectShow->showUsersAdmin();
        ?>
        </div>
        <div class="col-lg-4">
        <?php
        //non-admin
        
        $usersObjectShow->showUsersNotAdmin();
    ?>
        </div>
    </div>
    </div>

    <?php   
        $usersObject = new UsersController();
        $usersObject->createUser();
        $usersObject->updateUser();
            $usersObject->makeUserAdmin();
            $usersObject->removeUserAdmin();
        $usersObject->deleteUser();
            $usersObject->deleteImage();
    ?>
    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>