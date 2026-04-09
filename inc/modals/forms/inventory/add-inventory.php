<?php
require_once '../init.php';
include '../inc/header.php';

$rows = Item::getAll();

$success_mess = '';
$error_mess = '';
// if (isset($_POST['submit_condition_form'])) {
//     $name = $_POST['material_name'];
//     $type_id = $_POST['type_id'];

//     $insert_query = $conn->prepare('INSERT INTO materials (type_id, name) values (?, ?)');
//     $insert_query->bind_param('is', $type_id, $name);
//     if ($insert_query->execute()) {
//         $success_mess = 'Material Inserted';
//     } else {
//         $error_mess = 'Error:' . $insert_query->error;
//     }
// }

?>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Inventory</h1>
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
                        <!-- stock -->
                        <div class="form-group">
                            <label for="stock_qty">Stock Quantity</label>
                            <input type="number" class="form-control" name="stock_qty" id="stock_qty" placeholder="Stock Quantity">
                        </div>
                        <div class="form-group">
                            <label for="purchased_date">Puchased Date</label>
                            <input type="date" class="form-control" id="purchased_date" name="purchased_date">
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">Puchased Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="purchase_price" name="purchase_price" placeholder="e.g. 1500.00">
                        </div>
                        <div class="form-group">
                            <label for="last_maintenance_date">Item Last Maintenance Date</label>
                            <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date">
                        </div>

                        <div class="form-group">
                            <label for="next_maintenance_date">Item Next Maintenance Date</label>
                            <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date">
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

        </div>
    </div>
</div>