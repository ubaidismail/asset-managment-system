<?php

$rows_cat = Categories::getAll();

$rows_type = Types::getAll();

// $rows_conditions =  ItemConditions::getAll();

$rows_materials = Materials::getAll();

// $rows_size_units = SizeUnits::getAll();

// $rows_weight_unit = WeightUnits::getAll();

$success_mess = '';
$error_mess = '';

// function generate_asset_code($conn, $category_name, $cat_id)
// {
//     // 1. Create the prefix dynamically (e.g., 'FUR', 'LAP', 'OFF')
//     $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category_name), 0, 3));

//     // 2. Create the SEARCH PATTERN (e.g., 'EMS-FUR-%')
//     // The % is a SQL wildcard that means "anything after this"
//     $search_pattern = "EMS-" . $prefix . "-%";

//     // 3. Use a Prepared Statement with the dynamic pattern
//     $stmt = $conn->prepare("SELECT asset_code FROM items WHERE asset_code LIKE ? ORDER BY asset_code DESC LIMIT 1");
//     $stmt->bind_param('s', $search_pattern);
//     $stmt->execute();
//     $result = $stmt->get_result()->fetch_assoc();

//     if ($result) {
//         // 4. If we found one, extract the number and increment
//         $last_number = (int)substr(trim($result['asset_code']), -4);
//         $next_number = $last_number + 1;
//     } else {
//         // 5. If it's a brand new category prefix, start at 1
//         $next_number = 1;
//     }

//     // 6. Final Assembly
//     $number = str_pad($next_number, 4, '0', STR_PAD_LEFT);
//     return 'EMS-' . $prefix . '-' . $number;
// }
// if (isset($_POST['item_submit'])) {

//     $item_name = $_POST['item_name'];
//     $item_desc = $_POST['item_description'];
//     $cat_id = $_POST['cat_id'];
//     $type_id = $_POST['type_id'];
//     $item_serial_number = $_POST['item_serial_number'];
//     $item_brand = $_POST['item_brand'];
//     $item_model = $_POST['item_model'];
//     // $item_purchase_price = $_POST['item_purchase_price'];
//     $material_id = $_POST['item_material'];
//     $item_color = $_POST['item_color'];
//     $size_width = $_POST['size_width'];
//     $size_height = $_POST['size_height'];
//     $size_depth = $_POST['size_depth'];
//     $size_unit = $_POST['size_unit_id'];
//     $item_weight = $_POST['item_weight'];
//     $weight_unit = $_POST['weight_unit'];
//     $is_adjustable = $_POST['item_adjustable'];
//     $item_location = $_POST['item_location'];
//     $item_notes = $_POST['item_notes'];


//     $item_image = $_FILES['item_image']['name'];
//     $image_tmp = $_FILES['item_image']['tmp_name'];
//     $image_size = $_FILES['item_image']['size'];
//     $image_ext = pathinfo($item_image, PATHINFO_EXTENSION);

//     $image_name_unique = time() . '.' . $image_ext;
//     $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/AMS/uploads/';
//     $upload_path = $upload_dir . $image_name_unique;

//     // Get category name for asset code generation
//     $category_name = '';
//     foreach ($rows_cat as $cat) {
//         if ($cat['id'] == $cat_id) {
//             $category_name = $cat['name'];
//             break;
//         }
//     }

//     $asset_code = generate_asset_code($conn, $category_name, $cat_id);


//     if (!file_exists($upload_dir)) {
//         mkdir($upload_dir, 0777, true);
//     }
//     move_uploaded_file($image_tmp, $upload_path);

//     try {
//         $sql = 'INSERT INTO inventory_items 
//             (name, item_description, type_id, category_id, serial_number, brand, model,
//             material_id, color, size_width, size_height, size_depth, size_unit,
//             item_weight, weight_unit, is_adjustable,
//             item_location, notes, image,asset_code) 
//             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'; //21

//         $insert_query = $conn->prepare($sql);

//         if (!$insert_query) {
//             die('Prepare failed: ' . $conn->error);
//         }

//         $insert_query->bind_param(
//             'ssiisssisdddidiissss',
//             $item_name,
//             $item_desc,
//             $type_id,
//             $cat_id,
//             $item_serial_number,
//             $item_brand,
//             $item_model,
//             // $item_purchase_price, // d
//             $material_id,
//             $item_color,
//             $size_width,          // d
//             $size_height,         // d
//             $size_depth,          // d
//             $size_unit,
//             $item_weight,         // d
//             $weight_unit,
//             $is_adjustable,
//             $item_location,
//             $item_notes,
//             $image_name_unique,
//             $asset_code
//         );

