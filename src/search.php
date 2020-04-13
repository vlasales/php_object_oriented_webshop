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
    <div class="row">
            <div class="col-lg-6">
                <form method="GET" action="search.php" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="query">Search items by name</label>
                        <input type="text" name="itemName" class="form-control" required>
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
            <div class="col-lg-6">
                <form method="GET" action="search.php" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="query">Search user by name</label>
                        <input type="text" name="userName" class="form-control" required>
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
            <div class="col-lg-6">
                <?php
                    $seach_results = new SearchView();
                    $seach_results->showSearchItems();
                ?>
            </div>
            <div class="col-lg-6">
                <?php
                    $seach_results->showSearchUsers();
                ?>
            </div>
		</div>
	</div>
	
	<?php include 'includes/content/footer.php' ?>
	<?php include 'includes/content/scripts.php' ?>
</body>
</html>