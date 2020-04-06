<header class="text-light mb-3">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">PHP webshop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link text-light" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="users.php">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="signup.php">Sign up</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="my-account.php">My account</a>
        </li>
        </ul>
        <hr class="border-light"><!--only visable on mobile-->
        <?php
        if(isset($_SESSION['uid'])){
            ?>
            Logged in as: <?php echo $_SESSION['un'] ?>
            <?php if(isset($_SESSION['isAdmin'])){
                echo '(Administrator)';
            } else {
                echo '(Normal user)';
            } ?>
            <?php
        } else {
            ?>Not logged in<?php
        }
        ?>
        <form id="login-form" method="POST" action="login.php" class="form-inline my-2 my-lg-0">
            <label for="loginName" class="mr-lg-2 text-light">Name</label>
            <input type="text" name="loginName" class="form-control mr-sm-2 mb-3 mb-lg-0" required>
            <label for="loginPassword" class="mr-lg-2 text-light">Password</label>
            <input type="password" name="loginPassword" class="form-control mr-sm-2" required>
            <button type="submit" name="loginBtn" class="mt-2 mt-lg-0 btn btn-primary">Login</button>
        </form>
        <form id="logout-form" method="POST" action="logout.php" class="form-inline my-2 my-lg-0">
            <button class="btn btn-danger" name="logoutBtn" type="submit">Log out</button>
        </form>        
    </div>
    </nav>
</header>