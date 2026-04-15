<?php
require_once '../init.php';
$rows = Types::getAll();

$success_mess = '';
$error_mess = '';

$material_data = [];
if (isset($_GET['id'])) {
    $material_id = $_GET['id'];

    $get_by_id = Materials::find($material_id);
    if (!$get_by_id) {
        die('Material not found');
    } else {
        $material_data = $get_by_id;
    }
}
if (isset($_POST['update_material_form'])) {
    $material_name = mysqli_real_escape_string($conn, $_POST['material_name'] ?? '');
    $material_type = mysqli_real_escape_string($conn, $_POST['type_id'] ?? '');

    if (empty($material_name)) {
        $error_mess = 'All fields are required';
    } else {
        $update_sql = "UPDATE inventory_materials SET name='$material_name', type_id='$material_type' WHERE id = {$material_data['id']}";
        if (mysqli_query($conn, $update_sql)) {
            $success_mess = 'Material updated successfully';
            // Refresh the category data
            $material_data = Materials::find($material_data['id']);
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
                <label for="type_id">Select Types</label>
                <select class="form-select form-select-sm" name="type_id" id="type_id">
                    <option value="">___Select Types___</option>
                    <?php
                    if (!empty($rows)) {
                        $count = 0;
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $selected = ($id == $material_data['type_id']) ? 'selected' : '';
                    ?>
                            <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="material_name">Type Name</label>
                <input type="text" class="form-control" id="material_name" name="material_name" value="<?php echo $material_data['name']?>" placeholder="Enter Type name">
            </div>


            <button type="submit" name="update_material_form" class="btn btn-primary mt-4">Submit</button>

            <?php if (!empty($success_mess)): ?>
                <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
            <?php endif; ?>

            <?php if (!empty($error_mess)): ?>
                <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
            <?php endif; ?>
        </form>
    </div>
</div>