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
    <?php
            $sessMSG2 = new Functions();
            $sessMSG2->session_message();
        ?>
    <main role="main" class="row">
            <div class="col-lg-6">
                <form method="GET" action="search.php" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="itemName">Search items by name</label>
                        <input type="text" name="itemName" id="itemName" class="form-control" required>
                        <div class="valid-feedback">
                            <?php echo $valid_feedback ?>
                        </div>
                        <div class="invalid-feedback">
                            <?php echo $invalid_feedback ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <hr>
            </div>
            <div class="col-lg-6">
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
                <hr>
            </div>
            <hr>
        </main>
		<div class="row">
            <section class="col-lg-6">
                <?php
                    $seach_results = new SearchView();
                    $seach_results->showSearchItems();
                ?>
            </section>
            <section class="col-lg-6">
                <?php
                    $seach_results->showSearchUsers();
                ?>
            </section>
		</div>
    </div>
    <?php   
        $itemObject = new ItemsController();
        $itemObject->updateItem();
        $itemObject->deleteItem();
    ?>
	
	<?php include 'includes/content/footer.php' ?>
	<?php include 'includes/content/scripts.php' ?>
</body>
</html>