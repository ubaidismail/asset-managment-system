<?php
require_once '../init.php';


$get_items = Item::getAll();

$success_mess = '';
$error_mess = '';
if (isset($_POST['submit_inventory_form'])) {
    $item_id               = intval($_POST['item_id']);
    $stock_qty             = intval($_POST['stock_qty']);
    $purchase_price        = floatval($_POST['purchase_price']);
    $purchased_date        = mysqli_real_escape_string($conn, sanitize_date($_POST['purchased_date'] ?? ''));
    $last_maintenance_date = mysqli_real_escape_string($conn, sanitize_date($_POST['last_maintenance_date'] ?? ''));
    $next_maintenance_date = mysqli_real_escape_string($conn, sanitize_date($_POST['next_maintenance_date'] ?? ''));
    try {
        $check = mysqli_query($conn, "SELECT id FROM inventory WHERE item_id = $item_id");

        if (mysqli_num_rows($check) > 0) {
            // Item exists — update stock
            $update_query = "UPDATE inventory SET 
                        stock = stock + $stock_qty,
                        purchase_price = $purchase_price,
                        last_maintenance_date = '$last_maintenance_date',
                        next_maintenance_date = '$next_maintenance_date'
                     WHERE item_id = $item_id";
            if (mysqli_query($conn, $update_query)) {
                $success_mess = 'Inventory updated successfully';
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $error_mess = 'Error updating inventory: ' . mysqli_error($conn);
            }
        } else {
            $insert_query = "INSERT INTO inventory (item_id, stock, purchase_date, purchase_price, last_maintenance_date, next_maintenance_date) 
                     VALUES ($item_id, $stock_qty, '$purchased_date', $purchase_price, '$last_maintenance_date', '$next_maintenance_date')";
            if (mysqli_query($conn, $insert_query)) {
                $success_mess = 'Inventory added successfully';
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $error_mess = 'Error adding inventory: ' . mysqli_error($conn);
            }
        }
    } catch (\Throwable $th) {
        $error_mess = 'Error adding inventory: ' . $th->getMessage();
    }
}
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
                        <!-- stock -->
                        <!-- <div class="form-group">
                            <label for="stock_qty">Stock Quantity</label>
                            <input type="number" class="form-control" name="stock_qty" id="stock_qty" placeholder="Stock Quantity">
                        </div> -->
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