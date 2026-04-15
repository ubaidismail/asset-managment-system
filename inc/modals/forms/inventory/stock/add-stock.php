<?php

// get items only which are added in inventory table
$get_items = mysqli_query($conn, "SELECT * FROM inventory_items WHERE status = 1 AND id IN (SELECT item_id FROM inventory WHERE status = 1)");
$item_conditions = ItemConditions::getAll();
$get_inventory = Inventory::getAll();

$success_mess = '';
$error_mess = '';
if (isset($_POST['submit_inventory_form'])) {
    $item_id               = intval($_POST['item_id']);
    $item_condition_id               = intval($_POST['item_condition_id']);
    $location  = mysqli_real_escape_string($conn, sanitize_date($_POST['location'] ?? ''));

    try {

        $res = mysqli_query($conn, "SELECT asset_code FROM items WHERE id = $item_id");
        $item = mysqli_fetch_assoc($res);
        $asset_code = $item['asset_code'] ?? '';

        // get inventory_id from inventory table
        $get_inventory_id = mysqli_query($conn, "SELECT id FROM inventory WHERE item_id = $item_id ORDER BY id DESC LIMIT 1");
        $inventory = mysqli_fetch_assoc($get_inventory_id);
        $inventory_id = $inventory['id'] ?? 0;
        // var_dump($inventory_id);
        // exit();
        $insert_query = "INSERT INTO inventory_join_items (inventory_id, item_id, item_condition_id, location) 
                     VALUES ($inventory_id, $item_id, $item_condition_id, '$location')";
        if (mysqli_query($conn, $insert_query)) {
            $last_id = mysqli_insert_id($conn);
            // update asset code with inventory_join_items id
            $new_asset_code = $asset_code . '-' . str_pad($last_id, 4, '0', STR_PAD_LEFT);
            $update_inventory_query = "UPDATE inventory_join_items SET barcode_id = '$new_asset_code' WHERE id = $last_id";
            mysqli_query($conn, $update_inventory_query);

            $success_mess = 'Stock added successfully';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error_mess = 'Error adding asset: ' . mysqli_error($conn);
        }
    } catch (\Throwable $th) {
        $error_mess = 'Error adding asset: ' . $th->getMessage();
    }
}
?>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Asset</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="items-add-form">

                    <form method="POST" action="">

                        <div class="form-group">
                            <label for="item_id">Select Item</label>
                            <select class="form-select form-select-sm" name="item_id" id="item_id">
                                <option value="">___Select___</option>
                                <?php
                                if (!empty($get_items)) {
                                    $count = 0;
                                    foreach ($get_items as $row) {
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
                            <label for="item_condition_id">Select Condition</label>
                            <select class="form-select form-select-sm" name="item_condition_id" id="item_condition_id">
                                <option value="">___Select___</option>
                                <?php
                                if (!empty($item_conditions)) {
                                    $count = 0;
                                    foreach ($item_conditions as $row) {
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
                        <!-- stock -->
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                        </div>

                        <button type="submit" name="submit_inventory_form" class="btn btn-primary mt-4">Submit</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<?php if (!empty($success_mess)): ?>
    <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
<?php endif; ?>

<?php if (!empty($error_mess)): ?>
    <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
<?php endif; ?>