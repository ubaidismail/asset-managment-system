<?php
require_once '../init.php';
$rows = Categories::getAll();

$success_mess = '';
$error_mess = '';
$type_data = [];
if (isset($_GET['id'])) {
    $type_id = $_GET['id'];

    $get_by_id = Types::find($type_id);
    if (!$get_by_id) {
        die('Type not found');
    } else {
        $type_data = $get_by_id;
    }
}
if (isset($_POST['update_type_form'])) {
    $type_name = mysqli_real_escape_string($conn, $_POST['type_name'] ?? '');
    $type_description = mysqli_real_escape_string($conn, $_POST['type_description'] ?? '');
    $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id'] ?? '');

    if (empty($type_name)) {
        $error_mess = 'All fields are required';
    } else {
        $update_sql = "UPDATE types SET name='$type_name', type_description='$type_description', cat_id = '$cat_id' WHERE id = {$type_data['id']}";
        if (mysqli_query($conn, $update_sql)) {
            $success_mess = 'Type updated successfully';
            // Refresh the category data
            $type_data = Types::find($type_data['id']);
        } else {
            $error_mess = 'Error updating Type: ' . mysqli_error($conn);
        }
    }
}

include '../inc/header.php';
?>


<div class="container">
    <div class="cat-add-form">
        <form method="POST" action="">
            <div class="form-group">
                <label for="unit_name">Unit Name</label>
                <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="Centimeter, Inch, Feet etc." required>
            </div>

            <div class="form-group">
                <label for="unit_symbol">Unit Symbol</label>
                <input type="text" class="form-control" id="unit_symbol" name="unit_symbol" placeholder="cm, in, ft etc." required>
            </div>

            <button type="submit" name="submit_unit_form" class="btn btn-primary mt-4">Submit</button>

            <?php if (!empty($success_mess)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_mess; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_mess)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_mess; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>