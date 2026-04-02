<?php
include '../db/connection.php';

include '../inc/header.php';

$get_cats = 'SELECT * FROM categories';
$query_run = mysqli_query($conn, $get_cats);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

$get_type = 'SELECT * FROM types';
$query_run_type = mysqli_query($conn, $get_type);
$rows_type = mysqli_fetch_all($query_run_type, MYSQLI_ASSOC);

$success_mess = '';
$error_mess = '';

if (isset($_POST['item_submit'])) {
    $item_name = $_POST['item_name'];
    $item_desc = $_POST['item_desc'];
    $cat_id = $_POST['cat_id'];
    $type_id = $_POST['type_id'];

    $item_image = $_FILES['item_image']['name'];
    $image_tmp = $_FILES['item_image']['tmp_name'];
    $image_size = $_FILES['item_image']['size'];
    $image_ext = pathinfo($item_image, PATHINFO_EXTENSION);

    $image_name_unique = time() . '.' . $image_ext;
    $upload_dir  = $_SERVER['DOCUMENT_ROOT'] . '/AMS/uploads/';
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


<div class="container">
    <div class="items-add-form">
        <h3>Insert Items</h3>
        <div class="row">
            <div class="col-md-8">
                <form method="POST"  action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter item name">
                    </div>
                    <div class="form-group">
                        <label for="item_desc">Item Description</label>
                        <input type="text" class="form-control" id="item_desc" name="item_desc" placeholder="Item Desc">
                    </div>
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
                    <div class="mb-3">
                        <label for="item_image" class="form-label">Insert Item Image</label>
                        <input class="form-control" type="file" name="item_image" id="item_image">
                    </div>

                    <button type="submit" name="item_submit" class="btn btn-primary mt-4">Submit</button>
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