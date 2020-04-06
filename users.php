<?php
    include 'includes/autoLoaderClasses.php';

    include 'includes/session.php';
    include 'includes/config.php';
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
    
    <?php
    
        $sessMSG = new Functions();
        $sessMSG->session_message();
        /*
        if(isset($_SESSION['userMSGNoAdmins'])){
            echo $_SESSION['userMSGNoAdmins'];
            unset($_SESSION["userMSGNoAdmins"]);
        }

        if(isset($_SESSION['userMSGNoNormalUsers'])){
            echo $_SESSION['userMSGNoNormalUsers'];
            unset($_SESSION["userMSGNoNormalUsers"]);
        }
    }
    */
    ?>
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
    ?>
    <?php include 'includes/content/footer.php' ?>
    <?php include 'includes/content/scripts.php' ?>
</body>
</html>