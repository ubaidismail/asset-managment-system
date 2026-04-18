<?php

// get items only which are added in inventory table
$get_items = mysqli_query($conn, "SELECT * FROM DigiInventoryItems WHERE status = 1 AND ItemID IN (SELECT ItemID FROM DigiInventoryItemAssignments WHERE status = 1)");
$get_campuses = Campus::getAll();
$get_buildings = Building::getAll();
$get_rooms = Rooms::getAll();
$assets_type = AssetsType::getAll();
$assets_sub_type = AssetsSubType::getAll();

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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="CampusID">Select Campus</label>
                                    <select class="form-select form-select-sm" name="CampusID" id="CampusID" onChange="onChangeCampus(this.value)">
                                        <option value="">___Select___</option>
                                        <?php
                                        if (!empty($get_campuses)) {
                                            $count = 0;
                                            foreach ($get_campuses as $row) {
                                                $id = $row['CampusID'];
                                                $name = $row['CampusFullName'];
                                                // get from cookie
                                                $selectedCampus = $_COOKIE['selectedCampus'] ?? '';
                                                $selected  = ($selectedCampus == $id) ? 'selected' : '';
                                        ?>
                                                <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>



                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="BuildingID">Select Building</label>
                                    <select class="form-select form-select-sm" name="BuildingID" id="BuildingID" onChange="onChangeBuilding(this.value)">
                                        <option value="">___Select___</option>
                                        <?php
                                        if (!empty($get_buildings)) {
                                            $count = 0;
                                            foreach ($get_buildings as $row) {
                                                $id = $row['BuildingID'];
                                                $name = $row['BuildingName'];
                                                $campus_id = $row['CampusID'];
                                                $selectedBuilding = $_COOKIE['selectedBuilding'] ?? '';
                                                $selected  = ($selectedBuilding == $id) ? 'selected' : '';
                                        ?>
                                                <option value="<?php echo $id; ?>" <?php echo $selected; ?> data-campus="<?php echo $campus_id; ?>" style="display:none;"><?php echo $name; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="RoomID">Select Room</label>
                            <select class="form-select form-select-sm" name="RoomID" id="RoomID">
                                <option value="">___Select___</option>
                                <?php
                                if (!empty($get_rooms)) {
                                    $count = 0;
                                    foreach ($get_rooms as $row) {
                                        $BuildingID = $row['BuildingID'];
                                        $name = $row['RoomName'];
                                        $id = $row['RoomID'];
                                ?>
                                        <option value="<?php echo $id; ?>" data-building="<?php echo $BuildingID; ?>" style="display:none;"><?php echo $name; ?> <?php echo '#' . $id; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item_id">Select Item</label>
                            <select class="form-select form-select-sm js-example-responsive" width="100%" name="item_id" id="item_id">
                                <option value="">___Select___</option>
                                <?php
                                if (!empty($get_items)) {
                                    $count = 0;
                                    foreach ($get_items as $row) {
                                        $id = $row['ItemID'];
                                        $name = $row['FullName'];
                                        $Picture = $row['Picture'];
                                ?>
                                        <option value="<?php echo $id; ?>" data-img="<?= $row['Picture']; ?>"><?php echo $name; ?></option>

                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="asset_name">Asset Name</label>
                            <input type="text" class="form-control" id="asset_name" name="asset_name" placeholder="Enter asset name">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asset_type">Asset Type</label>
                                    <select class="form-select form-select-sm" name="asset_type" id="asset_type" onChange="onChangeAssetType(this.value)">
                                        <option value="">___Select___</option>
                                        <?php
                                        if (!empty($assets_type)) {
                                            $count = 0;
                                            foreach ($assets_type as $row) {
                                                $name = $row['AssetsTypeName'];
                                                $id = $row['AssetsTypeID'];
                                        ?>
                                                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asset_sub_type">Asset Sub Type</label>
                                    <select class="form-select form-select-sm" name="asset_sub_type" id="asset_sub_type">
                                        <option value="">___Select___</option>
                                        <?php
                                        if (!empty($assets_sub_type)) {
                                            $count = 0;
                                            foreach ($assets_sub_type as $row) {
                                                $asset_type_ID = $row['AssetsTypeID'];
                                                $name = $row['AssetsSubTypeName'];
                                                $id = $row['AssetsSubTypeID'];
                                        ?>
                                                <option value="<?php echo $id; ?>" data-assettype="<?php echo $asset_type_ID; ?>" style="display:none;"><?php echo $name; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
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

<script>
    function onChangeCampus(campusId) {
        const buildingOptions = document.querySelectorAll('#BuildingID option');
        // add in cookie
        document.cookie = "selectedCampus=" + campusId + "; path=/";
        // filter buildings by selected campus
        buildingOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else if (option.dataset.campus === campusId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // reset building dropdown
        document.getElementById('BuildingID').value = '';
    }

    function onChangeBuilding(BuildingID) {
        const roomgOptions = document.querySelectorAll('#RoomID option');
     // add in cookie
        document.cookie = "selectedBuilding=" + BuildingID + "; path=/";
        // filter buildings by selected campus
        roomgOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else if (option.dataset.building === BuildingID) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // reset building dropdown
        document.getElementById('RoomID').value = '';
    }

    function onChangeAssetType(AssetTypeID) {
        const assetsubtypeOptions = document.querySelectorAll('#asset_sub_type option');

        assetsubtypeOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else if (option.dataset.assettype === AssetTypeID) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // reset building dropdown
        document.getElementById('asset_sub_type').value = '';
    }
   
</script>