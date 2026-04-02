<?php
include '../AMS/db/connection.php';


$get_cats = 'SELECT * FROM categories';
$query_run = mysqli_query($conn, $get_cats);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

$get_type = 'SELECT * FROM types';
$query_run_type = mysqli_query($conn, $get_type);
$rows_type = mysqli_fetch_all($query_run_type, MYSQLI_ASSOC);

// get conditions
$get_conditions = 'SELECT * FROM item_conditions';
$query_run_conditions = mysqli_query($conn, $get_conditions);
$rows_conditions = mysqli_fetch_all($query_run_conditions, MYSQLI_ASSOC);

$success_mess = '';
$error_mess = '';

if (isset($_POST['item_submit'])) {
    $item_name = $_POST['item_name'];
    $item_desc = $_POST['item_desc'];
    $cat_id = $_POST['cat_id'];
    $type_id = $_POST['type_id'];
    $item_serial_number = $_POST['item_serial_number'];
    $item_brand = $_POST['item_brand'];
    $item_model = $_POST['item_model'];
    $item_purchased_date = $_POST['item_purchased_date'];
    $item_purchase_price = $_POST['item_purchase_price'];
    $warranty_expiry = $_POST['warranty_expiry'];
    $item_last_maintenance_date = $_POST['last_maintenance_date'];
    $item_next_maintenance_date = $_POST['next_maintenance_date'];

    $item_image = $_FILES['item_image']['name'];
    $image_tmp = $_FILES['item_image']['tmp_name'];
    $image_size = $_FILES['item_image']['size'];
    $image_ext = pathinfo($item_image, PATHINFO_EXTENSION);

    $image_name_unique = time() . '.' . $image_ext;
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/AMS/uploads/';
    $upload_path = $upload_dir . $image_name_unique;

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($image_tmp, $upload_path)) {
        $insert_query = $conn->prepare('INSERT INTO items (name, item_description, type_id, category_id, image ) values (?,?,?,?,?)');
        $insert_query->bind_param('ssiis', $item_name, $item_desc, $type_id, $cat_id, $image_name_unique);

        if ($insert_query->execute()) {
            $success_mess = 'Item Inserted';
        } else {
            $error_mess = 'Error:' . $insert_query->error;
        }
    }
}

?>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Items</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="items-add-form">

                        <form method="POST" action="" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="item_name">Item Category</label>
                                <select class="form-select form-select-sm" name="cat_id" id="cat_id" onchange="filterTypes()">
                                    <option value="">___Select Category___</option>
                                    <?php
                                    if (!empty($rows)) {
                                        $count = 0;
                                        foreach ($rows as $row) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                    ?>
                                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="item_name">Item Type</label>
                                <select class="form-select form-select-sm" name="type_id" id="type_id">
                                    <option value="">___Select Item Type___</option>
                                    <?php
                                    if (!empty($rows_type)) {
                                        $count = 0;
                                        foreach ($rows_type as $row) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                    ?>
                                            <option value="<?php echo $id; ?>" data-cat="<?= $row['cat_id'] ?>" style="display:none;"><?php echo $name; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="item_material">Item Material</label>
                                <input type="text" class="form-control" id="item_material" name="item_material" placeholder="wood, plastic, metal, etc.">
                            </div>

                            <div class="form-group">
                                <label for="item_color">Item Color</label>
                                <input type="text" class="form-control" id="item_color" name="item_color" placeholder="black, white, red, etc.">
                            </div>

                            <div class="form-group">
                                <label for="item_size">Item Size</label>
                                <input type="text" class="form-control" id="item_size" name="item_size" placeholder="small, medium, large, etc.">
                            </div>

                            <div class="form-group">
                                <label for="item_weight">Item Weight</label>
                                <input type="text" class="form-control" id="item_weight" name="item_weight" placeholder="1KG, 3KG, etc.">
                            </div>

                            <div class="form-group">
                                <label for="item_adjustable">Item Adjustable</label>
                                <select name="item_adjustable" id="item_adjustable" class="form-control">
                                    <option value="">___Select___</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="item_serial_number">Item Serial Number</label>
                                <input type="number" class="form-control" id="item_serial_number" name="item_serial_number" placeholder="Enter item serial number">
                            </div>
                            <div class="form-group">
                                <label for="item_brand">Item Brand</label>
                                <input type="text" class="form-control" id="item_brand" name="item_brand" placeholder="Enter item brand">
                            </div>
                            <div class="form-group">
                                <label for="item_model">Item Model</label>
                                <input type="text" class="form-control" id="item_model" name="item_model" placeholder="Enter item model">
                            </div>
                            <div class="form-group">
                                <label for="item_purchased_date">Item Puchased Date</label>
                                <input type="date" class="form-control" id="item_purchased_date" name="item_purchased_date">
                            </div>

                            <div class="form-group">
                                <label for="item_purchase_price">Item Puchased Price</label>
                                <input type="date" class="form-control" id="item_purchase_price" name="item_purchase_price">
                            </div>
                            <div class="form-group">
                                <label for="warranty_expiry">Warranty Expiry</label>
                                <input type="date" class="form-control" id="warranty_expiry" name="warranty_expiry">
                            </div>
                            <div class="form-group">
                                <label for="item_name">Item Condition</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>___Item Condition___</option>
                                    <?php foreach ($rows_conditions as $condition): ?>
                                        <option value="<?php echo $condition['id']; ?>"><?php echo $condition['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="last_maintenance_date">Item Last Maintenance Date</label>
                                <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date">
                            </div>

                            <div class="form-group">
                                <label for="next_maintenance_date">Item Next Maintenance Date</label>
                                <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date">
                            </div>

                            <div class="mb-3">
                                <label for="item_image" class="form-label">Insert Item Image</label>
                                <input class="form-control" type="file" name="item_image" id="item_image">
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" name="item_submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>

                            <?php if (!empty($success_mess)): ?>
                                <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
                            <?php endif; ?>

                            <?php if (!empty($error_mess)): ?>
                                <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
                            <?php endif; ?>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    function filterTypes() {
        const cat_id = document.getElementById('cat_id').value;
        const options = document.querySelectorAll('#type_id option');

        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block'; // always show placeholder
            } else if (option.dataset.cat === cat_id) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        document.getElementById('type_id').value = '';

    }
</script>