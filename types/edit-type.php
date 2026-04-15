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
        $update_sql = "UPDATE inventory_types SET name='$type_name', type_description='$type_description', cat_id = '$cat_id' WHERE id = {$type_data['id']}";
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
            <div class="form-group mb-2">
                <label for="cat_id">Select Category Type</label>
                <select class="form-select form-select-sm" name="cat_id" id="cat_id">
                    <option value="">___Select Category___</option>
                    <?php
                    if (!empty($rows)) {
                        $count = 0;
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $selected = ($id == $type_data['cat_id']) ? 'selected' : '';
                    ?>
                            <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="type_name">Type Name</label>
                <input type="text" class="form-control" id="type_name" name="type_name" value="<?php echo $type_data['name']?>" placeholder="Enter Type name">
            </div>
            <div class="form-group">
                <label for="type_description">Type Description</label>
                <input type="text" class="form-control" id="type_description" name="type_description" value="<?php echo $type_data['type_description']?>" placeholder="Enter Type desc">
            </div>



            <button type="submit" name="update_type_form" class="btn btn-primary mt-4">Submit</button>

            <?php if (!empty($success_mess)): ?>
                <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
            <?php endif; ?>

            <?php if (!empty($error_mess)): ?>
                <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
            <?php endif; ?>
        </form>
    </div>
</div>