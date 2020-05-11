<header class="mb-3">
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">PHP webshop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link text-light" href="index.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="users.php"><i class="fas fa-users"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="signup.php"><i class="fas fa-user-plus"></i> Sign up</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="account.php"><i class="fas fa-user-circle"></i> Account</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="search.php"><i class="fas fa-search"></i> Search</a>
        </li>
        </ul>
        <hr>
        <span class="text-light">
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
        </span>
        <hr>
        <div class="dividerLineContent ml-2 mr-2 text-light">|</div><!--::before doesnt work on buttons. small hack-->
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Login</button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="loginName" class="mr-lg-2">Name</label>
                        <input type="text" name="loginName" id="loginName" class="form-control mr-sm-2 mb-3 mb-lg-0" required>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword" class="mr-lg-2">Password</label>
                        <input type="password" name="loginPassword" id="loginPassword" class="form-control mr-sm-2" required>
                    </div>
                    <button type="submit" name="loginBtn" class="mt-2 mt-lg-0 btn btn-primary btn-block">Login</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

        
        <hr>
        <div class="dividerLineContent ml-2 mr-2 text-light">|</div>
        <button id="darkModeToggleBtn" class="btn btn-info"></button>
        <hr>
        <form method="POST" action="logout.php" class="dividerLine form-inline my-2 my-lg-0">
            <button class="btn btn-danger" name="logoutBtn" type="submit">Log out</button>
        </form>
    </div>
    </nav>
</header>