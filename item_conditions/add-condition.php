<?php
require_once '../init.php';
include '../inc/header.php';

$success_mess = '';
$error_mess = '';
if (isset($_POST['submit_condition_form'])) {
    $name = $_POST['condition_name'];
    $condition_description = $_POST['condition_description'];

    $insert_query = $conn->prepare('INSERT INTO item_conditions (name, description) values (?,?)');
    $insert_query->bind_param('ss', $name, $condition_description);
    if ($insert_query->execute()) {
        $success_mess = 'Condition Inserted';
    } else {
        $error_mess = 'Error:' . $insert_query->error;
    }
}

?>


<div class="container">
    <div class="cat-add-form">

        <form method="POST" action="">
            <div class="form-group">
                <label for="condition_name">Condition Name</label>
                <input type="text" class="form-control" id="condition_name" name="condition_name" placeholder="Enter Condition name">
            </div>
            <div class="form-group">
                <label for="condition_description">Condition Description</label>
                <input type="text" class="form-control" id="condition_description" name="condition_description" placeholder="Enter Condition description">
            </div>

            <button type="submit" name="submit_condition_form" class="btn btn-primary mt-4">Submit</button>

            <?php if (!empty($success_mess)): ?>
                <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
            <?php endif; ?>

            <?php if (!empty($error_mess)): ?>
                <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
            <?php endif; ?>
        </form>
    </div>
</div>