//         if ($insert_query->execute()) {
//             header('Location: /AMS/index.php');
//             exit();
//         } else {
//             $error_mess = 'Error:' . $insert_query->error;
//         }
//     } catch (\Throwable $th) {
//         $error_mess = 'Error:' . $th->getMessage();
//     }
// }

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
                            <label for="cat_id">Item Category</label>
                            <select class="form-select" name="cat_id" id="cat_id" onchange="filterTypes()">
                                <option value="">___Select Category___</option>
                                <?php
                                if (!empty($rows_cat)) {
                                    $count = 0;
                                    foreach ($rows_cat as $row) {
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
                            <label for="type_id">Item Type</label>
                            <select class="form-select" name="type_id" id="type_id" onchange="filterMaterials()">
                                <option value="">___Select Type___</option>
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
                            <select class="form-select" id="item_material" name="item_material">
                                <option value="">___Select Material___</option>
                                <?php
                                if (!empty($rows_materials)) {
                                    foreach ($rows_materials as $row) {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $type_id = $row['type_id'];
                                ?>

                                        <option value="<?php echo $id; ?>" data-type="<?= $type_id ?>" style="display:none;"><?php echo ucfirst($name); ?> </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>

                            <input type="text" class="form-control mt-2" id="material_other" name="material_other" placeholder="Specify material" style="display:none;">
                        </div>

                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter item name">
                        </div>

                        <div class="form-group">
                            <label for="item_description">Item Description</label>
                            <input type="text" class="form-control" id="item_description" name="item_description" placeholder="Enter item description">
                        </div>

                        <div class="form-group">
                            <label for="item_color">Item Color</label>
                            <input type="color" class="form-control form-control-color" id="item_color" name="item_color" placeholder="black, white, red, etc.">
                        </div>

                        <!-- <div class="form-group">
                            <label>Item Size (cm)</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="size_width" class="small text-muted">Width</label>
                                    <input type="number" class="form-control" id="size_width" name="size_width"
                                        placeholder="e.g. 120" min="0" step="0.1">
                                </div>
                                <div class="col-md-4">
                                    <label for="size_height" class="small text-muted">Height</label>
                                    <input type="number" class="form-control" id="size_height" name="size_height"
                                        placeholder="e.g. 75" min="0" step="0.1">
                                </div>
                                <div class="col-md-4">
                                    <label for="size_depth" class="small text-muted">Depth</label>
                                    <input type="number" class="form-control" id="size_depth" name="size_depth"
                                        placeholder="e.g. 60" min="0" step="0.1">
                                </div>
                            </div>
                            <small class="form-text text-muted">All dimensions in centimeters. Leave blank if not applicable.</small>
                        </div> -->

                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="mb-0">Item Size</label>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="<?php echo URL_ROOT ?>/units/size-unit/add-size-unit.php"><small>Add Unit</small></a>
                                    <small class="text-muted">Unit</small>
                                    <select class="form-select form-select-sm" style="width:140px;" name="size_unit_id" id="unit_select" onchange="updateSizeLabels()">
                                        <?php foreach ($rows_size_units as $unit): ?>
                                            <option value="<?= $unit['id'] ?>" data-symbol="<?= htmlspecialchars($unit['symbol']) ?>">
                                                <?= htmlspecialchars($unit['name']) ?> (<?= htmlspecialchars($unit['symbol']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="size_width" placeholder="0" min="0" step="0.1">
                                        <span class="input-group-text" id="lbl_w">cm</span>
                                    </div>
                                    <small class="text-muted text-center d-block mt-1">Width</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="size_height" placeholder="0" min="0" step="0.1">
                                        <span class="input-group-text" id="lbl_h">cm</span>
                                    </div>
                                    <small class="text-muted text-center d-block mt-1">Height</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="size_depth" placeholder="0" min="0" step="0.1">
                                        <span class="input-group-text" id="lbl_d">cm</span>
                                    </div>
                                    <small class="text-muted text-center d-block mt-1">Depth</small>
                                </div>
                            </div>
                            <small class="text-muted">Leave blank if not applicable.</small>
                        </div>



                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="item_weight" class="form-label">Item Weight</label>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="<?php echo URL_ROOT ?>/units/weight-unit/add-weight-unit.php"><small>Add Unit</small></a>
                                </div>
                            </div>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="item_weight"
                                    name="item_weight"
                                    placeholder="Enter weight"
                                    step="0.01"
                                    min="0">

                                <span class="input-group-text p-0">

                                    <select
                                        class="form-select border-0"
                                        id="weight_unit"
                                        name="weight_unit">
                                        <?php foreach ($rows_weight_unit as $unit): ?>
                                            <option value="<?= $unit['id'] ?>" data-symbol="<?= htmlspecialchars($unit['symbol']) ?>">
                                                <?= htmlspecialchars($unit['name']) ?> (<?= htmlspecialchars($unit['symbol']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="item_adjustable">Item Adjustable</label>
                            <select name="item_adjustable" id="item_adjustable" class="form-control">
                                <option value="">___Select___</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="item_serial_number">Item Serial Number</label>
                            <input type="text" class="form-control" id="item_serial_number" name="item_serial_number" placeholder="E420456789">
                        </div>
                        <div class="form-group">
                            <label for="item_brand">Item Brand</label>
                            <input type="text" class="form-control" id="item_brand" name="item_brand" placeholder="Enter item brand">
                        </div>
                        <div class="form-group">
                            <label for="item_model">Item Model</label>
                            <input type="text" class="form-control" id="item_model" name="item_model" placeholder="Enter item model">
                        </div>
                        <!-- <div class="form-group">
                            <label for="item_purchased_date">Item Puchased Date</label>
                            <input type="date" class="form-control" id="item_purchased_date" name="item_purchased_date">
                        </div> -->
<!-- 
                        <div class="form-group">
                            <label for="item_purchase_price">Item Puchased Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="item_purchase_price" name="item_purchase_price" placeholder="e.g. 1500.00">
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="warranty_expiry">Warranty Expiry</label>
                            <input type="date" class="form-control" id="warranty_expiry" name="warranty_expiry">
                        </div> -->
                      
                        <!-- 
                        <div class="form-group">
                            <label for="last_maintenance_date">Item Last Maintenance Date</label>
                            <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date">
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="next_maintenance_date">Item Next Maintenance Date</label>
                            <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date">
                        </div> -->

                        <div class="form-group">
                            <label for="item_location">Item Location</label>
                            <input type="text" class="form-control" id="item_location" name="item_location" placeholder="Enter item location">
                        </div>
                        <!-- <div class="form-group">
                            <label for="item_status">Lifecycle status</label>
                            <select name="item_status" id="item_status" class="form-control">
                                <option value="">___Select___</option>
                                <option value="active">Active</option>
                                <option value="in-repair">In Repair</option>
                                <option value="in-storage">In Storage</option>
                                <option value="decommissioned">Decommissioned</option>

                            </select>
                        </div> -->

                        <div class="form-group">
                            <label for="item_notes">Notes</label>
                            <textarea class="form-control" id="item_notes" name="item_notes" placeholder="Enter item notes"></textarea>
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
        const typeOptions = document.querySelectorAll('#type_id option');

        // filter types by category
        typeOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else if (option.dataset.cat === cat_id) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // reset type and material dropdowns
        document.getElementById('type_id').value = '';
        document.getElementById('material_id').value = '';

        // hide all material options and the material field
        document.querySelectorAll('#material_id option').forEach(option => {
            if (option.value !== '') option.style.display = 'none';
        });
        // document.getElementById('material_field').style.display = 'none';
    }

    function filterMaterials() {
        const type_id = document.getElementById('type_id').value;
        const materialOptions = document.querySelectorAll('#item_material option');
        let hasVisible = false;

        materialOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else if (option.dataset.type === type_id) {
                option.style.display = 'block';
                hasVisible = true;
            } else {
                option.style.display = 'none';
            }
        });

        document.getElementById('item_material').value = '';

        // only show material field if selected type has materials
        // document.getElementById('material_field').style.display = hasVisible ? 'block' : 'none';
    }
    const itemMaterialSelect = document.getElementById('item_material');
    const materialOtherInput = document.getElementById('material_other');
    itemMaterialSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            materialOtherInput.style.display = 'block';
        } else {
            materialOtherInput.style.display = 'none';
            materialOtherInput.value = '';
        }
    });

    function updateSizeLabels() {
        const sel = document.getElementById('unit_select');
        const symbol = sel.options[sel.selectedIndex].dataset.symbol;
        document.getElementById('lbl_w').textContent = symbol;
        document.getElementById('lbl_h').textContent = symbol;
        document.getElementById('lbl_d').textContent = symbol;
    }
</script>